<?php

class Person
{
    private ?int $id;
    private string $firstName;
    private string $lastName;
    private ?\DateTime $birthDate;
    private ?string $biography;
    private ?string $image;

    /**
     * @param string $firstName
     * @param string $lastName
     * @param DateTime|null $birthDate
     * @param string|null $biography
     * @param string|null $image
     * @param int|null $id
     */
    public function __construct(
        string $firstName,
        string $lastName,
        ?\DateTime $birthDate = null,
        ?string $biography = null,
        ?string $image = null,
        ?int $id = null
    ) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->birthDate = $birthDate;
        $this->biography = $biography;
        $this->image = $image;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getBiography(): ?string
    {
        return $this->biography;
    }

    public function setBiography(?string $biography): void
    {
        $this->biography = $biography;
    }

    public function getBirthDate(): ?\DateTime
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTime $birthDate): void
    {
        $this->birthDate = $birthDate;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): void
    {
        $this->image = $image;
    }
}
