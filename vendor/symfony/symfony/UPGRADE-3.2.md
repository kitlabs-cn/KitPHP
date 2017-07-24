UPGRADE FROM 3.1 to 3.2
=======================

BrowserKit
----------

 * Client HTTP user agent has been changed to 'Symfony BrowserKit' (was 'Symfony2 BrowserKit' before).

FrameworkBundle
---------------

 * The `doctrine/annotations` dependency has been removed; require it via `composer
   require doctrine/annotations` if you are using annotations in your project
 * The `symfony/security-core` and `symfony/security-csrf` dependencies have
   been removed; require them via `composer require symfony/security-core
   symfony/security-csrf` if you depend on them and don't already depend on
   `symfony/symfony`
 * The `symfony/templating` dependency has been removed; require it via `composer
   require symfony/templating` if you depend on it and don't already depend on
   `symfony/symfony`
 * The `symfony/translation` dependency has been removed; require it via `composer
   require symfony/translation` if you depend on it and don't already depend on
   `symfony/symfony`
 * The `symfony/asset` dependency has been removed; require it via `composer
   require symfony/asset` if you depend on it and don't already depend on
   `symfony/symfony`
 * The `Resources/public/images/*` files have been removed.
 * The `Resources/public/css/*.css` files have been removed (they are now inlined
   in TwigBundle).

Console
-------

 * Setting unknown style options is deprecated and will throw an exception in
   Symfony 4.0.

DependencyInjection
-------------------

 * Calling `get()` on a `ContainerBuilder` instance before compiling the
   container is deprecated and will throw an exception in Symfony 4.0.

ExpressionLanguage
-------------------

* Passing a `ParserCacheInterface` instance to the `ExpressionLanguage` has been
  deprecated and will not be supported in Symfony 4.0. You should use the
  `CacheItemPoolInterface` interface instead.

Form
----

 * Calling `isValid()` on a `Form` instance before submitting it
   is deprecated and will throw an exception in Symfony 4.0.

   Before:

   ```php
   if ($form->isValid()) {
       // ...
   }
   ```

   After:

   ```php
   if ($form->isSubmitted() && $form->isValid()) {
       // ...
   }
   ```

FrameworkBundle
---------------

 * The service `serializer.mapping.cache.doctrine.apc` is deprecated. APCu should now
   be automatically used when available.

HttpKernel
----------

 * `DataCollector::varToString()` is deprecated and will be removed in Symfony
   4.0. Use the `cloneVar()` method instead.

 * Surrogate name in a `Surrogate-Capability` HTTP request header has been changed to 'symfony'.

   Before:
   ```
   Surrogate-Capability: symfony2="ESI/1.0"
   ```

   After:
   ```
   Surrogate-Capability: symfony="ESI/1.0"
   ```

HttpFoundation
---------------

  * Extending the following methods of `Response`
    is deprecated (these methods will be `final` in 4.0):

     - `setDate`/`getDate`
     - `setExpires`/`getExpires`
     - `setLastModified`/`getLastModified`
     - `setProtocolVersion`/`getProtocolVersion`
     - `setStatusCode`/`getStatusCode`
     - `setCharset`/`getCharset`
     - `setPrivate`/`setPublic`
     - `getAge`
     - `getMaxAge`/`setMaxAge`
     - `setSharedMaxAge`
     - `getTtl`/`setTtl`
     - `setClientTtl`
     - `getEtag`/`setEtag`
     - `hasVary`/`getVary`/`setVary`
     - `isInvalid`/`isSuccessful`/`isRedirection`/`isClientError`/`isServerError`
     - `isOk`/`isForbidden`/`isNotFound`/`isRedirect`/`isEmpty`

TwigBridge
----------

 * Deprecated the possibility to inject the Form Twig Renderer into the form
   extension. Inject it into the `TwigRendererEngine` instead.

Validator
---------

 * `Tests\Constraints\AbstractConstraintValidatorTest` has been deprecated in
   favor of `Test\ConstraintValidatorTestCase`.

   Before:

   ```php
   // ...
   use Symfony\Component\Validator\Tests\Constraints\AbstractConstraintValidatorTest;

   class MyCustomValidatorTest extends AbstractConstraintValidatorTest
   {
       // ...
   }
   ```

   After:

   ```php
   // ...
   use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

   class MyCustomValidatorTest extends ConstraintValidatorTestCase
   {
       // ...
   }
   ```

 * Setting the strict option of the `Choice` Constraint to `false` has been
   deprecated and the option will be changed to `true` as of 4.0.

   ```php
   // ...
   use Symfony\Component\Validator\Constraints as Assert;

   class MyEntity
   {
       /**
        * @Assert\Choice(choices={"MR", "MRS"}, strict=true)
        */
       private $salutation;
   }
   ```

Yaml
----

 * Support for silently ignoring duplicate mapping keys in YAML has been
   deprecated and will lead to a `ParseException` in Symfony 4.0.

 * Mappings with a colon (`:`) that is not followed by a whitespace are deprecated
   and will lead to a `ParseException` in Symfony 4.0 (e.g. `foo:bar` must be
   `foo: bar`).
