<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\User")
 * @ORM\Table(name="users")
 */
class User
{
    /**
     * @ORM\Column(type="integer", length=11)
     * @ORM\Id
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=32)
     * @var string
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=32)
     * @var string
     */
    protected $rank;

    /**
     * @ORM\Column(type="integer", length=11)
     * @var int
     */
    protected $military_id;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    protected $created;
}
