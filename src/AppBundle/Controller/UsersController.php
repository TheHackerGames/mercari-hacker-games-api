<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Skill;
use AppBundle\Entity\User;
use AppBundle\Entity\UserSkill;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
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

class UsersController extends Controller
{
    /**
     * @SWG\Get(
     *   path="/users/{user_id}",
     *   summary="Fetch a user",
     *   tags={"User"},
     *   consumes={"application/json"},
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     description="user_id to fetch",
     *     in="path",
     *     name="user_id",
     *     required=true,
     *     type="integer"
     *   ),
     *   @SWG\Response(
     *     response="200",
     *     description="User found"
     *   ),
     *   @SWG\Response(
     *     response="404",
     *     description="User not found"
     *   )
     * )
     * @Route("/users/{user_id}", name="read_one_user")
     * @Method({"GET"})
     */
    public function getAction(Request $request)
    {
        $userRepository = $this->get('doctrine.orm.entity_manager')
            ->getRepository(User::class);
        assert($userRepository instanceof EntityRepository);

        $user = $userRepository->find($request->get('user_id'));

        if (!$user) {
            $jsonResponse = new JsonResponse();
            $jsonResponse->setStatusCode(404);
            return $jsonResponse;
        }

        $data = ['user' => $user];

        $serializer = $this->container->get('jms_serializer');
        $content = $serializer->serialize($data, 'json');

        $jsonResponse = new JsonResponse();
        $jsonResponse->setContent($content);

        return $jsonResponse;
    }

    /**
     * @SWG\Post(
     *   path="/users",
     *   summary="Create a new user",
     *   tags={"User"},
     *   consumes={"application/json"},
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="User",
     *     required=true,
     *     @SWG\Schema(ref="#/definitions/User"),
     *   ),
     *   @SWG\Response(
     *     response="201",
     *     description="New user created"
     *   ),
     *   @swg\Response(
     *     response="400",
     *     description="Invalid request"
     *   )
     * )
     * @Route("/users", name="create_user")
     * @Method({"POST"})
     */
    public function registerAction(Request $request)
    {
        $body = $request->getContent();
        $decodedBody = json_decode($body);

        if (
            !isset($decodedBody->name) ||
            !isset($decodedBody->rank) ||
            !isset($decodedBody->military_id)
        ) {
            throw new BadRequestHttpException('Parameters are missing');
        }

        $user = (new User())
            ->setName($decodedBody->name)
            ->setRank($decodedBody->rank)
            ->setMilitaryId($decodedBody->military_id)
            ->setCreated(new \DateTime());

        /** @var EntityManager $entityManager */
        $entityManager = $this->get('doctrine.orm.entity_manager');
        $entityManager->persist($user);

        try {
            $entityManager->flush();
        } catch (ForeignKeyConstraintViolationException $e) {
            throw new BadRequestHttpException('Invalid military id');
        }

        $data = ['user' => $user];

        $serializer = $this->container->get('jms_serializer');
        $content = $serializer->serialize($data, 'json');

        $jsonResponse = new JsonResponse();
        $jsonResponse->setContent($content);

        return $jsonResponse;
    }

    /**
     * @SWG\Get(
     *   path="/users/{user_id}/skills",
     *   summary="Get list of skills by user_id",
     *   tags={"User"},
     *   consumes={"application/json"},
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     description="user_id to fetch",
     *     in="path",
     *     name="user_id",
     *     required=true,
     *     type="integer"
     *   ),
     *   @SWG\Response(
     *     response="200",
     *     description="List of user's skills returned"
     *   )
     * )
     * @Route("/users/{user_id}/skills", name="read_skills")
     * @Method({"GET"})
     */
    public function getSkillsAction(Request $request)
    {
        $entityManager = $this->get('doctrine.orm.entity_manager');
        assert($entityManager instanceof EntityManager);

        $userRepository = $entityManager
            ->getRepository(User::class);
        assert($userRepository instanceof EntityRepository);

        $user = $userRepository->find($request->get('user_id'));

        if (!$user) {
            throw new NotFoundHttpException('User not found');
        }

        $userSkillRepository = $entityManager
            ->getRepository(UserSkill::class);
        assert($userSkillRepository instanceof EntityRepository);

        $criteria = ['user_id' => $user->getId()];
        $userSkills = $userSkillRepository->findBy($criteria);

        $skillRepository = $entityManager
            ->getRepository(Skill::class);
        assert($skillRepository instanceof EntityRepository);

        $criteria = ['id' => array_map(function (UserSkill $userSkill) {
            return $userSkill->getSkillId();
        }, $userSkills)];
        $skills = $skillRepository->findBy($criteria);

        $data = ['skills' => $skills];

        $serializer = $this->container->get('jms_serializer');
        $content = $serializer->serialize($data, 'json');

        $jsonResponse = new JsonResponse();
        $jsonResponse->setContent($content);

        return $jsonResponse;
    }

    /**
     * @SWG\Post(
     *   path="/users/{user_id}/skills/{skill_id}",
     *   summary="Add a skill to user",
     *   tags={"User"},
     *   consumes={"application/json"},
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     description="user_id to add a skill to",
     *     in="path",
     *     name="user_id",
     *     required=true,
     *     type="integer"
     *   ),
     *   @SWG\Parameter(
     *     description="skill_id to add",
     *     in="path",
     *     name="skill_id",
     *     required=true,
     *     type="integer"
     *   ),
     *   @SWG\Response(
     *     response="201",
     *     description="Skill added"
     *   ),
     *   @swg\Response(
     *     response="400",
     *     description="Invalid request"
     *   )
     * )
     * @Route("/users/{user_id}/skills/{skill_id}", name="add_skill")
     * @Method({"POST"})
     */
    public function addSkillAction(Request $request)
    {
    }

    /**
     * @SWG\Delete(
     *   path="/users/{user_id}/skills/{skill_id}",
     *   summary="Delete a skill from user",
     *   tags={"User"},
     *   consumes={"application/json"},
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     description="user_id to delete a skill from",
     *     in="path",
     *     name="user_id",
     *     required=true,
     *     type="integer"
     *   ),
     *   @SWG\Parameter(
     *     description="skill_id to delete",
     *     in="path",
     *     name="skill_id",
     *     required=true,
     *     type="integer"
     *   ),
     *   @SWG\Response(
     *     response="200",
     *     description="Skill deleted"
     *   ),
     *   @swg\Response(
     *     response="400",
     *     description="Invalid request"
     *   )
     * )
     * @Route("/users/{user_id}/skills/{skill_id}", name="delete_skill")
     * @Method({"DELETE"})
     */
    public function deleteSkillAction(Request $request)
    {
    }
}
