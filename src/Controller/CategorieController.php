<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\ArticleRepository;
use App\Repository\CategorieRepository;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use phpDocumentor\Reflection\Types\False_;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @Route("/categorie")
 */
class CategorieController extends AbstractController
{
    private $manager;
    public function __construct(EntityManagerInterface $manager){
        $this->manager = $manager;
    }  

    /**
     * @Route("/", name="categorie_index", methods={"GET"})
     */
    public function index(CategorieRepository $categorieRepository): Response
    {
        return $this->render('categorie/index.html.twig', [
            'categories' => $categorieRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="categorie_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categorie->setCreatedAt(new \DateTime());
            try {
                $this->manager->persist($categorie);
                $this->manager->flush();

                $this->addFlash("success",
                "Catégorie '" . $categorie->getDesignation() . "' ajouté avec succès !");

                return $this->redirectToRoute('categorie_index');

            }catch (UniqueConstraintViolationException $e){
                $this->addFlash("warning",
                    "Catégorie '" . $categorie->getDesignation() . "' n'a pas pu être ajouté ! Existe déjà");
            }
        }

        return $this->render('categorie/new.html.twig', [
            'categorie' => $categorie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="categorie_show", methods={"GET"})
     */
    public function show(Categorie $categorie): Response
    {
        return $this->render('categorie/show.html.twig', [
            'categorie' => $categorie,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="categorie_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Categorie $categorie): Response
    {
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->manager->flush();

                $this->addFlash("success",
                    "Catégorie " . $categorie->getDesignation() . " modifié avec succès !");

                return $this->redirectToRoute('categorie_index');

            }catch (UniqueConstraintViolationException $e){
                $this->addFlash("warning",
                    "Catégorie '" . $categorie->getDesignation() . "' n'a pas pu être modifié !");
            }

        }

        return $this->render('categorie/edit.html.twig', [
            'categorie' => $categorie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="categorie_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Categorie $categorie): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorie->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            try {
                $entityManager->remove($categorie);
                $entityManager->flush();

                $this->addFlash("success",
                "Catégorie '" . $categorie->getDesignation() . "' supprimée ");

                return $this->redirectToRoute('categorie_index');

            }catch (ForeignKeyConstraintViolationException  $e){
                $this->addFlash("warning",
                    "Catégorie '" . $categorie->getDesignation() . "' ne peut être supprimée. Il y a des articles liés à cette catégorie ");
            }
        }

        return $this->redirectToRoute('categorie_show', ['id' => $categorie->getId()]);
    }

    /**
     * @Route("/article_par_categorie/{id}", name="byCategorie")
     */
    public function byCat($id, Categorie $categorie, ArticleRepository  $articleRepository){
        $articleByCategorie = $articleRepository->articleByCategorie($categorie->getId());

        $artByCat= $articleRepository->lastArticleByCategorie($categorie->getId());

        return $this->render('article/articleByCategorie.html.twig', [
            'articles' => $articleByCategorie,
            'lastArticleByCategorie' => $artByCat ? $artByCat[0] : false,
            'articlesRecents' => $articleRepository->findBy([], ['art_created_at' => 'DESC'], 10)
        ]);
    }
}
