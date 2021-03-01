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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
class ArticleController extends AbstractController
{
    private $manager;
    public function __construct(EntityManagerInterface $manager){
        $this->manager = $manager;
    }    
    
    /**
     * @Route("/", name="accueil", methods={"GET"})
     */
    public function index(ArticleRepository $articleRepository)
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findAll(),
            'articles' => $articleRepository->findBy([], ['art_created_at' => 'DESC']),
            'lastArticle' => $articleRepository->findOneBy([], ['art_created_at' => 'DESC']),
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
            $article->setUser($repo->idUser($request->getSession()->get('id')) );
            
            $image = $form->get('main_image')->getData();
            
            try {
                $this->manager->persist($article);
                $this->manager->flush();


            }catch (UniqueConstraintViolationException $e){
            }
            //RECUPERATION IMAGE PRINCIPALE : même procédé que celui de Mantcha pour les medias
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
            }catch (UniqueConstraintViolationException $e){
            }

            return $this->redirectToRoute('media_redirect', ['id' => $article->getId()]);
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
        //dd($article);
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);

        //TRAITEMENT DES COMMENTAIRES
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $commentaire->setCommentAt(new \DateTime());
            $commentaire->setArticle($repo->find($article->getId()));
            $commentaire->setLikeComment(0);
            $commentaire->setUnLikeComment(0);
            $this->manager->persist($commentaire);
            $this->manager->flush();
            //REDIRECTION POUR EVITER LA DOUBLE SOUMISSION DU FORMULAIRE
            return $this->redirectToRoute('article_show', ['id' => $article->getId()]);
        }

        //RECUPRATION DES COMMENTAIRE DE L'ARTICLE
        $commentaires = $commentaireRepository->commentByArticle($article->getId());

        $images = $mediaRepository->imageByArticle($article->getId());
        $audios = $mediaRepository->audioByArticle($article->getId());
        $videos_url = $mediaRepository->videoUrlByArticle($article->getId());
        $videos_fichier = $mediaRepository->videoFichierByArticle($article->getId());

        return $this->render('article/show.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
            'commentaires' => $commentaires,
            'images' => $images,
            'audios' => $audios,
            'videos_url' => $videos_url,
            'videos_fichier' => $videos_fichier,
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
            try {
                $this->manager->persist($article);
                $this->manager->flush();
            }catch (UniqueConstraintViolationException $e){
            }
            return $this->redirectToRoute('article_index');
        }
        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/article/{id}", name="article_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Article $article)
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
        }
        return $this->redirectToRoute('article_index');
    }
    

}
