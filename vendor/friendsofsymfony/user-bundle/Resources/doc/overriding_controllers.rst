Overriding Default FOSUserBundle Controllers
============================================

The default controllers packaged with the FOSUserBundle provide a lot of
functionality that is sufficient for general use cases. But, you might find
that you need to extend that functionality and add some logic that suits the
specific needs of your application.

.. caution::

    Overriding the controller requires to duplicate all the logic of the
    action. Most of the time, it is easier to use the :doc:`events </controller_events>`
    to implement the functionality. Replacing the whole controller should
    be considered as the last solution when nothing else is possible.

The first step to overriding a controller in the bundle is to configure
FOSUserBundle to be a parent of your ``AppBundle``.

.. code-block:: php

    <?php
    // src/AppBundle/AppBundle.php

    namespace AppBundle;

    use Symfony\Component\HttpKernel\Bundle\Bundle;

    class AppBundle extends Bundle
    {
        public function getParent()
        {
            return 'FOSUserBundle';
        }
    }

.. note::

    The Symfony Framework only allows a bundle to have one child. You cannot
    create another bundle that is also a child of FOSUserBundle.

.. note::

    You could also create a new child bundle and declare it as a child of FOSUserBundle.

Now that your bundle is correctly configured you can simply create a controller class
with the same name and in the same location as the one you want to override. This
example overrides the ``RegistrationController`` by extending the FOSUserBundle
``RegistrationController`` class and simply overriding the method that needs the extra
functionality.

The example below overrides the ``registerAction`` method. It uses the code from
the base controller and adds logging a new user registration to it.

.. code-block:: php

    <?php
    // src/AppBundle/Controller/RegistrationController.php

    namespace AppBundle\Controller;

    use Symfony\Component\HttpFoundation\RedirectResponse;
    use FOS\UserBundle\Controller\RegistrationController as BaseController;
    use Symfony\Component\HttpFoundation\Request;

    class RegistrationController extends BaseController
    {
        public function registerAction(Request $request)
        {
            $form = $this->container->get('fos_user.registration.form');
            $formHandler = $this->container->get('fos_user.registration.form.handler');
            $confirmationEnabled = $this->container->getParameter('fos_user.registration.confirmation.enabled');

            $process = $formHandler->process($confirmationEnabled);
            if ($process) {
                $user = $form->getData();

                /*****************************************************
                 * Add new functionality (e.g. log the registration) *
                 *****************************************************/
                $this->container->get('logger')->info(
                    sprintf('New user registration: %s', $user)
                );

                if ($confirmationEnabled) {
                    $this->container->get('session')->set('fos_user_send_confirmation_email/email', $user->getEmail());
                    $route = 'fos_user_registration_check_email';
                } else {
                    $this->authenticateUser($user);
                    $route = 'fos_user_registration_confirmed';
                }

                $this->setFlash('fos_user_success', 'registration.flash.user_created');
                $url = $this->container->get('router')->generate($route);

                return new RedirectResponse($url);
            }

            return $this->container->get('templating')->renderResponse('FOSUserBundle:Registration:register.html.twig', array(
                'form' => $form->createView(),
            ));
        }
    }

.. note::

    If you do not extend the FOSUserBundle controller class that you want
    to override and instead extend ContainerAware or the Controller class
    provided by the FrameworkBundle then you must implement all of the methods
    of the FOSUserBundle controller that you are overriding.
