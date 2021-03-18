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
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\IsTrueValidator;
use Symfony\Component\Validator\Constraints\IsFalse;
use Symfony\Component\Validator\Constraints\IsFalseValidator;

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
//----------------REDIRECTION---------------- 
   /**
     * @Route("/media_redirect/{id}", name="media_redirect", methods={"GET","POST"})
     */
    public function redirection_media(Request $request, Article $article): Response
    {
        return $this->render('media/redirect_med.html.twig', [
            'article' => $article
        ]);
    }
//----------------CREATIONS---------------- 

    /**
     * @Route("/new_image/{id}", name="media_new_image", methods={"GET","POST"})
     */
    public function new_image(Request $request, Article $article, MediaRepository $mediaRepository): Response
    {
        $medium = new Media();
        $form = $this->createForm(MediaType::class, $medium);
        $form->handleRequest($request);
        $images = $mediaRepository->imageByArticle($article->getId());
        if ($form->isSubmitted() && $form->isValid()) {
            $medium->setCreatedAt(new \DateTime());
            $medium->setType('image');
            $medium->setArticle($article);
            $medium->setOrdre('0');
            $i = 10;
            $nb_img = count($images);
            while($nb_img < $i){
                
                // On récupère les images transmises
                $images = $form->get('nom')->getData();
                // On boucle sur les images
                foreach($images as $image){
                    // On génère un nouveau nom de fichier
                    $file_name =  $article->getId().'img' . md5(uniqid()) . '.' . $image->guessExtension();
                    // On copie le fichier dans le dossier uploads
                    $image->move(
                        $this->getParameter('images_directory'),
                        $file_name
                    );
                    // On stocke l'image dans la base de données (son nom)
                    $medium->setNom($file_name);
                    $article->addMedium($medium);                   
                }

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($medium);
                $entityManager->flush();
                $this->addFlash('notice'
                                ,'Votre image a bien été ajoutée');
                return $this->redirectToRoute('media_new_image', ['id' => $article->getId()]);
            }
            if($nb_img >= $i){
                
                $this->addFlash('notice'
                                ,'Vous ne pouvez pas ajouter plus de dix images !');
                return $this->redirectToRoute('media_new_image', ['id' => $article->getId()]);
            }
        }
        // L'ordre ne peut pas être donné avant car le media ne possède pas d'id avant la soumission
        // 
        if(isset($_POST['reorganisation'])){
            $all_med_img = $mediaRepository->imageByArticle($article->getId());                       
            $nb_img = count($all_med_img);
            for( $i = 0; $i < $nb_img; $i++){
                $id = $_POST['image_id'][$i];
                $med_img = $mediaRepository->findOneMedia($id);
                $med_img[0]->setOrdre($_POST['ordre'][$i]);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->flush();
            }
            
        }
        
        return $this->render('media/new_image.html.twig', [
            'medium' => $medium,
            'article' => $article,
            'images' => $images,
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
        $medium->setType('video');
        // $request_uri = $request->getrequestUri();
        // dump($request->getrequestUri());
        // die;
        if ($form->isSubmitted() && $form->isValid()) {
            
            $medium->setCreatedAt(new \DateTime());
            $medium->setType('video');
            $medium->setArticle($article);
            $medium->setOrdre('0');

            if(!($form->get('nom')->isEmpty()) && ($form->get('url')->isEmpty()) ){
                $videos = $form->get('nom')->getData();
                foreach($videos as $video){
                    $medium->setUrl('fichier');
                    $file_name =  $article->getId().'vid' . md5(uniqid()) . '.' . $video->guessExtension();

                    $video->move(
                        $this->getParameter('videos_directory'),
                        $file_name
                    );
                    $medium->setNom($file_name);
                    $article->addMedium($medium);
                }
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($medium);
                $entityManager->flush();
                $this->addFlash('notice'
                            ,'Votre vidéo a bien été ajoutée');
            }
            elseif(!($form->get('url')->isEmpty()) && ($form->get('nom')->isEmpty()) ) {
                $medium->setNom('url');
                $video = $form->get('url')->getData();
                
                    $file_name =  substr($form->get('url')->getData(), 32 );
                    
                    $medium->setUrl($file_name);
                    $article->addMedium($medium);
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($medium);
                    $entityManager->flush();
                    $this->addFlash('notice'
                            ,'Votre vidéo a bien été ajoutée');
                
            }
            return $this->redirectToRoute('media_new_video', ['id' => $article->getId()]);
        }

        return $this->render('media/new_video.html.twig', [
            'medium' => $medium,
            'article' => $article,
            // 'request_uri' => $request_uri,
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
            
            $audios = $form->get('nom')->getData();
            
            foreach($audios as $audio){
                $file_name =  $article->getId().'aud' . md5(uniqid()) . '.' . $audio->guessExtension();

                $audio->move(
                    $this->getParameter('audios_directory'),
                    $file_name
                );
                $medium->setNom($file_name);
                $article->addMedium($medium);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($medium);
            $entityManager->flush();
            $this->addFlash('notice'
                            ,'Votre audio a bien été ajoutée');
            return $this->redirectToRoute('media_new_audio', ['id' => $article->getId()]);
        }

        return $this->render('media/new_audio.html.twig', [
            'medium' => $medium,
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }   

//----------------MODIFICATIONS----------------    
    /**
     * @Route("/edit_image/{id}", name="media_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Media $medium,  MediaRepository $mediaRepository): Response
    {
        $form = $this->createForm(MediaType::class, $medium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article = $medium->getArticle();
            if($medium->getType() == 'image'){
                // On récupère les images transmises
                $images = $form->get('nom')->getData();
                foreach($images as $image){
                    $file_name =  $medium->getArticle()->getId().'img' . md5(uniqid()) . '.' . $image->guessExtension();
                    $image->move(
                        $this->getParameter('images_directory'),
                        $file_name
                    );
                    $medium->setNom($file_name);
                    $article->addMedium($medium);
                }
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('media_new_image', ['id' => $article->getId()]);
            }
        }

        return $this->render('media/edit.html.twig', [
            'medium' => $medium,
            'form' => $form->createView(),
        ]);
    }
//----------------SUPPRESSIONS---------------- 
    /**
     * @Route("/{id}", name="media_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Media $medium): Response
    {
        if($medium->getType() == 'image'){
            if ($this->isCsrfTokenValid('delete'.$medium->getId(), $request->request->get('_token'))) {
                $article = $medium->getArticle();
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($medium);
                $entityManager->flush();
            }

            return $this->redirectToRoute('media_new_image', ['id' => $article->getId()]);
        }
    }

//----------------AFFICHAGES----------------  

    /**
     * @Route("/{id}", name="media_show", methods={"GET"})
     */
    public function show(Media $medium): Response
    {
        return $this->render('media/show.html.twig', [
            'medium' => $medium,
        ]);
    }  
}
