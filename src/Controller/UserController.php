<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private $manager;
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/user_inscription", name="inscription")
     */
    public function inscription(Request $request){

        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() ){
            $user->setCreatedAt(new \DateTime());
            $user->setStatus('utilisateur');
            $user->setPassword(password_hash($user->getPassword(), PASSWORD_DEFAULT));

            try {
                $this->manager->persist($user);
                $this->manager->flush();
            }catch (UniqueConstraintViolationException $e){

            }
            return $this->redirectToRoute("accueil");
        }

        return $this->render('user/inscription.html.twig', ['form' => $form->createView()]);
    }
}
