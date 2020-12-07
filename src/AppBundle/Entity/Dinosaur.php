<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="dinosaurs")
 */
class Dinosaur
{
    const LARGE = 10;
    const HUGE = 30;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne (targetEntity="AppBundle\Entity\Enclosure", inversedBy="dinosaurs")
     */
    private $enclosure;

    /**
     * @ORM\Column(type="integer")
     */
    private $length = 0;

    /**
     * @ORM\Column(type="string")
     */
    private $genus;
    /**
     * @ORM\Column(type="boolean")
     */
    private $isCarnivorous;

    public function __construct(string $genus = 'unknown', bool $isCarnivorous = false)
    {
        $this->genus = $genus;
        $this->isCarnivorous = $isCarnivorous;
    }

    public function getLength(): int
    {
        return $this->length;
    }

    public function setLength(int $length)
    {
        $this->length = $length;
    }

    public function getSpecification(): string
    {
        return sprintf(
            'The %s %scarnivorous dinosaur is %s meters long',
            $this->genus,
            $this->isCarnivorous ? '' : 'non-',
            $this->length
        );
    }

    /**
     * @return string
     */
    public function getGenus(): string
    {
        return $this->genus;
    }

    /**
     * @return bool
     */
    public function isCarnivorous(): bool
    {
        return $this->isCarnivorous;
    }

    public function setEnclosure(Enclosure $enclosure)
    {
        $this->enclosure = $enclosure;
    }
}
