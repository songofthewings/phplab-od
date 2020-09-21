<?php


namespace App\Controller;


use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use GuzzleHttp\Client;

class MainController extends AbstractController
{

    /**
     * @Route("/", name="basic_page", methods={"GET"})
     * @return Response
     */
    public function index(): Response
    {
        return $this->render(
            'index.html.twig'
        );
    }
}
