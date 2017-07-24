<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\UserBundle\Tests\Command;

use FOS\UserBundle\Command\DemoteUserCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\DependencyInjection\ContainerInterface;

class DemoteUserCommandTest extends \PHPUnit_Framework_TestCase
{
    public function testExecute()
    {
        $commandTester = $this->createCommandTester($this->getContainer('user', 'role', false));
        $exitCode = $commandTester->execute(array(
            'username' => 'user',
            'role' => 'role',
        ), array(
            'decorated' => false,
            'interactive' => false,
        ));

        $this->assertSame(0, $exitCode, 'Returns 0 in case of success');
        $this->assertRegExp('/Role "role" has been removed from user "user"/', $commandTester->getDisplay());
    }

    public function testExecuteInteractiveWithQuestionHelper()
    {
        $application = new Application();

        $helper = $this->getMockBuilder('Symfony\Component\Console\Helper\QuestionHelper')
            ->setMethods(array('ask'))
            ->getMock();

        $helper->expects($this->at(0))
            ->method('ask')
            ->will($this->returnValue('user'));
        $helper->expects($this->at(1))
            ->method('ask')
            ->will($this->returnValue('role'));

        $application->getHelperSet()->set($helper, 'question');

        $commandTester = $this->createCommandTester($this->getContainer('user', 'role', false), $application);
        $exitCode = $commandTester->execute(array(), array(
            'decorated' => false,
            'interactive' => true,
        ));

        $this->assertSame(0, $exitCode, 'Returns 0 in case of success');
        $this->assertRegExp('/Role "role" has been removed from user "user"/', $commandTester->getDisplay());
    }

    /**
     * @param ContainerInterface $container
     * @param Application|null   $application
     *
     * @return CommandTester
     */
    private function createCommandTester(ContainerInterface $container, Application $application = null)
    {
        if (null === $application) {
            $application = new Application();
        }

        $application->setAutoExit(false);

        $command = new DemoteUserCommand();
        $command->setContainer($container);

        $application->add($command);

        return new CommandTester($application->find('fos:user:demote'));
    }

    /**
     * @param $username
     * @param $role
     * @param $super
     *
     * @return mixed
     */
    private function getContainer($username, $role, $super)
    {
        $container = $this->getMockBuilder('Symfony\Component\DependencyInjection\ContainerInterface')->getMock();

        $manipulator = $this->getMockBuilder('FOS\UserBundle\Util\UserManipulator')
            ->disableOriginalConstructor()
            ->getMock();

        if ($super) {
            $manipulator
                ->expects($this->once())
                ->method('demote')
                ->with($username)
                ->will($this->returnValue(true))
            ;
        } else {
            $manipulator
                ->expects($this->once())
                ->method('removeRole')
                ->with($username, $role)
                ->will($this->returnValue(true))
            ;
        }

        $container
            ->expects($this->once())
            ->method('get')
            ->with('fos_user.util.user_manipulator')
            ->will($this->returnValue($manipulator));

        return $container;
    }
}
