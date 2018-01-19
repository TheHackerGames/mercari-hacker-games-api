<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\JobStem")
 * @ORM\Table(name="jobs_stem")
 */
class JobStem
{
    /**
     * @ORM\Column(type="integer", length=11)
     * @ORM\Id
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="integer", length=11)
     * @var int
     */
    protected $job_id;

    /**
     * @ORM\Column(type="string", length=64)
     * @var string
      */
    protected $word;

    /**
     * @ORM\Column(type="string", length=64)
     * @var string
     */
    protected $stem;

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
     * Set word
     *
     * @param string $word
     * @return $this
     */
    public function setWord(string $word)
    {
        $this->word = $word;

        return $this;
    }

    /**
     * Set stem
     *
     * @param string $stem
     * @return $this
     */
    public function setStem(string $stem)
    {
        $this->stem = $stem;

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
