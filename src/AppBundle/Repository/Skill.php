<?php

namespace AppBundle\Repository;

use DateTime;
use AppBundle\Entity\Skill as SkillEntity;
use Doctrine\ORM\EntityRepository;

class Skill extends EntityRepository
{
    /**
     * Fetch the skills in popularity order by a military id
     *
     * @param int $militaryId
     * @param int $limit
     * @param int $offset
     * @return Skill[]
     */
    public function findByMilitaryId(int $militaryId, int $limit, int $offset)
    {
        $entityManager = $this->getEntityManager();
        $connection = $entityManager->getConnection();

        $sql = "SELECT s.*
        FROM skills s
        INNER JOIN militaries_skills ms ON ms.skill_id = s.id
        LEFT JOIN users_skills us ON us.skill_id = ms.skill_id
        WHERE ms.military_id = ?
        GROUP BY s.id
        ORDER BY COUNT(DISTINCT us.user_id) DESC, s.name
        LIMIT ?
        OFFSET ?";


        $params = [$militaryId, $limit, $offset];
        $types = [
            \PDO::PARAM_INT,
            \PDO::PARAM_INT,
            \PDO::PARAM_INT
        ];

        $results = $connection->fetchAll($sql, $params, $types);

        $skills = [];
        foreach ($results as $result) {
            $created = DateTime::createFromFormat(
                'Y-m-d H:i:s',
                $result['created']
            );

            $skill = new SkillEntity();
            $skill->setId($result['id'])
                ->setName($result['name'])
                ->setCreated($created);

            $skills[] = $skill;
        }

        return $skills;
    }


    /**
     * Fetch the skills in popularity order by a rank id
     *
     * @param int $rankId
     * @param int $limit
     * @param int $offset
     * @return Skill[]
     */
    public function findByRankId(int $rankId, int $limit, int $offset)
    {
        $entityManager = $this->getEntityManager();
        $connection = $entityManager->getConnection();

        $sql = "SELECT s.*
        FROM skills s
        INNER JOIN ranks_skills rs ON rs.skill_id = s.id
        LEFT JOIN users_skills us ON us.skill_id = s.id
        WHERE rs.rank_id = ?
        GROUP BY s.id
        ORDER BY COUNT(DISTINCT us.user_id) DESC, s.name
        LIMIT ?
        OFFSET ?";

        $params = [$rankId, $limit, $offset];
        $types = [
            \PDO::PARAM_INT,
            \PDO::PARAM_INT,
            \PDO::PARAM_INT
        ];

        $results = $connection->fetchAll($sql, $params, $types);

        $skills = [];
        foreach ($results as $result) {
            $created = DateTime::createFromFormat(
                'Y-m-d H:i:s',
                $result['created']
            );

            $skill = new SkillEntity();
            $skill->setId($result['id'])
                ->setName($result['name'])
                ->setCreated($created);

            $skills[] = $skill;
        }

        return $skills;
    }
}
