<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Stem")
 * @ORM\Table(name="stems")
 */
class Stem
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
    protected $stem;

    /**
     * @ORM\Column(type="string", length=64)
     * @var string
     */
    protected $word;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    protected $created;

    public function getId()
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get stem
     *
     * @return string
     */
    public function getStem()
    {
        return $this->stem;
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

    public function setCreated(\DateTime $created)
    {
        $this->created = $created;

        return $this;
    }
}
