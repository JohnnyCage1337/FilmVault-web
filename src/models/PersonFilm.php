<?php

class PersonFilm
{
    private Person $person;
    private $fist_name;
    private $last_name;


    /**
     * @param Person $person
     * @param $fist_name
     * @param $last_name
     */
    public function __construct(Person $person, $fist_name, $last_name)
    {
        $this->person = $person;
        $this->fist_name = $fist_name;
        $this->last_name = $last_name;
    }

    public function getPerson(): Person
    {
        return $this->person;
    }

    public function setPerson(Person $person): void
    {
        $this->person = $person;
    }

    /**
     * @return mixed
     */
    public function getFistName()
    {
        return $this->fist_name;
    }

    /**
     * @param mixed $fist_name
     */
    public function setFistName($fist_name): void
    {
        $this->fist_name = $fist_name;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param mixed $last_name
     */
    public function setLastName($last_name): void
    {
        $this->last_name = $last_name;
    }



}