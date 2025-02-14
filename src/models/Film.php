<?php

class Film
{
    private string $title;
    private int $year;
    private int $duration;
    private string $image;
    private string $description;

    private float $rating;
    private array $actors;
    private array $directors;
    private array $writers;
    private array $genres;

    private int $id;

    public function __construct(
        string $title,
        int $year,
        int $duration,
        string $image,
        string $description = "",
        float $rating = 0.0,
        array $actors = [],
        array $directors = [],
        array $writers = [],
        array $genres = []

    ) {
        $this->title = $title;
        $this->year = $year;
        $this->duration = $duration;
        $this->image = $image;
        $this->rating = $rating;
        $this->description = $description;
        $this->actors = $actors;
        $this->directors = $directors;
        $this->writers = $writers;
        $this->genres = $genres;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): void
    {
        $this->duration = $duration;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function setYear(int $year): void
    {
        $this->year = $year;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }


    public function getActors(): array { return $this->actors; }
    public function getDirectors(): array { return $this->directors; }
    public function getWriters(): array { return $this->writers; }
    public function getGenres(): array { return $this->genres; }

    public function getRating(): float
    {
        return $this->rating;
    }

    public function setRating(float $rating): void
    {
        $this->rating = $rating;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }




}
