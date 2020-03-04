<?php
namespace App\Command;

use App\Entity\Developer;
use App\Entity\Apilist;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpClient\HttpClient;
use Doctrine\ORM\EntityManagerInterface;

class InstallDbCommand extends Command
{
    protected static $defaultName = 'install-db';
 
    protected function configure()
    {
       $this
        ->setDescription('DB listesini getirme')
        ->setHelp('')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        
        $kernel = $this->getApplication()->getKernel();
        $container = $kernel->getContainer();
        $entityManager = $container->get('doctrine')->getManager();
        
        $devInsert = new Developer();
        $devInsert->setUsername('DEV1')->setMultiplier(1);
        $entityManager->persist($devInsert);

        $devInsert = new Developer();
        $devInsert->setUsername('DEV2')->setMultiplier(2);
        $entityManager->persist($devInsert);
        
        $devInsert = new Developer();
        $devInsert->setUsername('DEV3')->setMultiplier(3);
        $entityManager->persist($devInsert);
        
        $devInsert = new Developer();
        $devInsert->setUsername('DEV4')->setMultiplier(4);
        $entityManager->persist($devInsert);
        
        $devInsert = new Developer();
        $devInsert->setUsername('DEV5')->setMultiplier(5);
        $entityManager->persist($devInsert);

        $apiInsert = new Apilist();
        $apiInsert->setApiurl('http://www.mocky.io/v2/5d47f24c330000623fa3ebfa')->setIdfield('id')->setSurefield('sure')->setMultiplierfield('zorluk');
        $entityManager->persist($apiInsert);

        $apiInsert = new Apilist();
        $apiInsert->setApiurl('http://www.mocky.io/v2/5d47f235330000623fa3ebf7')->setIdfield('0')->setSurefield('estimated_duration')->setMultiplierfield('level');
        $entityManager->persist($apiInsert);
        
        $entityManager->flush();

        $output->writeln([
            '',
            '============',
            'Veriler basariyla guncellendi.',
            ''
        ]);

        return 0;
    }
}

