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
    private $id;

    /**
     * @ORM\Column(type="string", length=32)
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=32)
     * @var string
     */
    private $rank;

    /**
     * @ORM\Column(type="integer", length=11)
     * @var int
     */
    private $military_id;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $created;
}
