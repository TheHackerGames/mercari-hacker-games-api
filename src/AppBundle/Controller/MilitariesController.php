<?php

namespace AppBundle\Controller;

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
     *   path="/mili",
     *   summary="Get list of militaries",
     *   tags={"Military"},
     *   consumes={"application/json"},
     *   produces={"application/json"},
     *   @SWG\Response(
     *     response="200",
     *     description="List returned"
     *   )
     * )
     * @Route("/mili", name="militaries")
     * @Method({"GET"})
     */
    public function listAction(Request $request)
    {

    }
}