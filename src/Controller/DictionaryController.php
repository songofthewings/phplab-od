<?php

namespace App\Controller;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use GuzzleHttp\Client as Client;

class DictionaryController extends AbstractController
{
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => $_ENV['DICTIONARY_ENDPOINT'],
            'headers' => [
                'Accept' => 'application/json',
                'app_id' => $_ENV['DICTIONARY_APP_ID'],
                'app_key' => $_ENV['DICTIONARY_APP_KEY']
            ]
        ]);
    }

    /**
     * @Route("/dictionary", name="dictionary")
     * @param string $lang
     * @param string $word
     * @return Response
     * @throws GuzzleException
     */
    public function entries(string $lang = 'en-us', string $word = 'hello')
    {
        try {
            $data = $this->client->get(sprintf(
                'entries/%s/%s?fields=definitions%%2Cexamples%%2Cpronunciations&strictMatch=false',
                $lang,
                $word
            ));
            $response = json_decode($data->getBody()->getContents());
        } catch (Exception $e) {
            switch ($e->getCode()) {
                case 404:
                    $response = null;
                    break;
                default:
                    throw new Exception('Something went wrong');
            }

        }

        return $this->render('dictionary/index.html.twig', ['response' => $response]);
    }
}
