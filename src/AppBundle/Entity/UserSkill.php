<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserSkill")
 * @ORM\Table(name="users_skills")
 */
class UserSkill
{
    /**
     * @ORM\Column(type="integer", length=11)
     * @ORM\Id
     * @var int
     */
    protected $user_id;

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

    public function getSkillId()
    {
        return $this->skill_id;
    }
}
