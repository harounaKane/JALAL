<?php

namespace App\Controller;

use App\Entity\Media;
use App\Entity\Article;
use App\Form\MediaType;
use App\Repository\MediaRepository;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/media")
 */
class MediaController extends AbstractController
{
    /**
     * @Route("/", name="media_index", methods={"GET"})
     */
    public function index(MediaRepository $mediaRepository, ArticleRepository $articleRepository): Response
    {
        return $this->render('media/index.html.twig', [
            'media' => $mediaRepository->findAll(),
            'lastArticle' => $articleRepository->findOneBy([], ['art_created_at' => 'DESC']),
        ]);
    }

    /**
     * @Route("/new_image/{id}", name="media_new_image", methods={"GET","POST"})
     */
    public function new_image(Request $request, Article $article): Response
    {
        $medium = new Media();
        $form = $this->createForm(MediaType::class, $medium);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $medium->setCreatedAt(new \DateTime());
            $medium->setType('image');
            $medium->setArticle($article);
            $medium->setOrdre('0');
            
            // On récupère les images transmises
            $images = $form->get('nom')->getData();
            $i = 0;
            if($i >= 0 && $i < 10){
                // On boucle sur les images
                foreach($images as $image){
                    // On génère un nouveau nom de fichier
                    $fichier =  $article->getId().'img' . md5(uniqid()) . '.' . $image->guessExtension();

                    // On copie le fichier dans le dossier uploads
                    $image->move(
                        $this->getParameter('images_directory'),
                        $fichier
                    );

                    // On stocke l'image dans la base de données (son nom)
                    
                    $medium->setNom($fichier);
                    $article->addMedium($medium);
                }
            }
            // else{ }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($medium);
            $entityManager->flush();
            return $this->redirectToRoute('media_new_video', ['id' => $article->getId()]);
        }

        return $this->render('media/new_image.html.twig', [
            'medium' => $medium,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new_video/{id}", name="media_new_video", methods={"GET","POST"})
     */
    public function new_video(Request $request, Article $article): Response
    {
        $medium = new Media();
        $form = $this->createForm(MediaType::class, $medium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $medium->setCreatedAt(new \DateTime());
            $medium->setType('video');
            $medium->setArticle($article);
            $medium->setOrdre('0');

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($medium);
            $entityManager->flush();
            return $this->redirectToRoute('media_new_audio', ['id' => $article->getId()]);
        }

        return $this->render('media/new_video.html.twig', [
            'medium' => $medium,
            'form' => $form->createView(),
        ]);
    }  
    
    /**
     * @Route("/new_audio/{id}", name="media_new_audio", methods={"GET","POST"})
     */
    public function new_audio(Request $request, Article $article): Response
    {
        $medium = new Media();
        $form = $this->createForm(MediaType::class, $medium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $medium->setCreatedAt(new \DateTime());
            $medium->setType('audio');
            $medium->setArticle($article);
            $medium->setOrdre('0');

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($medium);
            $entityManager->flush();
            return $this->redirectToRoute('media_index');
        }

        return $this->render('media/new_audio.html.twig', [
            'medium' => $medium,
            'form' => $form->createView(),
        ]);
    }   

    /**
     * @Route("/{id}", name="media_show", methods={"GET"})
     */
    public function show(Media $medium): Response
    {
        return $this->render('media/show.html.twig', [
            'medium' => $medium,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="media_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Media $medium): Response
    {
        $form = $this->createForm(MediaType::class, $medium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('media_index');
        }

        return $this->render('media/edit.html.twig', [
            'medium' => $medium,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="media_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Media $medium): Response
    {
        if ($this->isCsrfTokenValid('delete'.$medium->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($medium);
            $entityManager->flush();
        }

        return $this->redirectToRoute('media_index');
    }
}
