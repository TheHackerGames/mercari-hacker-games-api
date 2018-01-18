<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\JobSkill")
 * @ORM\Table(name="jobs_skills")
 */
class JobSkill
{
    /**
     * @ORM\Column(type="integer", length=11)
     * @ORM\Id
     * @var int
     */
    protected $job_id;

    /**
     * @ORM\Column(type="integer", length=11)
     * @ORM\Id
     * @var int
     */
    protected $skill_id;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    protected $created;

    public function getJobId()
    {
        return $this->job_id;
    }
}
