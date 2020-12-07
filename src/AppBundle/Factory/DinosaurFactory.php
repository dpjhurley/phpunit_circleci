<?php


namespace AppBundle\Factory;

use AppBundle\Entity\Dinosaur;
use AppBundle\Service\DinosaurLengthDeterminator;

class DinosaurFactory
{
    private $lengthDeterminator;

    public function __construct(DinosaurLengthDeterminator $lengthDeterminator)
    {
        $this->lengthDeterminator = $lengthDeterminator;
    }

    public function growVelociraptor(int $int): Dinosaur
    {
        return $this->createDinosaur('Velociraptor', true, $int);
    }

    public function growFromSpecification(string $specification): Dinosaur
    {
        $codename = 'InG-'.random_int(1, 99999);
        $length = $this->lengthDeterminator->getLengthFromSpecification($specification);
        $isCarnivorous = false;


        if (stripos($specification, 'carnivorous') !== false) {
            $isCarnivorous = true;
        }

        $dinosaur = $this->createDinosaur($codename, $isCarnivorous, $length);

        return $dinosaur;
    }

    private function createDinosaur(string $genus, bool $isCarnivorous, int $int): Dinosaur
    {
        $dinosaur = new Dinosaur($genus, $isCarnivorous);

        $dinosaur->setLength($int);

        return $dinosaur;
    }


}