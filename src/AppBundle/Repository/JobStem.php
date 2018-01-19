<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class JobStem extends EntityRepository
{
    public function deleteByJobId(int $jobId)
    {
        $entityManager = $this->getEntityManager();
        $connection = $entityManager->getConnection();

        $sql = "DELETE FROM jobs_stems WHERE job_id = ?";

        $params = [$jobId];
        $types = [ \PDO::PARAM_INT ];

        return $connection->executeQuery($sql, $params, $types);
    }
}
