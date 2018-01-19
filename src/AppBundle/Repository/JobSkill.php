<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class JobSkill extends EntityRepository
{
    public function deleteByJobId(int $jobId)
    {
        $entityManager = $this->getEntityManager();
        $connection = $entityManager->getConnection();

        $sql = "DELETE FROM jobs_skills WHERE job_id = ?";

        $params = [$jobId];
        $types = [\PDO::PARAM_INT];

        return $connection->executeQuery($sql, $params, $types);
    }
}
