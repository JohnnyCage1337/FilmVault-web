<?php

class Genre implements JsonSerializable
{
    private $id;
    private $name;


    public function __construct($name, $id = null)
    {
        $this->id = $id;
        $this->name = $name;
    }


    public function getId()
    {
        return $this->id;
    }


    public function setId($id): void
    {
        $this->id = $id;
    }


    public function getName()
    {
        return $this->name;
    }


    public function setName($name): void
    {
        $this->name = $name;
    }

    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }


}