<?php

/**
 * Klasa użytkownika
 */
class User {
    private int $id;
    private string $email;
    private string $password;
    private string $name;

    private string $role;

    public function __construct(string $email, string $password, string $name) {
        $this->email = $email;
        $this->password = $password;
        $this->name = $name;
    }



    
    public function getEmail(): string {
        return $this->email;
    }

    
    public function setEmail(string $email): void {
        $this->email = $email;
    }

    
    public function getPassword(): string {
        return $this->password;
    }

   
    public function setPassword(string $password): void {
        $this->password = $password;
    }

    
    public function getName(): string {
        return $this->name;
    }

    
    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(string $role): void
    {
        $this->role = $role;
    }


}


