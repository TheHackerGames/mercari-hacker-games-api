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

    }
}