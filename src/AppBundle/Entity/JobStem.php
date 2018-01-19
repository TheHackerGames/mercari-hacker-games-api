<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\JobStem")
 * @ORM\Table(name="jobs_stems")
 */
class JobStem
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
    protected $stem_id;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    protected $created;

    /**
     * Set job id
     *
     * @param int $jobId
     * @return $this
     */
    public function setJobId(int $jobId)
    {
        $this->job_id = $jobId;

        return $this;
    }

    /**
     * Set stem id
     *
     * @param int $stemId
     * @return $this
     */
    public function setStemId(int $stemId)
    {
        $this->stem_id = $stemId;

        return $this;
    }

    /**
     * Set created
     *
     * @param DateTime $created
     * @return $this
     */
    public function setCreated(DateTime $created)
    {
        $this->created = $created;

        return $this;
    }
}
