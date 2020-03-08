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
        $task = new task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $task = $form->getData();

            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('task');
        };
        $taskRepository = $this->getDoctrine()
        ->getRepository(task::class)
        ->findAll();
        return $this->render('task/index.html.twig', [
        'task' => $taskRepository,
        'formulaireTask' => $form->createView(),
        ]);
    }
}
        
