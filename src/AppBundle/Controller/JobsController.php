<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class JobsController extends Controller
{
    /**
     * @SWG\Post(
     *   path="/jobs-search",
     *   summary="Get list of jobs",
     *   tags={"Jobs"},
     *   consumes={"application/json"},
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="JobSearch",
     *     required=true,
     *     @SWG\Schema(ref="#/definitions/JobSearch"),
     *   ),
     *   @SWG\Response(
     *     response="200",
     *     description="List returned"
     *   ),
     *   @SWG\Response(
     *     response="400",
     *     description="Bad request"
     *   )
     * )
     * @Route("/jobs-search", name="jobs")
     * @Method({"POST"})
     */
    public function searchJobsAction(Request $request)
    {
        $body = $request->getContent();
        $decodedBody = json_decode($body);

        $jobs = [];

        $jsonResponse = new JsonResponse();
        $jsonResponse->setData(['jobs' => $jobs]);

        return $jsonResponse;
    }
}