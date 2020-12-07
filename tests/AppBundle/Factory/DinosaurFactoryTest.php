<?php

namespace Tests\AppBundle\Factory;

use AppBundle\Entity\Dinosaur;
use AppBundle\Service\DinosaurLengthDeterminator;
use Doctrine\ORM\Mapping as ORM;
use PHPUnit\Framework\TestCase;
use AppBundle\Factory\DinosaurFactory;

class DinosaurFactoryTest extends TestCase
{
    /**
     * @ORM\Column(type="string")
     */
    private $factory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    private $lengthDeterminator;

    public function setUp(): void
    {
        $this->lengthDeterminator = $this->createMock(DinosaurLengthDeterminator::class);
        $this->factory = new DinosaurFactory($this->lengthDeterminator);
    }

    public function testItGrowsAVelociraptor()
    {
        $dinosaur = $this->factory->growVelociraptor(5);

        $this->assertInstanceOf(Dinosaur::class, $dinosaur);
        $this->assertIsString($dinosaur->getGenus());
        $this->assertSame('Velociraptor', $dinosaur->getGenus());
        $this->assertSame(5, $dinosaur->getLength());

    }

    public function testItGrowsATriceratops()
    {
        $this->markTestIncomplete('waiting for confirmation');
    }

    public function testItGrowsABabyVelociraptor()
    {
        if (!class_exists('Nanny')) {
            $this->markTestSkipped('theres nobody to watch the baby');
        }
        $dinosaur = $this->factory->growVelociraptor(1);
        $this->assertSame(1, $dinosaur->getLength());
    }

    /**
     * @dataProvider getSpecificationTests
     */
    public function testItGrowsDinosaurFromSpecification(string $spec, bool $expectedIsCarnivorous)
    {
        //don't use this everywhere, were testing internal code not yours
        $this->lengthDeterminator->expects($this->once())
            ->method('getLengthFromSpecification')
            ->with($spec)
            ->willReturn(20);

        $dinosaur = $this->factory->growFromSpecification($spec);

        $this->assertSame($expectedIsCarnivorous, $dinosaur->isCarnivorous(), 'diets do not match');
        $this->assertSame(20, $dinosaur->getLength());
    }

    public function getSpecificationTests()
    {
        return [
            //spec, is carnivorous
            ['large carnivorous dinosaur', true],
            'default response' => ['give me all the cookies', false],
            ['large herbivore', false],
        ];
    }
}