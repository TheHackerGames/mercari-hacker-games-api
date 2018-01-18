<?php

namespace AppBundle\Entity;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Job")
 * @ORM\Table(name="jobs")
 */
class Job
{
    /**
     * @ORM\Column(type="integer", length=11)
     * @ORM\Id
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="integer", length=11)
     * @var int
     */
    private $user_id;

    /**
     * @ORM\Column(type="string", length=64)
     * @var string
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @var string
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $created;
}
