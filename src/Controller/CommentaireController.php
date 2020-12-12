<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class CommentaireController extends AbstractController
{
    /**
     * @Route("/commentaire/{id}", name="commentaire", methods={"GET","POST"})
     */
    public function index(Request $request, $id)
    {
        $arrData = ['output' => 'here the result which will appear in div'];
        return new JsonResponse($arrData);
        return $this->render('commentaire/index.html.twig', [
            'controller_name' => 'CommentaireController',
        ]);
    }
}
