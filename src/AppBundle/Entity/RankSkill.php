<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RankSkill")
 * @ORM\Table(name="ranks_skills")
 */
class RankSkill
{
    /**
     * @ORM\Column(type="integer", length=11)
     * @ORM\Id
     * @var int
     */
    protected $rank_id;

    /**
     * @ORM\Column(type="integer", length=11)
     * @ORM\Id
     * @var string
     */
    protected $skill_id;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    protected $created;

    /**
     * Set rank id
     *
     * @param int $rank_id
     * @return $this
     */
    public function setRankId(int $rank_id)
    {
        $this->rank_id = $rank_id;

        return $this;
    }

    /**
     * Set skill id
     *
     * @param int $skill_id
     * @return $this
     */
    public function setSkillId(int $skill_id)
    {
        $this->skill_id = $skill_id;

        return $this;
    }

    /**
     * Set created date
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
