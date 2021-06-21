<?php
namespace App\Controller;

use App\Entity\Article;
use App\Entity\Commentaire;
use App\Entity\Media;
use App\Entity\User;
use App\Form\ArticleType;
use App\Form\CommentaireType;
use App\Form\MediaType;
use App\Repository\ArticleRepository;
use App\Repository\CommentaireRepository;
use App\Repository\MediaRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class ArticleController extends AbstractController
{
    private $manager;

    public function __construct(EntityManagerInterface $manager){
        $this->manager = $manager;
    }  
    
    /**
     * @Route("admin/articles", name="article_admin", methods={"GET"})
     */
    public function article_admin(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/article_admin.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }
    
    /**
     * @Route("/", name="accueil", methods={"GET"})
     */
    public function index(ArticleRepository $articleRepository, Request $request)
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findBy([], ['art_created_at' => 'DESC']),
            'lastArticle' => $articleRepository->findOneBy([], ['art_created_at' => 'DESC']),
            'articlesRecents' => $articleRepository->findBy([], ['art_created_at' => 'DESC'], 10)
        ]);
    }

    /**
     * @Route("/article/new", name="article_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserRepository $repo, ArticleRepository $articleRepository)
    {
        $article = new Article();
        $media = new Media();
        $form = $this->createForm(ArticleType::class, $article);
        $formMedia = $this->createForm(MediaType::class, $media);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $article->setArtCreatedAt(new \DateTime());
            $article->setUser($repo->idUser($request->getSession()->get('user')->getId()) );
            
            $image = $form->get('main_image')->getData();

            $articleId = $articleRepository->findOneBy([], ['art_created_at' => 'DESC']);
            $file_name =  $articleId->getId().'main_img' . md5(uniqid()) . '.' . $image->guessExtension();
            $image->move(
                $this->getParameter('main_img_directory'),
                $file_name
            );
            $article->setMainImage($file_name);
            try {
                $this->manager->persist($article);
                $this->manager->flush();

                $this->addFlash('success', 'Votre article a bien été ajouté !');

                return $this->redirectToRoute('media_redirect', ['id' => $article->getId()]);

            }catch (UniqueConstraintViolationException $e){
                $this->addFlash('warning', 'Votre article n\'a pas pu être ajouté !');
            }
        }
        return $this->render('article/new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
            'formMedia' => $formMedia->createView()
        ]);
    }

    /**
     * @Route("/article/{id}", name="article_show", methods={"GET", "POST"})
     */
    public function show(Request $request, Article $article, ArticleRepository $repo, CommentaireRepository $commentaireRepository, MediaRepository $mediaRepository): Response
    {
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);

        //TRAITEMENT DES COMMENTAIRES
        $form->handleRequest($request);
        //Si REQUETE AJAX
        if( $request->isXmlHttpRequest() ){
            //RECUP ALL DATA DU COMMENTAIRE
            $commentaire->setUser( $request->get("data")['prenom'] . " " . $request->get('data')['nom'] );
            $commentaire->setComment( $request->get("data")['commentaire'] );
            $commentaire->setCommentAt(new \DateTime());
            $commentaire->setArticle($repo->find($article->getId()));
            $commentaire->setLikeComment(0);
            $commentaire->setUnLikeComment(0);

            $this->manager->persist($commentaire);
            $this->manager->flush();

            //RECUP LAST COMMENTAIRE POUR AJOUTER DOM
            $comment = $commentaireRepository->find($commentaire->getId());
            $commentData = [
                $comment->getId(),
                $comment->getUser(),
                $comment->getCommentAt()->format("d/M/Y à H:i:s"),
                $comment->getComment(),
                $comment->getLikeComment(),
                $comment->getUnlikeComment(),
                [$commentaireRepository->commentByArticle($article->getId())]
            ];
            return new JsonResponse($commentData);
        }

        //RECUPRATION DES COMMENTAIRE DE L'ARTICLE & COMMENTAIRE S'IL Y A
        $commentaires = $commentaireRepository->commentByArticle($article->getId());
        $medias = $mediaRepository->mediaByArticle($article->getId());
        $images = $mediaRepository->imageByArticle($article->getId());
        $audios = $mediaRepository->audioByArticle($article->getId());
        $videos = $mediaRepository->videoByArticle($article->getId());
        $videos_url = $mediaRepository->videoUrlByArticle($article->getId());
        $videos_fichier = $mediaRepository->videoFichierByArticle($article->getId());
        $nb_total_img = count($images);

        return $this->render('article/show.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
            'commentaires' => $commentaires,
            'images' => $images,
            'audios' => $audios,
            'videos_url' => $videos_url,
            'videos_fichier' => $videos_fichier,
            'videos' => $videos,
            'nb_total_img' => $nb_total_img,
            'medias' => $medias,
            'aside' => $repo->findBy(['categorie' => $article->getCategorie()], [], 10),
            'last' => $repo->findBy([], ['art_created_at' => 'DESC'], 10)
        ]);
    }
    
    /**
     * @Route("/article/{id}/articles_user", name="articles_user", methods={"GET","POST"})
     */
    public function articles_user(Request $request, Article $article, ArticleRepository $repo, MediaRepository $mediaRepository, User $user)
    {
        return $this->render('article/articles_user.html.twig', [
            'articles' => $repo->findBy(['user' => $user->getId()], ['art_created_at' => 'DESC']),
            'medias' => $mediaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/article/{id}/edit", name="article_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Article $article)
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //TEST SI PAS DE NEW IMAGE, ON GARDE LE NOM DE L'ANCIENNE
            if( $article->getMainImage() == "update"  ){
                $article->setMainImage($request->get('imagePrincipale'));
            }
            //SINON, ON DELETE L'ANCIENNE IMAGE ET RECUP LA NOUVELLE
            else{
                if( file_exists($this->getParameter('main_img_directory').'/'.$request->get('imagePrincipale')) )
                    unlink(($this->getParameter("main_img_directory").'/'.$request->get('imagePrincipale')));

                $image = $form->get('main_image')->getData();
                $file_name =  $article->getId().'main_img' . md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('main_img_directory'),
                    $file_name
                );
                $article->setMainImage($file_name);
            }

            try {
                $this->manager->flush();

                $this->addFlash("success", "Article modifié avec succès");

                return $this->redirectToRoute('article_show', ['id' => $article->getid()]);

            }catch (UniqueConstraintViolationException $e){
                $this->addFlash("success", "L'article n'a pas pu être modifié ");
            }
        }
        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/article/{id}/toDelete", name="article_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Article $article, MediaRepository $mediaRepository)
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {

            //SUPPRESSION IMAGE
            if( file_exists($this->getParameter('main_img_directory').'/'.$article->getMainImage()) )
                unlink(($this->getParameter("main_img_directory").'/'.$article->getMainImage()));

            //RECUP DES MEDIAS POUR SUPPRESSION DE SES FICHIERS
            $medias = $mediaRepository->mediaByArticle($article->getId());

            foreach ($medias as $media){
                $type = $media->getType();
                if( $type == "image" ){
                    $directory = 'images_directory';
                }elseif( $type == "audio" ){
                    $directory = 'audios_directory';
                }elseif( $type == "video" ){
                    $directory = 'videos_directory';
                }

                if( file_exists($this->getParameter($directory).'/'.$media->getNom()) )
                    unlink(($this->getParameter($directory).'/'.$media->getNom()));
            }

            $this->addFlash('success',
            "Article supprimé avec succès ! ");

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
        }
        return $this->redirectToRoute('article_admin');
    }

}
