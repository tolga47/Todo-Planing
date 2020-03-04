<?php

namespace App\Controller;

use App\Entity\Developer;
use App\Entity\Work;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        
        $entityManager = $this->getDoctrine()->getManager();

        $developerRepository = $entityManager->getRepository(Developer::class);
        $taskRepository = $entityManager->getRepository(Work::class);

        $tasks = $taskRepository->findAll();
        $developers = $developerRepository->findAll();
        
        $developerList = [];
        $totalTime = 0;
        foreach($developers as $developer){
            $developerInfo = array('id'=>$developer->getId(), 'username'=> $developer->getUsername(), 'time'=> 45* $developer->getMultiplier(), 'tasks'=> [], 'used'=> 0);
            array_push($developerList, $developerInfo);
            $totalTime += $developer->getMultiplier();
        }
        $totalTime = 45 * $totalTime;
        usort($developerList, function($a, $b) {
            return $b['time'] <=> $a['time'];
        });

        $taskList = [];
        $totalTasks = 0;
        foreach($tasks as $task){
            $taskInfo = array('id'=>$task->getId(), 'name'=> $task->getTaskname(), 'time'=> $task->getMultiplier() * $task->getWorktime());
            array_push($taskList, $taskInfo);
            $totalTasks += ($task->getWorktime() * $task->getMultiplier());
        }
        usort($taskList, function($a, $b) {
            return $b['time'] <=> $a['time'];
        });

        foreach($taskList as $task){
            foreach($developerList as $key => $dev){
                if($dev['used'] <= $dev['time'] && ($dev['time'] - $dev['used']) >= $task['time']){
                    $taskValues = array('name'=>$task['name'], 'time'=>round($task['time'] / 45, 1));
                    $developerList[$key]['used'] += $task['time'];
                    array_push($developerList[$key]['tasks'], $taskValues);
                }
            }
        }

        $data['developers'] = $developerList;
        return $this->render('index.html.twig', $data);
    }
}
