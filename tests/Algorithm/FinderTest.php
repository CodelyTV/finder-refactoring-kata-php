<?php

declare(strict_types = 1);

namespace CodelyTV\FinderKataTest\Algorithm;

use CodelyTV\FinderKata\Algorithm\Finder;
use CodelyTV\FinderKata\Algorithm\NotEnoughPersonsException;
use CodelyTV\FinderKata\Algorithm\Person;
use CodelyTV\FinderKata\Domain\Model\PersonsPair\ClosestBirthDateCriteria;
use CodelyTV\FinderKata\Domain\Model\PersonsPair\FurthestBirthDateCriteria;
use PHPUnit\Framework\TestCase;

final class FinderTest extends TestCase
{
    /** @var Person */
    private $sue;

    /** @var Person */
    private $greg;

    /** @var Person */
    private $sarah;

    /** @var Person */
    private $mike;

    protected function setUp()
    {
        $this->sue   = new Person("Sue", new \DateTime("1950-01-01"));
        $this->greg  = new Person("Greg", new \DateTime("1952-05-01"));
        $this->sarah = new Person("Sarah", new \DateTime("1982-01-01"));
        $this->mike  = new Person("Mike", new \DateTime("1979-01-01"));
    }

    /** @test */
    public function should_throw_not_enough_persons_exception_when_given_empty_list(
    )
    {
        $allPersons = [];
        $finder     = new Finder();

        $this->expectException(NotEnoughPersonsException::class);

        $closestBirthDatePersonsPairsCriteria = new ClosestBirthDateCriteria();

        $finder->find($allPersons, $closestBirthDatePersonsPairsCriteria);
    }

    /** @test */
    public function should_throw_not_enough_persons_when_given_one_person()
    {
        $allPersons = [$this->sue];
        $finder     = new Finder();

        $this->expectException(NotEnoughPersonsException::class);

        $closestBirthDatePersonsPairsCriteria = new ClosestBirthDateCriteria();

        $finder->find($allPersons, $closestBirthDatePersonsPairsCriteria);
    }

    /** @test */
    public function should_return_closest_two_for_two_people()
    {
        $allPersons = [$this->sue, $this->greg];
        $finder     = new Finder();

        $closestBirthDatePersonsPairsCriteria = new ClosestBirthDateCriteria();

        $personsPairFound =
            $finder->find($allPersons, $closestBirthDatePersonsPairsCriteria);

        $this->assertEquals($this->sue, $personsPairFound->person1());
        $this->assertEquals($this->greg, $personsPairFound->person2());
    }

    /** @test */
    public function should_return_furthest_two_for_two_people()
    {
        $allPersons = [$this->mike, $this->greg];
        $finder     = new Finder();

        $furthestBirthDatePersonsPairsCriteria =
            new FurthestBirthDateCriteria();

        $personsPairFound =
            $finder->find($allPersons, $furthestBirthDatePersonsPairsCriteria);

        $this->assertEquals($this->greg, $personsPairFound->person1());
        $this->assertEquals($this->mike, $personsPairFound->person2());
    }

    /** @test */
    public function should_return_furthest_two_for_four_people()
    {
        $allPersons = [$this->sue, $this->sarah, $this->mike, $this->greg];
        $finder     = new Finder();

        $furthestBirthDatePersonsPairsCriteria =
            new FurthestBirthDateCriteria();

        $personsPairFound =
            $finder->find($allPersons, $furthestBirthDatePersonsPairsCriteria);

        $this->assertEquals($this->sue, $personsPairFound->person1());
        $this->assertEquals($this->sarah, $personsPairFound->person2());
    }

    /** @test */
    public function should_return_closest_two_for_four_people()
    {
        $allPersons = [$this->sue, $this->sarah, $this->mike, $this->greg];
        $finder     = new Finder();

        $closestBirthDatePersonsPairsCriteria = new ClosestBirthDateCriteria();

        $personsPairFound =
            $finder->find($allPersons, $closestBirthDatePersonsPairsCriteria);

        $this->assertEquals($this->sue, $personsPairFound->person1());
        $this->assertEquals($this->greg, $personsPairFound->person2());
    }
}
