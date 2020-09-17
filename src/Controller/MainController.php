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
    public function getResponse($lang, $word) {
	    $client = new Client(['base_uri' => 'https://od-api.oxforddictionaries.com/api/v2/entries/']);
	    $request = $client->request('GET', '/en-us/tea', ['headers' => ['app_id' => '292a9259', 'app_key' => '8f02a9c77948c00d8292034ad5977de0']]);
        dd($request);
    }
}
