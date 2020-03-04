<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WorkRepository")
 */
class Work
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
    private $taskname;

    /**
     * @ORM\Column(type="integer")
     */
    private $worktime;

    /**
     * @ORM\Column(type="integer")
     */
    private $multiplier;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTaskname(): ?string
    {
        return $this->taskname;
    }

    public function setTaskname(string $taskname): self
    {
        $this->taskname = $taskname;

        return $this;
    }

    public function getWorktime(): ?int
    {
        return $this->worktime;
    }

    public function setWorktime(int $worktime): self
    {
        $this->worktime = $worktime;

        return $this;
    }

    public function getMultiplier(): ?int
    {
        return $this->multiplier;
    }

    public function setMultiplier(int $multiplier): self
    {
        $this->multiplier = $multiplier;

        return $this;
    }
}
