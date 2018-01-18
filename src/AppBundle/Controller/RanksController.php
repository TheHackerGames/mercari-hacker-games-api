<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MilitarySkill;
use AppBundle\Entity\Rank;
use AppBundle\Entity\Skill;
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

class RanksController extends Controller
{
    /**
     * @SWG\Post(
     *   path="/ranks",
     *   summary="Create a rank",
     *   tags={"Ranks"},
     *   consumes={"application/json"},
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="Rank",
     *     required=true,
     *     @SWG\Schema(ref="#/definitions/Rank"),
     *   ),
     *   @SWG\Response(
     *     response="201",
     *     description="New rank created"
     *   ),
     *   @swg\Response(
     *     response="400",
     *     description="Invalid request"
     *   )
     * )
     * @Route("/ranks", name="create_rank")
     * @Method({"POST"})
     */
    public function addAction(Request $request)
    {
        $body = $request->getContent();
        $decodedBody = json_decode($body);

        if (
            !isset($decodedBody->name) ||
            !isset($decodedBody->military_id)
        ) {
            throw new BadRequestHttpException('Parameters are missing');
        }

        $rank = (new Rank())
            ->setName($decodedBody->name)
            ->setMilitaryId($decodedBody->military_id)
            ->setCreated(new \DateTime());

        $entityManager = $this->get('doctrine.orm.entity_manager');
        assert($entityManager instanceof EntityManager);
        $entityManager->persist($rank);
        $entityManager->flush();

        $data = ['rank' => $rank];

        $serializer = $this->container->get('jms_serializer');
        $content = $serializer->serialize($data, 'json');

        $jsonResponse = new JsonResponse();
        $jsonResponse->setContent($content);

        return $jsonResponse;
    }

    /**
     * @SWG\Post(
     *   path="/ranks/{rank_id}/skills",
     *   summary="Add skill to a rank",
     *   tags={"Ranks"},
     *   consumes={"application/json"},
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     description="rank_id to add the skill for",
     *     in="path",
     *     name="rank_id",
     *     required=true,
     *     type="integer"
     *   ),
     *   @SWG\Parameter(
     *     description="skill_id to add to the rank",
     *     in="path",
     *     name="skill_id",
     *     required=true,
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
     * @Route("/ranks/{rank_id}/skills/{skill_id}}", name="add_rank_skill")
     * @Method({"POST"})
     */
    public function addRankSkillsAction(Request $request)
    {
        $rankId = $request->get('rank_id');
        $skillId = $request->get('skill_id');

        $entityManager = $this->get('doctrine.orm.entity_manager');
        assert($entityManager instanceof EntityManager);

        $rankRepository = $entityManager
            ->getRepository(Rank::class);

        $rank = $rankRepository->find($rankId);
        if (!$rank) {
            throw new BadRequestHttpException('Rank id is invalid');
        }

        $skillRepository = $entityManager
            ->getRepository(Skill::class);

        $skill = $skillRepository->find($skillId);
        if (!$skill) {
            throw new BadRequestHttpException('Skill id is invalid');
        }

        // Check if skill is linked to the same military as rank - Reject if not
        $militarySkillRepository = $entityManager
            ->getRepository(MilitarySkill::class);
        //$militarySkillRepository->findBy(['military_id' => , 'skill_id' => $skillId])


    }

    /**
     * @SWG\Get(
     *   path="/ranks/{rank_id}/skills",
     *   summary="List skills associated to rank",
     *   tags={"Ranks"},
     *   consumes={"application/json"},
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     description="rank_id to fetch skills for",
     *     in="path",
     *     name="rank_id",
     *     required=true,
     *     type="integer"
     *   ),
     *   @SWG\Parameter(
     *     description="Number of results to fetch",
     *     in="query",
     *     name="limit",
     *     required=false,
     *     type="integer"
     *   ),
     *   @SWG\Parameter(
     *     description="Number of results to skip",
     *     in="query",
     *     name="offset",
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
     * @Route("/ranks/{rank_id}/skills", name="rank_skills")
     * @Method({"GET"})
     */
    public function listRankSkillsAction(Request $request)
    {
        $rankId = $request->get('rank_id');
        $limit = $request->get('limit', 50);
        $offset = $request->get('offset', 0);

        $entityManager = $this->get('doctrine.orm.entity_manager');
        assert($entityManager instanceof EntityManager);

        $rankRepository = $entityManager
            ->getRepository(Rank::class);

        $rank = $rankRepository->find($rankId);
        if (!$rank) {
            throw new BadRequestHttpException('Rank id is invalid');
        }

        $skillRepository = $entityManager
            ->getRepository(Skill::class);

        $skills = $skillRepository->findByRankId($rankId, $limit, $offset);
        $data = [ 'skills' => $skills ];

        $serializer = $this->container->get('jms_serializer');
        $content = $serializer->serialize($data, 'json');

        $jsonResponse = new JsonResponse();
        $jsonResponse->setStatusCode(200);
        $jsonResponse->setContent($content);

        return $jsonResponse;
    }
}