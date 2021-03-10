<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Article;
use App\Form\CommentaireType;
use App\Repository\CommentaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class CommentaireController extends AbstractController
{
    /**
     * @Route("/addCommentaire", name="addCommentaire", methods={"GET","POST"})
     */
    public function addCommentaire($form, Article $article, $repo)
    {
      //  dd($form->get('user')->getData());
        $commentaire = new Commentaire();
        $manager = $this->getDoctrine()->getManager();

        $commentaire->setCommentAt(new \DateTime());
        $commentaire->setArticle($repo->find($article->getId()));
        $commentaire->setLikeComment(0);
        $commentaire->setUnLikeComment(0);
        $commentaire->setUser($form->get('user')->getData());
        $commentaire->setComment($form->get('comment')->getData());
        dd($commentaire);
        $manager->persist($commentaire);
        $manager->flush();
        //REDIRECTION POUR EVITER LA DOUBLE SOUMISSION DU FORMULAIRE
        return $this->redirectToRoute('article_show', ['id' => $article->getId()]);
    }
    /**
     * @Route("/likeCommentaire/{id}", name="likeCommentaire", methods={"GET","POST"})
     */
    public function likeCommentaire(Request $request, $id)
    {
        $manager = $this->getDoctrine()->getManager();
        $commentaire = $manager->getRepository(Commentaire::class)->find($id);

        if($commentaire && $request->isXmlHttpRequest()){
            $commentaire->setLikeComment( $commentaire->getLikeComment() + 1 );
            $manager->flush();
            $arrData = [$commentaire->getLikeComment()];
            return new JsonResponse($arrData);
        }

//        return $this->redirectToRoute('article_show', ['id' => $commentaire->getArticle()->getId()]);
        //retour à la page si != requette ajax
        return $this->redirect($this->generateUrl("article_show", ["id" => $commentaire->getArticle()->getId()]));

        //throw $this->createNotFoundException("pas de commentaire pour ");
    }
    /**
     * @Route("/commentaireUnLike/{id}", name="unLikeCommentaire", methods={"GET","POST"})
     */
    public function unLikeCommentaire(Request $request, $id)
    {
        $manager = $this->getDoctrine()->getManager();
        $commentaire = $manager->getRepository(Commentaire::class)->find($id);

        if($commentaire && $request->isXmlHttpRequest()){
            $commentaire->setUnLikeComment( $commentaire->getUnLikeComment() + 1 );
            $manager->flush();
            $arrData = [$commentaire->getUnLikeComment()];
            return new JsonResponse($arrData);
        }//retour à la page si != requette ajax
        return $this->redirect($this->generateUrl("article_show", ["id" => $commentaire->getArticle()->getId()]));

    }


}
