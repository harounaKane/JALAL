<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Commentaire;
use App\Entity\Media;
use App\Form\ArticleType;
use App\Form\CommentaireType;
use App\Form\MediaType;
use App\Form\MembreType;
use App\Repository\ArticleRepository;
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
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/article/new", name="article_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserRepository $repo): Response
    {
        $article = new Article();
        $media = new Media();
        $form = $this->createForm(ArticleType::class, $article);
        $formMedia = $this->createForm(MediaType::class, $media);
        $form->handleRequest($request);
        dump($form);
        if ($form->isSubmitted() && $form->isValid()) {
            $article->setArtCreatedAt(new \DateTime());
            $article->setUser($repo->idUser($request->getSession()->get('id')) );
            try {
                $this->manager->persist($article);
                $this->manager->flush();
            }catch (UniqueConstraintViolationException $e){

            }

            return $this->redirectToRoute('accueil');
        }

        return $this->render('article/new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
            'formMedia' => $formMedia->createView()
        ]);
    }

    /**
     * @Route("/article/{id}", name="article_show", methods={"GET"})
     */
    public function show(Article $article): Response
    {
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);

        return $this->render('article/show.html.twig', [
            'article' => $article,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/article/{id}/edit", name="article_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Article $article): Response
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
    public function delete(Request $request, Article $article): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('article_index');
    }
}

/*

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('categorie', EntityType::class, [
                "label" => "Catégorie",
                "class" => Categorie::class,
                "choice_label" => function ($category) {
                    return $category->getDesignation() ;
                }
            ])
            ->add('title', TextType::class, [
                "label" => "Titre Principal",
                "attr" => [
                    "placeholder" => "Titre Principal",
                    "minlength" => 2,
                    "maxlength" => 100
                ]
            ])
            ->add('secondary_title', TextType::class, [
                "label" => "Titre Secondaire",
                "attr" => [
                    "placeholder" => "Titre Secondaire",
                    "minlength" => 2,
                    "maxlength" => 100
                ]
            ])
            ->add('content', TextareaType::class, [
                "label" => "Contenu",
                "attr" => [
                    "placeholder" => "Contenu",
                    "rows" => 5,
                    "maxlength" => 20000
                ]
            ])
            ->add('main_image', FileType::class, [
                "label" => "Image principale",
                'data_class' => null,
                'required' => false
            ])
            ->add('media', CollectionType::class, [
                "label" => "Liste des medias",
                'entry_type' => MediaType::class,
                // 'data_class' => null,
                'required' => false,
                'allow_add' => true,
            ])
          //  ->add("Ajouter", SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
*