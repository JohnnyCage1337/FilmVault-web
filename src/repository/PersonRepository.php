<?php
require_once 'Repository.php';
require_once __DIR__.'/../models/Person.php';
class PersonRepository extends Repository
{
    public function addPerson(Person $person)
    {

            $stmt = $this->db->connect()->prepare("
            INSERT INTO people (first_name, last_name, birth_date, biography, image)
            VALUES (?, ?, ?, ?, ?)
        ");

            $stmt->execute([
                $person->getFirstName(),
                $person->getLastName(),
                $person->getBirthDate()->format('Y-m-d'),
                $person->getBiography(),
                $person->getImage(),
            ]);


    }

    public function personExists(Person $person): bool {
        $stmt = $this->db->connect()->prepare("
        SELECT 1 
        FROM people 
        WHERE first_name = ? 
          AND last_name = ? 
          AND birth_date = ? 
        LIMIT 1
    ");

        $stmt->execute([
            $person->getFirstName(),
            $person->getLastName(),
            $person->getBirthDate()->format('Y-m-d')
        ]);

        return $stmt->fetchColumn() !== false;
    }

    public function addFilmPersonRole(
        int $personId,
        int $filmId,
        int $roleId,
        ?string $roleFirstName = null,
        ?string $roleLastName = null
    ): void {
        try {
            $stmt = $this->db->connect()->prepare("
            INSERT INTO film_person_roles (film_id, person_id, role_id, role_first_name, role_last_name)
            VALUES (:filmId, :personId, :roleId, :roleFirstName, :roleLastName)
        ");

            $stmt->bindParam(':filmId', $filmId, PDO::PARAM_INT);
            $stmt->bindParam(':personId', $personId, PDO::PARAM_INT);
            $stmt->bindParam(':roleId', $roleId, PDO::PARAM_INT);
            $stmt->bindParam(':roleFirstName', $roleFirstName);
            $stmt->bindParam(':roleLastName', $roleLastName);

            $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Database failure: cannot add film-person-role relation. " . $e->getMessage());
        }
    }

    public function getPersonIdByName(string $firstName, string $lastName): ?int
    {
        $stmt = $this->db->connect()->prepare("
        SELECT id
        FROM people
        WHERE first_name = :first_name
          AND last_name = :last_name
        LIMIT 1
    ");
        $stmt->bindValue(':first_name', $firstName);
        $stmt->bindValue(':last_name', $lastName);
        $stmt->execute();

        $id = $stmt->fetchColumn();

        return $id !== false ? (int)$id : null;
    }


}
