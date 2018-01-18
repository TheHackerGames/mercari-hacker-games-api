<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

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
