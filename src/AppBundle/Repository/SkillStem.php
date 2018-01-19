<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class SkillStem extends EntityRepository
{
    public function deleteBySkillId(int $skillId)
    {
        $entityManager = $this->getEntityManager();
        $connection = $entityManager->getConnection();

        $sql = "DELETE FROM skills_stems WHERE skill_id = ?";

        $params = [$skillId];
        $types = [\PDO::PARAM_INT];

        return $connection->executeQuery($sql, $params, $types);
    }
}
