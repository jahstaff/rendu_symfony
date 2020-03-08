<?php
namespace App\Controller;
use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\TaskType;
use Symfony\Component\HttpFoundation\Request;

class TaskController extends AbstractController
{
    /**
     * @Route("/task", name="task")
     */
    public function index(EntityManagerInterface $entityManager, Request $request)
    {
        $newTask = new Task();

        $form = $this->createForm(TaskType::class, $newTask);
        $form->handleRequest($request);
    
        $TaskRepository = $this->getDoctrine()
                        ->getRepository(Task::class);

        if ($form->isSubmitted() && $form->isValid()){

            $task = $TaskRepository->find($request->request->get('UserId'));
            
            $newTask = $form->getData();
            $newTask->setTaskId($task);
            $newTask->setCreatedAt(new \DateTime());

            $entityManager->persist($newTask);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        $task = $this->$TaskRepository = $this->getDoctrine()
        ->getRepository(Task::class)->findAll();
        $user = $UserRepository->findAll();

        return $this->render('task/index.html.twig', [
            'task' => $task,
            'TaskForm' => $form->createView(),
        ]);
    }
}