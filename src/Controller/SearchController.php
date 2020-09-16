<?php


namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search_page")
     * @return Response
     */
    public function search(): Response{
        $word = $_GET['word'];
         return $this->render(
             'search.html.twig',
             ['word'=>$word]
         );
    }

}
