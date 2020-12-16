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
    // public function dbConnect() {
    //     $this->db = new \PDO('mysql:host=localhost;dbname=jalal;charset=utf8', "root", "", 
    //         [
    //             \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
    //             \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
    //         ]);
    //         return $this->db;
    // }
    // public function execRequete($query, array $params = null) {
    //     $res = $this->dbConnect()->prepare($query);
    //     if( !empty($params) ){
    //         foreach ($params as $key => $value) {
    //             $params[$key] = $value;
    //         }
    //     }
    //     $res->execute($params);
    //     return $res;
    // }

    /**
     * @Route("/new_image/{id}", name="media_new_image", methods={"GET","POST"})
     */
    public function new_image(Request $request, Article $article, MediaRepository $mediaRepository): Response
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
            

            
            //return $this->redirectToRoute('media_new_video', ['id' => $article->getId()]);
                         
        }
        // L'ordre ne peut pas être donné avant car le media ne possède pas d'id avant la soumission
        // 
        if(isset($_POST['reorganisation'])){
            $all_med_img = $mediaRepository->imageByArticle($article->getId());                       
            $nb_img = count($all_med_img);
            for( $i = 0; $i < $nb_img; $i++){
                $id = $_POST['image_id'][$i];
                $med_img = $mediaRepository->findOneMedia($id);
                $med_img[0]->setOrdre($i);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->flush();
                // dump($med_img[0]->getOrdre());
            }
            // die;
        }
        
        return $this->render('media/new_image.html.twig', [
            'medium' => $medium,
            'article' => $article,
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
