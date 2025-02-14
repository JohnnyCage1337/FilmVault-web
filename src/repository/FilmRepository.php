<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Film.php';
require_once __DIR__.'/../models/Person.php';
require_once __DIR__.'/../models/PersonFilm.php';


class FilmRepository extends Repository
{
    public function getFilmsById(int $id): ?Film
    {
        $stmt = $this->db->connect()->prepare("SELECT * FROM films WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        $film = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($film == false) {
            return null;
        }

        $filmModel = new Film(
            $film['title'],
            (int)$film['release_year'],
            (int)$film['duration'],
            $film['image'],
            $film['description'],
            (float)$film['rating']
        );
        $filmModel->setId((int)$film['id']);

        return $filmModel;
    }

    public function getFilmsNewReleases(): array
    {
        $result = [];

        $stmt = $this->db->connect()->prepare("
            SELECT * FROM films ORDER BY release_year DESC LIMIT 5
        ");
        $stmt->execute();
        $films = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($films as $film) {
            $filmModel = new Film(
                $film['title'],
                (int)$film['release_year'],
                (int)$film['duration'],
                $film['image'],
                $film['description'],
                (float)$film['rating']
            );
            $filmModel->setId((int)$film['id']);
            $result[] = $filmModel;
        }

        return $result;
    }

    public function getFilmsTopPicks(): array
    {
        $result = [];

        $stmt = $this->db->connect()->prepare("
            SELECT * FROM films ORDER BY rating DESC LIMIT 5
        ");
        $stmt->execute();
        $films = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($films as $film) {
            $filmModel = new Film(
                $film['title'],
                (int)$film['release_year'],
                (int)$film['duration'],
                $film['image'],
                $film['description'],
                (float)$film['rating']
            );
            $filmModel->setId((int)$film['id']);
            $result[] = $filmModel;
        }

        return $result;
    }

    public function getFilmsRecommended(): array
    {
        $result = [];

        $stmt = $this->db->connect()->prepare("
            SELECT * FROM films ORDER BY RANDOM() LIMIT 5
        ");
        $stmt->execute();
        $films = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($films as $film) {
            $filmModel = new Film(
                $film['title'],
                (int)$film['release_year'],
                (int)$film['duration'],
                $film['image'],
                $film['description'],
                (float)$film['rating']
            );
            $filmModel->setId((int)$film['id']);
            $result[] = $filmModel;
        }

        return $result;
    }

    public function getFilmsByTitle(string $searchString): array
    {
        $searchString = '%' . strtolower($searchString) . '%';
        $result = [];

        $stmt = $this->db->connect()->prepare('
            SELECT * FROM films WHERE LOWER(title) LIKE :search
        ');
        $stmt->bindParam(":search", $searchString, PDO::PARAM_STR);
        $stmt->execute();

        $films = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($films as $film) {
            $filmModel = new Film(
                $film['title'],
                (int)$film['release_year'],
                (int)$film['duration'],
                $film['image'],
                $film['description'],
                (float)$film['rating']
            );
            $filmModel->setId((int)$film['id']);
            $result[] = $filmModel;
        }

        return $result;
    }

    public function addFilm(Film $film)
    {
        $stmt = $this->db->connect()->prepare("
            INSERT INTO films (title, release_year, duration, image, description)
            VALUES (?,?,?,?,?) RETURNING id
        ");

        $stmt->execute([
            $film->getTitle(),
            $film->getYear(),
            $film->getDuration(),
            $film->getImage(),
            $film->getDescription(),
        ]);

        $filmId = $stmt->fetchColumn();

        return $filmId;
    }

    public function addFilmToWatchList(int $filmId, int $userId)
    {
        try {
            $stmt = $this->db->connect()->prepare("
            INSERT INTO watchlist (user_id, film_id, date_added, watched)
            VALUES (?, ?, CURRENT_TIMESTAMP, false)
        ");
            $stmt->execute([$userId, $filmId]);
        } catch (PDOException $e) {
            throw new Exception("DataBase failure: " . "cannot add film to watchlist");
        }
    }

    public function addFilmCategoryRelation(Film $film, Genre $genre)
    {

            $stmt = $this->db->connect()->prepare("
            INSERT INTO film_categories (film_id, category_id)
            VALUES (?, ?)
        ");
            $stmt->execute([
                $film->getId(),
                $genre->getId()
            ]);

        return true;
    }

    public function filmCategoryRelationExists(Film $film, Genre $genre): bool
    {
        try {
            $stmt = $this->db->connect()->prepare("
            SELECT 1
            FROM film_categories
            WHERE film_id = ? AND category_id = ?
            LIMIT 1
        ");
            $stmt->execute([
                $film->getId(),
                $genre->getId()
            ]);
            return (bool)$stmt->fetchColumn();
        } catch (PDOException $e) {
            throw new Exception("Database failure: cannot check film-category relation");
        }
    }

    public function getFilmsByWatchlist(int $userId){
        try{
            $stmt = $this->db->connect()->prepare("SELECT * FROM watchlist_view WHERE user_id = :user_id");
            $stmt->bindParam(":user_id", $userId, PDO::PARAM_INT);
            $stmt->execute();

            $films = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($films as $film) {
                $filmModel = new Film(
                    $film['title'],
                    (int)$film['release_year'],
                    (int)$film['duration'],
                    $film['image'],
                    $film['description'],
                    (float)$film['rating']
                );
                $filmModel->setId((int)$film['film_id']);
                $result[] = $filmModel;
            }
            return $result;

        }catch (PDOException $e){
            throw new Exception("DataBase failure: " . "cannot get films from watchlist");
        }
    }

    public function isGenreExist(string $genre) {
        $stmt = $this->db->connect()->prepare("SELECT * FROM categories WHERE LOWER(name) = LOWER(:genre)");
        $stmt->bindParam(":genre", $genre, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (bool)$result;
    }

    public function getAllGenres() {
        $stmt = $this->db->connect()->prepare("SELECT * FROM categories");
        $stmt->execute();

        $genres = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result = [];

        foreach ($genres as $genreData) {
            $genreModel = new Genre(
                (int)$genreData['id'],
                $genreData['name']
            );

            $result[] = $genreModel;
        }
        return $result;
    }

    public function isPeopleInDataBase(string $firstName, string $lastName): bool {
        $stmt = $this->db->connect()->prepare(
            "SELECT * FROM people 
         WHERE LOWER(first_name) = LOWER(:firstName) 
           AND LOWER(last_name) = LOWER(:lastName)"
        );
        $stmt->bindParam(':firstName', $firstName, PDO::PARAM_STR);
        $stmt->bindParam(':lastName', $lastName, PDO::PARAM_STR);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row !== false;
    }

    public function addGenre(Genre $genre) : int
    {
            $stmt = $this->db->connect()->prepare("
            INSERT INTO categories (name)
            VALUES (?) RETURNING id
        ");
            $stmt->execute([$genre->getName()]);
            $genreId = $stmt->fetchColumn();

        return $genreId;
    }



    public function isFilmExistsByTitle(string $title): bool
    {
        $title = strtolower($title);

        $stmt = $this->db->connect()->prepare('
        SELECT 1
        FROM films
        WHERE LOWER(title) = :title
        LIMIT 1
    ');

        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->execute();

        return (bool) $stmt->fetchColumn();
    }

    public function getRoleIdByName(string $string)
    {
        $stmt = $this->db->connect()->prepare("SELECT id FROM roles WHERE name = :name");
        $stmt->bindParam(":name", $string, PDO::PARAM_STR);
        $stmt->execute();
        $genres = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $genres[0]['id'];
    }

    public function getGenreByName(string $genreName)
    {
        try {
            $stmt = $this->db->connect()->prepare("SELECT * FROM categories WHERE name = :name LIMIT 1");
            $stmt->bindParam(":name", $genreName, PDO::PARAM_STR);
            $stmt->execute();

            $genreData = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($genreData) {
                $genre = new Genre($genreData['name'],$genreData['id']);
                return $genre;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            throw new Exception("DataBase failure: cannot get genre by name", 0, $e);
        }
    }

    public function getFilmDetailsById(int $id): ?Film
    {
        $stmt = $this->db->connect()->prepare("SELECT * FROM film_details WHERE film_id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        $filmData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$filmData) {
            return null;
        }

        $actors = [];
        $directors = [];
        $writers = [];

        if (!empty($filmData['cast'])) {
            $castEntries = explode(";", $filmData['cast']);

            foreach ($castEntries as $entry) {
                $data = explode("|", $entry);


                if (count($data) < 5) {
                    continue;
                }

                $role = $data[0];
                $personId = (int)$data[1];
                $firstName = $data[2];
                $lastName = $data[3];
                $image = !empty($data[4]) ? $data[4] : null;
                $roleFirstName = $data[5] ?? null;
                $roleLastName = $data[6] ?? null;

                $person = new Person($firstName, $lastName, null, null, $image, $personId);

                if ($role === "actor") {
                    $actors[] = new PersonFilm($person, $roleFirstName, $roleLastName);
                } elseif ($role === "director") {
                    $directors[] = $person;
                } elseif ($role === "screenwriter") {
                    $writers[] = $person;
                }
            }
        }

        $categories = !empty($filmData['categories']) ? explode(", ", $filmData['categories']) : [];

        $film = new Film(
            $filmData['title'],
            (int)$filmData['release_year'],
            (int)$filmData['duration'],
            $filmData['film_image'],
            $filmData['description'],
            (float)$filmData['rating'],
            $actors,
            $directors,
            $writers,
            $categories
        );

        $film->setId((int)$filmData['film_id']);

        return $film;
    }


    public function addFilmToCategory(Film $film, Genre $genre)
    {
        try {
            $stmt = $this->db->connect()->prepare("
            INSERT INTO film_categories (film_id, category_id)
            VALUES (?, ?)
        ");
            $stmt->execute([
                $film->getId(),
                $genre->getId()
            ]);
        } catch (PDOException $e) {
            throw new Exception("Database failure: cannot add film to category");
        }
    }


}
