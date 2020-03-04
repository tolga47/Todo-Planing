<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ApilistRepository")
 */
class Apilist
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $apiurl;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $idfield = [];

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $surefield;

    /**
     * @ORM\Column(type="string",  nullable=true)
     */
    private $multiplierfield;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getApiurl(): ?string
    {
        return $this->apiurl;
    }

    public function setApiurl(string $apiurl): self
    {
        $this->apiurl = $apiurl;

        return $this;
    }

    public function getIdfield(): ?string
    {
        return $this->idfield;
    }

    public function setIdfield(?string $idfield): self
    {
        $this->idfield = $idfield;

        return $this;
    }

    public function getSurefield(): ?string
    {
        return $this->surefield;
    }

    public function setSurefield(string $surefield): self
    {
        $this->surefield = $surefield;

        return $this;
    }

    public function getMultiplierfield(): ?string
    {
        return $this->multiplierfield;
    }

    public function setMultiplierfield(string $multiplierfield): self
    {
        $this->multiplierfield = $multiplierfield;

        return $this;
    }
}
