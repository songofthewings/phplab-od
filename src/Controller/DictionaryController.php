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
        $arguments = func_get_args();
        $numberOfArguments = func_num_args();

        if (method_exists($this, $function = '__construct'.$numberOfArguments)) {
            call_user_func_array(array($this, $function), $arguments);
        }
    }

    public function __construct1($client)
    {
        if (isset($client)) {
            $this->client = $client; //for testing purposes
        } else {
            $this->client = new Client(
                [
                    'base_uri' => $_ENV['DICTIONARY_ENDPOINT'],
                    'headers' => [
                        'Accept' => 'application/json',
                        'app_id' => $_ENV['DICTIONARY_APP_ID'],
                        'app_key' => $_ENV['DICTIONARY_APP_KEY']
                    ]
                ]
            );
        }
    }

    public function __construct2(Client $client)
    {
        if (isset($client)) {
            $this->client = $client; //for testing purposes
        } else {
            $this->client = new Client(
                [
                    'base_uri' => $_ENV['DICTIONARY_ENDPOINT'],
                    'headers' => [
                        'Accept' => 'application/json',
                        'app_id' => $_ENV['DICTIONARY_APP_ID'],
                        'app_key' => $_ENV['DICTIONARY_APP_KEY']
                    ]
                ]
            );
        }
    }

    /**
     * @Route("/dictionary", name="dictionary")
     * @param string $lang
     * @param string $word
     * @return Response
     */
    public function entries(string $lang, string $word)
    {
        $response = $this->entriesLogic($lang, $word);

        return $this->render('dictionary/index.html.twig', ['response' => $response]);
    }

    /**
     * @param string $lang
     * @param string $word
     * @return mixed|null
     * @throws GuzzleException
     */
    public function entriesLogic(string $lang = 'en-us', string $word = 'hello')
    {
        try {
            $data = $this->client->get(
                sprintf(
                    'entries/%s/%s?fields=definitions%%2Cexamples%%2Cpronunciations&strictMatch=false',
                    $lang,
                    $word
                )
            );
            $response = json_decode($data->getBody()->getContents());
        } catch (Exception $e) {
            switch ($e->getCode()) {
                case 404:
                    $response = null;
                    break;
                default:
                    throw new \App\Exceptions\DictionaryException('Something went wrong');
            }
        }
        return $response;
    }
}
