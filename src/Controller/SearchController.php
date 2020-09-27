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
            $repository = $this->getDoctrine()
                ->getRepository(Search::class);


            $item = $repository->findOneBy([
                'word' => $word,
            ]);

            if(empty($item)){
                $item = new Search();
                $item->setWord($word);
                $item->setSearchCount(1);
                $entityManager->persist($item);

                $entityManager->flush();
            }else{
                $item->incrementSearchCount();
                $entityManager->persist($item);
                $entityManager->flush();
            }

            $data = json_decode($response->getBody()->getContents());
        }

        $historyFind = $this->getDoctrine()
            ->getRepository(Search::class)
            ->findAll();
        $history = [];
        if(!empty($historyFind)){

            foreach ($historyFind as $key => $value){
                $history[] = ['word' => $value->getWord(), 'search_count' => $value->getSearchCount()];
            }
        }
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
