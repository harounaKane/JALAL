<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\ConnexionUserType;
use App\Repository\UserRepository;
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

    /**
     * @Route("/user_connexion", name="connexion")
     */
    public function connexion(Request $request, UserRepository $userRepository){

        $user = new User();
        $form = $this->createForm(ConnexionUserType::class, $user);

        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() ){
            $login = $user->getLogin();
            $mdp = $user->getPassword();

            $userInfo = $userRepository->connexionUser($login, $mdp);
            if($userInfo){
                $session = $request->getSession();
                $session->set('id', $userInfo->getId());
                $session->set('civility', $userInfo->getCivility());
                $session->set('first_name', $userInfo->getFirstName());
                $session->set('last_name', $userInfo->getLastName());
                $session->set('mail', $userInfo->getMail());
                $session->set('login', $userInfo->getLogin());
                $session->set('country', $userInfo->getCountry());
                $session->set('avatar', $userInfo->getAvatar());
                $session->set('status', $userInfo->getStatus());
                
                return $this->redirectToRoute("accueil");
            }
        }

        return $this->render('user/connexion.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/user_deconnexion", name="deconnexion")
     */
    public function deconnexionUser(Request $request){
        $session = $request->getSession();
        $session->clear();

        return $this->redirectToRoute("accueil");
    }

    /**
     * @Route("/user_profil/{id}", name="profil", methods={"GET", "POST"})
     */
    public function profilUser(Request $request, User $user, UserRepository $userRepository)
    {
        $user->setAvatar(NULL);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(password_hash($user->getPassword(), PASSWORD_DEFAULT));
            try {
                $this->manager->persist($user);
                $this->manager->flush();
            }catch (UniqueConstraintViolationException $e){
            }
            return $this->redirectToRoute('profil', ['id'=> $user->getId()]);
        }

        return $this->render('user/profil.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

}
