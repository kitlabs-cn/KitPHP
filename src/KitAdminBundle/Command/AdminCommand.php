<?php
namespace KitAdminBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputOption;
use KitRbacBundle\Entity\User;
use KitRbacBundle\Entity\Role;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class AdminCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this->setName('kit:admin:generate')
            ->addOption('username', 'u', InputOption::VALUE_OPTIONAL, 'admin username')
            ->addOption('password', 'p', InputOption::VALUE_OPTIONAL, 'admin password')
            ->setDescription('generate admin account.')
            ->setHelp("This command generate admin account ...");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username = $input->getOption('username');
        $password = $input->getOption('password');
        if(empty($username)){
            $username = 'admin';
        }
        if(empty($password)){
            $password = 'admin';
        }
        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion('generate account username:'.$username.', password='.$password.'?(enter yes|no)', false);
        
        if (!$helper->ask($input, $output, $question)) {
            return;
        }
        $this->generate($username, $password, $output);
        $output->writeln([
            'generate success'
        ]);
    }

    /**
     *
     * @param unknown $type            
     * @param OutputInterface $output            
     * @param unknown $startDate            
     * @param unknown $endDate            
     * @param unknown $pagesize            
     */
    private function generate($username, $password, OutputInterface $output)
    {
        /**
         * 
         * @var \Doctrine\Bundle\DoctrineBundle\Registry $doctrine
         */
        $doctrine = $this->getContainer()->get('doctrine');
        $em = $doctrine->getManager();
        try {
            $roleList = $doctrine->getRepository('KitRbacBundle:Role')->findAll();
            if(empty($roleList) || !isset($roleList[0])){
                $role = new Role();
                $role->setRolename('超级管理员');
                $role->setIp('127.0.0.1');
                $role->setNote('脚本自动生');
                $role->setStatus(1);
                $em->persist($role);
            }else{
                $role = $roleList[0];
            }
            $user = new User();
            $user->setUsername($username);
            $user->setPassword($password);
            $user->setRole('ROLE_ADMIN');
            $user->setGroup($role);
            $user->setIp('127.0.0.1');
            $user->setStatus(1);
            $em->persist($user);
            $em->flush();
        }catch (\Exception $e) {
            $output->writeln([
                'Exception',
                'code:' . $e->getCode(),
                'msg:'. $e->getMessage()
            ]);
            exit();
        }
    }
}