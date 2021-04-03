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
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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
        $avatar = $user->getAvatar();
        $user_login = $request->getSession()->get('login');
        $editForm = $this->createForm(UserType::class, $user, [ 'usePassword' => false ]);
        $editForm->handleRequest($request);

        $mdpForm = $this->updatePassword();
        $mdpForm->handleRequest($request);

        if ($mdpForm->isSubmitted() && $mdpForm->isValid()) {
            $oldMdp = $mdpForm->get('oldPassword')->getData();
            $userInfo = $userRepository->connexionUser($user_login, $oldMdp);
            if($userInfo){
                $user->setPassword(password_hash($mdpForm->get('password')->getData(), PASSWORD_DEFAULT));
                $this->addFlash(
                    'notice',
                    'Le mot de passe a été changé'
                );
                return $this->redirectToRoute('profil', [
                        'id' => $user->getId(),
                    ]);
            }
        }

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            if( $editForm->get('avatar')->getData() != null ){
                if( file_exists($this->getParameter('avatar_directory').'/'.$avatar) ){
                    unlink( $this->getParameter('avatar_directory').'/'.$avatar );
                }
                $image = $editForm->get('avatar')->getData();
                $file_name =  $user_login.'_avatar' . md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('avatar_directory'),
                    $file_name
                );
                $user->setAvatar($file_name);
            }
            else {
                $user->setAvatar($avatar);
            }
            try {
                $this->manager->persist($user);
                $this->manager->flush();
                $this->addFlash(
                    'notice',
                    'Le profil a été mis à jour'
                );
            }catch (UniqueConstraintViolationException $e){
            }
            
            return $this->redirectToRoute('profil', [
                    'id'=> $user->getId(),
                ]);
        }

        return $this->render('user/profil.html.twig', [
            'user' => $user,
            'editForm' => $editForm->createView(),
            'mdpForm' => $mdpForm->createView(),
        ]);
    }
    
        //paramètre request
        //appel du isSubmitted dans la fonction updatePassword
        //MaJ ROUTE
        /*
         * @Route("/user_profil/{id}", name="profil", methods={"POST"})
         */
    public function updatePassword()
    {
        $form = $this->createFormBuilder()
            ->add('oldPassword', PasswordType::class, [
                "label" => "Mot de passe actuel",
                    'attr' => [
                        'minlength' => 6,
                        'maxlength' => 10
                    ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                "first_options" => ['label' => "Nouveau mot de passe",
                    'help' => '6 à 10 caractères, au moins une majuscule et un chiffre',
                    'attr' => ['minlength' => 6, 'maxlength' => 10, 'pattern' => "(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,10}"]],
                "second_options" => ['label' => "Confirmer le mot de passe",
                    'attr' => ['minlength' => 6, 'maxlength' => 10]]
            ])
            ->add("Enregistrer", SubmitType::class)
            ->getForm();

        
            return $form;
    }

}
