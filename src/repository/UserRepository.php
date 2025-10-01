<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';

class UserRepository extends Repository
{

    public function getUserByEmail(string $email): ?User
    {
        $stmt = $this->db->connect()->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user === false) {
            return null;
        }

        $result = new User( $user['email'], $user['password'], $user['name']);
        $result->setId($user['id']);
        $result->setRole($user['role']);

        return $result;
    }

    public function getUserById(int $id): ?User
    {
        $stmt = $this->db->connect()->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user === false) {
            return null;
        }

        $result = new User( $user['email'], $user['password'], $user['name']);
        $result->setId($user['id']);
        $result->setRole($user['role']);

        return $result;
    }

    public function addUser(User $user){
        $stmt = $this->db->connect()->prepare("
        INSERT INTO users (name, email, password, role)
        VALUES (?,?,?,?)");

        $stmt->execute([
            $user->getName(),
            $user->getEmail(),
            $user->getPassword()
            , 'user'
        ]);
    }

    public function addFilmToWatchlist(int $userId, int $filmId){
        $stmt = $this->db->connect()->prepare("
    INSERT INTO user_watchlist (user_id, film_id)
    VALUES (?, ?)");

        $stmt->execute([$userId, $filmId]);
    }


}
