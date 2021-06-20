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
            $medium->setUrl("");
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

                $this->addFlash('success'
                                ,'Votre image a bien été ajoutée');
                return $this->redirectToRoute('media_new_image', ['id' => $article->getId()]);
            }
            if($nb_img >= $i){
                
                $this->addFlash('warning'
                                ,'Vous ne pouvez pas ajouter plus de dix images !');
                return $this->redirectToRoute('media_new_image', ['id' => $article->getId()]);
            }
        }
        // L'ordre ne peut pas être donné avant car le media ne possède pas d'id avant la soumission
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
    public function new_video(Request $request, Article $article, MediaRepository $mediaRepository): Response
    {
        $medium = new Media();
        $form = $this->createForm(MediaType::class, $medium);
        $form->handleRequest($request);
        $videos = $mediaRepository->videoByArticle($article->getId());
        $videos_url = $mediaRepository->videoUrlByArticle($article->getId());
        $videos_fichier = $mediaRepository->videoFichierByArticle($article->getId());
        $nb_vid = count($videos);
        $i = 2;
        $medium->setType('video');

        if ($form->isSubmitted() && $form->isValid()) {

            while($nb_vid < $i){
                $medium->setCreatedAt(new \DateTime());
                $medium->setType('video');
                $medium->setArticle($article);
                $medium->setOrdre('0');

                if(!($form->get('nom')->isEmpty()) ){

                    $medium->setUrl("");
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

                    $this->addFlash('success'
                                ,'Votre vidéo a bien été ajoutée');
                }
                elseif(!($form->get('url')->isEmpty()) && ($form->get('nom')->isEmpty()) ) {

                    $medium->setNom('url');
                    $medium->setType('url');
                    
                    $file_name =  $form->get('url')->getData();

                    $medium->setUrl($file_name);
                    $article->addMedium($medium);

                    $this->addFlash('success'
                            ,'L\'URL de la vidéo a bien été ajouté');

                }

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($medium);
                $entityManager->flush();

                return $this->redirectToRoute('media_new_video', ['id' => $article->getId()]);

            }
            if($nb_vid >= $i){
                
                $this->addFlash('warning'
                                ,'Vous ne pouvez pas ajouter plus de deux vidéos !');
                return $this->redirectToRoute('media_new_video', ['id' => $article->getId()]);
            }
        }

        return $this->render('media/new_video.html.twig', [
            'medium' => $medium,
            'article' => $article,
            'videos' => $videos,
            'videos_url' => $videos_url,
            'videos_fichier' => $videos_fichier,
            'form' => $form->createView(),
        ]);
    }  
    
    /**
     * @Route("/new_audio/{id}", name="media_new_audio", methods={"GET","POST"})
     */
    public function new_audio(Request $request, Article $article, MediaRepository $mediaRepository): Response
    {
        $medium = new Media();
        $form = $this->createForm(MediaType::class, $medium);
        $form->handleRequest($request);
        $audios = $mediaRepository->audioByArticle($article->getId());
        $nb_aud = count($audios);
        $i = 2;

        if ($form->isSubmitted() && $form->isValid()) {
            while($nb_aud< $i){
                $medium->setCreatedAt(new \DateTime());
                $medium->setType('audio');
                $medium->setArticle($article);
                $medium->setOrdre('0');
                $medium->setUrl("");
                
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

                $this->addFlash('success','Votre audio a bien été ajoutée');

                return $this->redirectToRoute('media_new_audio', ['id' => $article->getId()]);
            }
            if($nb_aud>= $i){
                
                $this->addFlash('warning'
                                ,'Vous ne pouvez pas ajouter plus de deux audios !');
                return $this->redirectToRoute('media_new_video', ['id' => $article->getId()]);
            }
        }

        return $this->render('media/new_audio.html.twig', [
            'medium' => $medium,
            'article' => $article,
            'audios' => $audios,
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
        $article = $medium->getArticle();
        $images = $mediaRepository->imageByArticle($article->getId());
        $audios = $mediaRepository->audioByArticle($article->getId());
        $videos = $mediaRepository->videoByArticle($article->getId());
        $videos_url = $mediaRepository->videoUrlByArticle($article->getId());
        $videos_fichier = $mediaRepository->videoFichierByArticle($article->getId());
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            if($medium->getType() == 'image'){
                if(file_exists($this->getParameter('images_directory').'/'.$medium->getNom())){
                    unlink(($this->getParameter('images_directory').'/'.$medium->getNom()));

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
                    $this->addFlash('success'
                                    ,'Les informations de cette image ont bien été modifiées');
                    return $this->redirectToRoute('media_new_image', ['id' => $article->getId()]);
                }
            }
            if($medium->getType() == 'video'){
                if(file_exists($this->getParameter('videos_directory').'/'.$medium->getNom())){
                    unlink(($this->getParameter('videos_directory').'/'.$medium->getNom()));

                    if($medium->getNom() == 'url'){
                        $medium->setNom('url');
                        $video = $form->get('url')->getData();
                        
                        $file_name =  substr($form->get('url')->getData(), 32 );
                        
                        $medium->setUrl($file_name);
                        $article->addMedium($medium);
                    }
                    elseif($medium->getUrl() == 'fichier'){
                        $videos = $form->get('nom')->getData();
                        foreach($videos as $video){
                            $file_name =  $article->getId().'vid' . md5(uniqid()) . '.' . $video->guessExtension();
    
                            $video->move(
                                $this->getParameter('videos_directory'),
                                $file_name
                            );
                            $medium->setNom($file_name);
                            $article->addMedium($medium);
                        }
                    }
                   
                    $this->getDoctrine()->getManager()->flush();

                    $this->addFlash('success'
                                    ,'Les informations de cette vidéos ont bien été modifiées');

                    return $this->redirectToRoute('media_new_video', ['id' => $article->getId()]);
                }
            }
            if($medium->getType() == 'audio'){

                if(file_exists($this->getParameter('audios_directory').'/'.$medium->getNom())){
                    unlink(($this->getParameter('audios_directory').'/'.$medium->getNom()));

                    $audios = $form->get('nom')->getData();
                    foreach($audios as $audio){
                        $file_name =  $medium->getArticle()->getId().'aud' . md5(uniqid()) . '.' . $audio->guessExtension();
                        $audio->move(
                            $this->getParameter('audios_directory'),
                            $file_name
                        );
                        $medium->setNom($file_name);
                        $article->addMedium($medium);
                    }
                    $this->getDoctrine()->getManager()->flush();
                    $this->addFlash('success'
                                    ,'Les informations de cette audio ont bien été modifiées');
                    return $this->redirectToRoute('media_new_audio', ['id' => $article->getId()]);
                }
            }
        }

        return $this->render('media/edit.html.twig', [
            'medium' => $medium,
            'article' => $article,
            'images' => $images,
            'audios' => $audios,
            'videos' => $videos,
            'videos_url' => $videos_url,
            'videos_fichier' => $videos_fichier,
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
            $directory = "images_directory";
        }elseif($medium->getType() == 'audio'){
            $directory = "audios_directory";
        }elseif($medium->getType() == 'video'){
            $directory = "videos_directory";
        }

        if ( isset($directory) && file_exists($this->getParameter($directory) . '/' . $medium->getNom()) ) {
            unlink(($this->getParameter($directory) . '/' . $medium->getNom()));
        }

        if ($this->isCsrfTokenValid('delete' . $medium->getId(), $request->request->get('_token'))) {
            $article = $medium->getArticle();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($medium);
            $entityManager->flush();
        }

        $this->addFlash("success","Le média " . $medium->getType() . " est supprimé !");

        return $this->redirectToRoute('article_show', ['id' => $article->getId()]);
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
