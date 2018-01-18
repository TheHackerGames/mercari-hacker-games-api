<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Job;
use AppBundle\Entity\JobSkill;
use AppBundle\Entity\Skill;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
     *   @SWG\Parameter(
     *     name="limit",
     *     in="query",
     *     description="Number of rows to fetch",
     *     required=false,
     *     type="integer"
     *   ),
     *   @SWG\Parameter(
     *     name="offset",
     *     in="query",
     *     description="Number of rows to skip",
     *     required=false,
     *     type="integer"
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
     * @Route("/jobs-search", name="search-jobs")
     * @Method({"Post"})
     */
    public function searchJobsAction(Request $request)
    {
        $limit = $request->get('limit', 50);
        $offset = $request->get('offset', 0);

        $body = $request->getContent();
        $decodedBody = json_decode($body);

        if (!isset($decodedBody->skillIds)) {
            throw new BadRequestHttpException('Parameters are missing');
        }

        $jobRepository = $this->get('doctrine.orm.entity_manager')
            ->getRepository(Job::class);
        assert($jobRepository instanceof EntityRepository);

        $jobs = $jobRepository->findBySkillIds($decodedBody->skillIds, $limit, $offset);

        $data = ['jobs' => $jobs];

        $serializer = $this->container->get('jms_serializer');
        $content = $serializer->serialize($data, 'json');

        $jsonResponse = new JsonResponse();
        $jsonResponse->setContent($content);

        return $jsonResponse;
    }

    /**
     * @SWG\Post(
     *   path="/jobs",
     *   summary="Post a new job",
     *   tags={"Jobs"},
     *   consumes={"application/json"},
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="Job",
     *     required=true,
     *     @SWG\Schema(ref="#/definitions/Job"),
     *   ),
     *   @SWG\Response(
     *     response="201",
     *     description="New job posted"
     *   ),
     *   @SWG\Response(
     *     response="400",
     *     description="Bad request"
     *   )
     * )
     * @Route("/jobs", name="jobs")
     * @Method({"POST"})
     */
    public function postJobAction(Request $request)
    {
        $body = $request->getContent();
        $decodedBody = json_decode($body);

        if (
            !isset($decodedBody->user_id) ||
            !isset($decodedBody->title) ||
            !isset($decodedBody->description) ||
            !isset($decodedBody->salary) ||
            !isset($decodedBody->location)
        ) {
            throw new BadRequestHttpException('Parameters are missing');
        }

        $entityManager = $this->get('doctrine.orm.entity_manager');
        assert($entityManager instanceof EntityManager);

        $userRepository = $entityManager
            ->getRepository(User::class);

        $user = $userRepository->find($decodedBody->user_id);

        if (!$user) {
            throw new NotFoundHttpException('User not found');
        }

        $job = (new Job())
            ->setUserId($user->getId())
            ->setTitle($decodedBody->title)
            ->setDescription($decodedBody->description)
            ->setSalary($decodedBody->salary)
            ->setLocation($decodedBody->location)
            ->setCreated(new \DateTime());

        $entityManager->persist($job);
        $entityManager->flush();

        $data = ['job' => $job];

        $serializer = $this->container->get('jms_serializer');
        $content = $serializer->serialize($data, 'json');

        $jsonResponse = new JsonResponse();
        $jsonResponse->setStatusCode(201);
        $jsonResponse->setContent($content);

        return $jsonResponse;
    }
}