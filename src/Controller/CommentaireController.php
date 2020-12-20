<?php

namespace App\Controller;

use App\Entity\Commentaire;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class CommentaireController extends AbstractController
{
    /**
     * @Route("/likeCommentaire/{id}", name="likeCommentaire", methods={"GET","POST"})
     */
    public function likeCommentaire(Request $request, $id)
    {
        $manager = $this->getDoctrine()->getManager();
        $commentaire = $manager->getRepository(Commentaire::class)->find($id);

        if($commentaire){
            $commentaire->setLikeComment( $commentaire->getLikeComment() + 1 );
            $manager->flush();
            $arrData = [$commentaire->getLikeComment()];
            return new JsonResponse($arrData);
        }

        //throw $this->createNotFoundException("pas de commentaire pour ");
    }
    /**
     * @Route("/commentaireUnLike/{id}", name="unLikeCommentaire", methods={"GET","POST"})
     */
    public function unLikeCommentaire(Request $request, $id)
    {
        $manager = $this->getDoctrine()->getManager();
        $commentaire = $manager->getRepository(Commentaire::class)->find($id);

        if($commentaire){
            $commentaire->setUnLikeComment( $commentaire->getUnLikeComment() + 1 );
            $manager->flush();
            $arrData = [$commentaire->getUnLikeComment()];
            return new JsonResponse($arrData);
        }

        //throw $this->createNotFoundException("pas de commentaire pour ");
    }


}
