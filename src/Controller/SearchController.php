<?php


namespace App\Controller;

use App\Entity\Search;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use GuzzleHttp\Client;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     */
    public function search(Request $request, ValidatorInterface $validator)
    {
        $word = $request->get('word');
        $lang = $request->get('lang');
        if (!empty($word)) {
            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', "https://od-api.oxforddictionaries.com/api/v2/entries/{$lang}/{$word}", [
                'headers' => [
                    'app_id' => '5de77d25',
                    'app_key' => 'f63a0a48fb89cd0e7d01a5acb0dfead9',
                ]
            ]);
            $entityManager = $this->getDoctrine()->getManager();

            $model = new Search();
            $model->setName($word);
            $entityManager->persist($model);

            $entityManager->flush();

            $data = json_decode($response->getBody()->getContents());
        }

        $history = $this->getDoctrine()
            ->getRepository(Search::class)
            ->findAllUniqueName();
        return $this->render('search.html.twig',
            [
                'data' => !empty($data) ? $data : null,
                'histories' => !empty($history) ? $history : null,
                'word' => !empty($word) ? $word : null,
                'lang' => !empty($lang) ? $lang : null,
            ]
        );
    }

}
