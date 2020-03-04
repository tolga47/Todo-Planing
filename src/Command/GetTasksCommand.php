<?php
namespace App\Command;

use App\Entity\Work;
use App\Entity\Apilist;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpClient\HttpClient;
use Doctrine\ORM\EntityManagerInterface;

class GetTasksCommand extends Command
{
    protected static $defaultName = 'get-tasks';
 
    protected function configure()
    {
       $this
        ->setDescription('Is listesini getirme')
        ->setHelp('Apiden gelen isleri db de gunceller.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Veriler aliniyor...',
            '============',
            ''
        ]);

        $taskList = [];
        
        $kernel = $this->getApplication()->getKernel();
        $container = $kernel->getContainer();
        $apiLists = $container->get('doctrine')->getRepository(Apilist::class);
        $apiLists = $apiLists->findAll();
        
        foreach($apiLists as $apiInfo){
            $httpClient = HttpClient::create();
            $response = $httpClient->request('GET', $apiInfo->getApiurl());
            $statusCode = $response->getStatusCode();
            if($statusCode == 200) {
                $contents = $response->toArray();
                foreach($contents as $content){
                    $time = 0;
                    $multiplier = 0;
                    $task = '';

                    foreach($content as $key => $keyValue){
                        if(is_array($keyValue)){
                            $task = $key;
                            foreach($keyValue as $keySub => $keyValueSub){
                                if($keySub == $apiInfo->getMultiplierfield()){
                                    $multiplier = $keyValueSub;
                                }
                                else if($keySub == $apiInfo->getSurefield()){
                                    $time = $keyValueSub;
                                }
                            }
                        }else{
                            if($key == $apiInfo->getMultiplierfield()){
                                $multiplier = $keyValue;
                            }
                            else if($key == $apiInfo->getSurefield()){
                                $time = $keyValue;
                            }
                            else if($key == $apiInfo->getIdfield()){
                                $task = $keyValue;
                            }
                        }
                    }
                    $taskInfo = array('taskname' => $task, 'worktime' => $time, 'multiplier' => $multiplier);
                    array_push($taskList, $taskInfo);
                }
                $output->writeln($apiInfo->getId().'. numarali servisten veriler alindi!');
            }else{
                $output->writeln($apiInfo->getId().'. numarali serviste hata!');
            }
        }

        foreach ($taskList as $task){
            $entityManager = $container->get('doctrine')->getManager();
            $repository = $container->get('doctrine')->getRepository(Work::class);
            $taskControl = $repository->findOneBy(['taskname' => $task['taskname']]);
            
            if(!$taskControl){
                $taskInsert = new Work();
                $taskInsert
                    ->setTaskname($task['taskname'])
                    ->setWorktime($task['worktime'])
                    ->setMultiplier($task['multiplier'])
                ;
                $entityManager->persist($taskInsert);
                $entityManager->flush();
            }
        }

        $output->writeln([
            '',
            '============',
            'Veriler basariyla guncellendi.',
            ''
        ]);

        return 0;
    }
}

