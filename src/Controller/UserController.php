<?php
namespace App\Controller;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{
    /**
     * @Route("/", name="user")
     */
    public function index(EntityManagerInterface $entityManager, Request $request)
    {
        $user = new user();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user');
        };
        $userRepository = $this->getDoctrine()
        ->getRepository(user::class)
        ->findAll();
        return $this->render('user/index.html.twig', [
        'user' => $userRepository,
        'formulaireUser' => $form->createView(),
        ]);
    }
}
        
