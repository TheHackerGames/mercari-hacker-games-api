<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class RootController extends Controller
{
    /**
     * @SWG\Get(
     *   path="/",
     *   summary="Root path",
     *   tags={"Root"},
     *   consumes={"application/json"},
     *   produces={"application/json"},
     *   @SWG\Response(
     *     response="201",
     *     description="Model created"
     *   ),
     *   @SWG\Response(
     *     response="400",
     *     description="Invalid request"
     *   )
     * )
     * @Route("/", name="root")
     * @Method({"GET"})
     */
    public function rootAction()
    {
        $jsonResponse = new JsonResponse();
        $jsonResponse->setData(['data' => 'HackerGames 2018']);

        return $jsonResponse;
    }
}
