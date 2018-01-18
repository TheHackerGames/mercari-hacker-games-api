<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Job as JobEntity;
use Doctrine\ORM\EntityRepository;

class Job extends EntityRepository
{
    public function findBySkillIds(array $skillIds, int $limit, int $offset)
    {
        $entityManager = $this->getEntityManager();
        $connection = $entityManager->getConnection();

        $sanitizedSkillIds = array_map(function ($skillId) {
            return (int) $skillId;
        }, $skillIds);
        $skillIdsStr = implode(',', $sanitizedSkillIds);
        $sql = "
SELECT DISTINCT j.*
  FROM jobs j
       INNER JOIN jobs_skills js
          ON j.id = js.job_id
         AND js.skill_id IN ($skillIdsStr)
 GROUP BY j.id, j.user_id, j.title, j.description, j.salary, j.location, j.created
 ORDER BY COUNT(j.id) DESC, j.created DESC
 LIMIT ?
OFFSET ?";

        $params = [$limit, $offset];
        $types = [
            \PDO::PARAM_INT,
            \PDO::PARAM_INT,
        ];

        $results = $connection->fetchAll($sql, $params, $types);

        $jobs = [];
        foreach ($results as $result) {
            $created = \DateTime::createFromFormat(
                'Y-m-d H:i:s',
                $result['created']
            );

            $job = (new JobEntity())
                ->setId($result['id'])
                ->setUserId($result['user_id'])
                ->setTitle($result['title'])
                ->setDescription($result['description'])
                ->setSalary($result['salary'])
                ->setLocation($result['location'])
                ->setCreated($created);

            $jobs[] = $job;
        }

        return $jobs;
    }
}
