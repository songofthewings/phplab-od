<?php


namespace App\Controller;

use App\Entity\Search;
use App\Entity\TagCloud;
use App\Repository\TagCloudRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class TagCloudController extends AbstractController
{
    /**
     * @Route("/tag-cloud", name="tag_cloud")
     * @return Response
     */
    public function tagCloud(): Response
    {
        $tagCloud = $this->getDoctrine()
            ->getRepository(Search::class)
            ->findAll();

        return $this->render(
            'tag-cloud.html.twig',
            [
                'tag_cloud' => $tagCloud
            ]
        );
    }

}
