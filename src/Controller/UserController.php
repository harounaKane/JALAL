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
     * @Route("/user", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository)
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
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
            $user->setState('actif');
            $user->setPassword(password_hash($user->getPassword(), PASSWORD_DEFAULT));

            //avatar
            if( $form->get('avatar')->getData() != null ) {

                $image = $form->get('avatar')->getData();
                $file_name = $user->getLogin() . '_avatar' . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('avatar_directory'),
                    $file_name
                );
                $user->setAvatar($file_name);
            }

            try {
                $this->manager->persist($user);
                $this->manager->flush();

                //CONNEXION AUTOMATIQUE
                $session = $request->getSession();
                $session->set("user", $user);

                $this->addFlash("success", "Incription réussie. Vous êtes connectés");

                return $this->redirectToRoute("accueil");

            }catch (UniqueConstraintViolationException $e){
                $this->addFlash("warning", "Incription incorrecte. Ressayer en changeant de login !");
            }
        }

        return $this->render('user/inscription.html.twig', ['form' => $form->createView(), "isModification" => false]);
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
            $userInfo = $userRepository->connexionUser($login);

            if( $userInfo && password_verify($mdp, $userInfo->getPassword()) ){
                $session = $request->getSession();
                $session->set("user", $userInfo);

                $this->addFlash("success", "Bienvenue " . $userInfo->getFirstName() . " " . $userInfo->getLastName() );
                
                return $this->redirectToRoute("accueil");
            }
            $this->addFlash("warning", "Login et/ou mot de passe incorrect");
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
     * @Route("/user_profil/{id}", name="profil_user", methods={"GET", "POST"})
     */
    public function profilUser(Request $request, User $user, UserRepository $userRepository)
    {
        $avatar = $user->getAvatar();
        $editForm = $this->createForm(UserType::class, $user, [ 'usePassword' => false ]);
        $editForm->handleRequest($request);

        $mdpForm = $this->updatePassword();
        $mdpForm->handleRequest($request);

        if ($mdpForm->isSubmitted() && $mdpForm->isValid()) {
            $oldMdp = $mdpForm->get('oldPassword')->getData();
            $userInfo = $userRepository->connexionUser($user->getLogin());

            if( $userInfo && password_verify($oldMdp, $userInfo->getPassword()) ){

                $user->setPassword(password_hash($mdpForm->get('password')->getData(), PASSWORD_DEFAULT));

                $this->manager->flush();

                $this->addFlash('success', 'Le mot de passe a été changé');

                return $this->redirectToRoute('profil', [
                    'id' => $user->getId(),
                ]);
            }
            //oldMdp incorrect
            $this->addFlash("warning", "Mot de passe saisi incorrect ! ");
        }

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            if( $editForm->get('avatar')->getData() != null ){
                if( file_exists($this->getParameter('avatar_directory').'/'.$avatar) ){
                    unlink( $this->getParameter('avatar_directory').'/'.$avatar );
                }
                $image = $editForm->get('avatar')->getData();
                $file_name =  $user->getLogin().'_avatar'.'.'.$image->guessExtension();
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
                $this->manager->flush();
                $this->addFlash('success', 'Le profil a été mis à jour');

                return $this->redirectToRoute('profil', [
                    'id'=> $user->getId(),
                ]);

            }catch (UniqueConstraintViolationException $e){
                $this->addFlash('warning','Le profil n\'a pas pu être mis à jour');
            }
        }

        return $this->render('user/profil.html.twig', [
            'user' => $user,
            'form' => $editForm->createView(),
            'mdpForm' => $mdpForm->createView(),
            "isModification" => true
        ]);
    }

    /**
     * @Route("/user_edit/{id}", name="profil_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, User $user, UserRepository $userRepository)
    {
        $avatar = $user->getAvatar();
        $editForm = $this->createForm(UserType::class, $user, [ 'usePassword' => false ]);
        $editForm->handleRequest($request);

        $mdpForm = $this->updatePassword();
        $mdpForm->handleRequest($request);

        if ($mdpForm->isSubmitted() && $mdpForm->isValid()) {
            $oldMdp = $mdpForm->get('oldPassword')->getData();
            $userInfo = $userRepository->connexionUser($user->getLogin());

            if( $userInfo && password_verify($oldMdp, $userInfo->getPassword()) ){
                $user->setPassword(password_hash($mdpForm->get('password')->getData(), PASSWORD_DEFAULT));

                $this->manager->flush();
                $this->addFlash('success', 'Le mot de passe a été changé' );

                return $this->redirectToRoute('profil_edit', [
                    'id' => $user->getId(),
                ]);
            }

            //oldMdp incorrect
            $this->addFlash("warning", "Mot de passe saisi incorrect ! ");
        }

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $user->setStatus( $request->get('status') );

            if( $editForm->get('avatar')->getData() != null ){
                if( file_exists($this->getParameter('avatar_directory').'/'.$avatar) ){
                    unlink( $this->getParameter('avatar_directory').'/'.$avatar );
                }
                $image = $editForm->get('avatar')->getData();
                $file_name =  $user->getLogin().'_avatar'.'.'.$image->guessExtension();

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
                $this->manager->flush();

                $this->addFlash('success', 'Le profil a été mis à jour');

                return $this->redirectToRoute('profil', [
                    'id'=> $user->getId(),
                ]);

            }catch (UniqueConstraintViolationException $e){
                $this->addFlash('warning', 'Le profil n\'a pas été mis à jour');
            }
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $editForm->createView(),
            'mdpForm' => $mdpForm->createView(),
            "isModification" => true
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user)
    {
        $user_log_status = $request->getSession()->get('user')->getStatus();
        $user_log_id = $request->getSession()->get('user')->getId();
        $userCurrentId = $user->getId();

        if( $user->getAvatar() != null ){
            if ( file_exists($this->getParameter('avatar_directory') . '/' . $user->getAvatar()) )
                unlink(($this->getParameter('avatar_directory') . '/' . $user->getAvatar()));
        }

        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        $this->addFlash("success", "Le compte est supprimé !");

        //SI NOT ADMIN, DECONNEXION. OU SI ADMIN QUI SUPPRIME SON COMPTE
        if( $user_log_status == "utilisateur" || ($user_log_status == "admin" && $user_log_id == $userCurrentId) ){
            return $this->redirectToRoute('deconnexion');
        }

        return $this->redirectToRoute('user_index');
    }

    /**
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
