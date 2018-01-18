<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MilitarySkill")
 * @ORM\Table(name="militaries_skills")
 */
class MilitarySkill
{
    /**
     * @ORM\Column(type="integer", length=11)
     * @ORM\Id
     * @var int
     */
    protected $military_id;

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
     * Set military skill military id
     *
     * @param int $military_id
     * @return $this
     */
    public function setMilitaryId(int $military_id)
    {
        $this->military_id = $military_id;

        return $this;
    }

    /**
     * Set military skill skill id
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
     * Set military skill created date
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
