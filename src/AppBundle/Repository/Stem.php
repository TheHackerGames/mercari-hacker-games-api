<?php

namespace AppBundle\Repository;

use DateTime;
use AppBundle\Entity\Stem as StemEntity;
use Doctrine\ORM\EntityRepository;

class Stem extends EntityRepository
{
    /**
     * @param int $jobId
     * @return Job[]
     */
    public function findByJobId(int $jobId)
    {
        $entityManager = $this->getEntityManager();
        $connection = $entityManager->getConnection();

        $sql = "SELECT s.*
        FROM stems s
        INNER JOIN jobs_stems js ON js.stem_id = s.id
        WHERE js.job_id = ?";

        $params = [ $jobId ];
        $types = [ \PDO::PARAM_INT ];

        $results = $connection->fetchAll($sql, $params, $types);

        $stems = [];
        foreach ($results as $result) {

            $created = DateTime::createFromFormat(
                'Y-m-d H:i:s',
                $result['created']
            );

            $stem = new StemEntity();
            $stem->setId($result['id'])
                ->setStem($result['stem'])
                ->setWord($result['word'])
                ->setCreated($created);

            $stems[] = $stem;
        }

        return $stems;
    }
}
