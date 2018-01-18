<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Rank")
 * @ORM\Table(name="ranks")
 */
class Rank
{
    /**
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer", length=11)
     * @ORM\Id
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=64)
     * @var string
     */
    protected $name;

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

    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    public function setMilitaryId(int $militaryId)
    {
        $this->military_id = $militaryId;

        return $this;
    }

    public function setCreated(\DateTime $created)
    {
        $this->created = $created;

        return $this;
    }
}
