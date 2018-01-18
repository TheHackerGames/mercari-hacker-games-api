<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Military;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class MilitariesController extends Controller
{
    /**
     * @SWG\Get(
     *   path="/militaries",
     *   summary="Get list of militaries",
     *   tags={"Military"},
     *   consumes={"application/json"},
     *   produces={"application/json"},
     *   @SWG\Response(
     *     response="200",
     *     description="List returned"
     *   )
     * )
     * @Route("/militaries", name="militaries")
     * @Method({"GET"})
     */
    public function listAction(Request $request)
    {
        $militariesRepository = $this->get('doctrine.orm.entity_manager')
            ->getRepository(Military::class);

        assert($militariesRepository instanceof EntityRepository);
        $militaries = $militariesRepository->findAll();

        $data = ['militaries' => $militaries];

        $serializer = $this->container->get('jms_serializer');
        $content = $serializer->serialize($data, 'json');

        $jsonResponse = new JsonResponse();
        $jsonResponse->setContent($content);

        return $jsonResponse;
    }
}