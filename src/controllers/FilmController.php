<?php

require_once 'AppController.php';
require_once __DIR__ . '/../repository/FilmRepository.php';
require_once __DIR__ . '/../repository/PersonRepository.php';

require_once __DIR__ . '/../models/Film.php';
require_once __DIR__ . '/../models/Genre.php';
require_once __DIR__ . '/../models/Person.php';


class FilmController extends AppController
{
    const MAX_FILE_SIZE = 1024 * 1024;
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg'];
    const UPLOAD_DIRECTORY = __DIR__ . '/../../public/uploads/';

    private $messages = [];
    private $filmRepository;
    private $personRepository;


    public function __construct()
    {
        parent::__construct();
        $this->filmRepository = new FilmRepository();
        $this->personRepository = new PersonRepository();
    }

    public function dashboard()
    {
        $userId = $this->validateSessionToken();
        if($userId) {
            $userRole = $this->getUserRole($userId);
        }

        $newReleases = $this->filmRepository->getFilmsNewReleases();
        $topPicks = $this->filmRepository->getFilmsTopPicks();
        $recommendedFilms = $this->filmRepository->getFilmsRecommended();
        $this->render('dashboard', [
            'newReleases' => $newReleases,
            'topPicks' => $topPicks,
            'recommendedFilms' => $recommendedFilms,
            'userRole' => $userRole ?? null]);
    }

    public function addFilm()
    {
        $userId = $this->validateSessionToken();
        $userRole = null;
        if ($userId) {
            $userRole = $this->getUserRole($userId);
        }

        if($userRole !== 'admin') {
            header("Location: /dashboard");
            return;
        }

        $directorRoleId   = $this->filmRepository->getRoleIdByName('director');
        $screenwriterRoleId = $this->filmRepository->getRoleIdByName('screenwriter');
        $actorRoleId      = $this->filmRepository->getRoleIdByName('actor');
        $peopleInput =$_POST['people'];
        $peopleTokens = array_map('trim', explode('/', $peopleInput));

        $directorsTokens = array_map('trim', explode(',', $peopleTokens[0]));
        $screenwritersTokens = array_map('trim', explode(',', $peopleTokens[1]));
        $actorsTokens = array_map('trim', explode(',', $peopleTokens[2]));





        if (
            $this->isPost() &&
            is_uploaded_file($_FILES['image']['tmp_name']) &&
            $this->validate($_FILES['image'])
        ) {
            move_uploaded_file(
                $_FILES['image']['tmp_name'],
                self::UPLOAD_DIRECTORY . $_FILES['image']['name']
            );
            $genresInput  = $_POST['genre'];
            $genreNames  = array_map('trim', explode(',', $genresInput));
            foreach ($genreNames as $genreName) {
                $genre = new Genre($genreName);

                if(!$this->filmRepository->isGenreExist($genreName)) {
                    $id = $this->filmRepository->addGenre($genre);
                    $genre->setId($id);
                }
                else{
                    $genre = $this->filmRepository->getGenreByName($genreName);
                }
                $genresArray[] = $genre;

            }

            $film = new Film($_POST['title'], $_POST['year'], $_POST['duration'], $_FILES['image']['name'], $_POST['description']);
            if($this->filmRepository->isFilmExistsByTitle($_POST['title'])) {
                 $this->render('formFilm', ['messages' => ['Film with this title already exists']]);
                 return;
            }
            $id = $this->filmRepository->addFilm($film);
            $film->setId($id);


                foreach ($genresArray as $genre) {
                    $this->filmRepository->addFilmCategoryRelation($film, $genre);
                }

            foreach ($actorsTokens as $actorToken) {
                $nameParts = $this->parseActorAndCharacter($actorToken);
                $firstName = $nameParts['nameActor'];
                $lastName = $nameParts['surnameActor'];
                $characterName = $nameParts['nameInFilm'];
                $characterLastName = $nameParts['surnameInFilm'];

                $actor = new Person($firstName, $lastName);
                $id = $this->personRepository->getPersonIdByName($firstName, $lastName);
                $this->personRepository->addFilmPersonRole($id,$film->getId() ,$actorRoleId, $characterName, $characterLastName);

            }


            foreach ($directorsTokens as $directorToken) {
                $nameParts = explode(" ", $directorToken, 2);
                $firstName = $nameParts[0];
                $lastName = $nameParts[1] ?? '';
                $director = new Person($firstName, $lastName);
                $id = $this->personRepository->getPersonIdByName($firstName, $lastName);
                    $this->personRepository->addFilmPersonRole($id,$film->getId() ,$directorRoleId);


            }

            foreach ($screenwritersTokens as $screenwriterToken) {
                $nameParts = explode(" ", $screenwriterToken, 2);
                $firstName = $nameParts[0];
                $lastName = $nameParts[1] ?? '';
                $screenwriter = new Person($firstName, $lastName);
                $id = $this->personRepository->getPersonIdByName($firstName, $lastName);
                    $this->personRepository->addFilmPersonRole($id,$film->getId() ,$screenwriterRoleId);


            }


             $this->render('formFilm', ['messages' => ['Film added']]);
             return;
        }

        $this->render('formFilm', ['messages' => ['Film not added']]);
        return;
    }



    public function search()
    {
        $query = isset($_GET['q']) ? trim($_GET['q']) : '';

        if (empty($query)) {
            $this->render('results', [
                'films' => [],
                'query' => $query,
                'messages' => ['Podaj słowo kluczowe do wyszukiwania.']
            ]);
            return;
        }

        $films = $this->filmRepository->getFilmsByTitle($query);

        $this->render('results', [
            'films' => $films,
            'query' => $query
        ]);
    }

    public function watchlist()
    {
        $userId = $this->validateSessionToken();
        if (!$userId) {
            header("Location: /dashboard");
            return;
        }
        $userRole = $this->getUserRole($userId);

        $films = [];
        try {
            $films = $this->filmRepository->getFilmsByWatchlist($userId);
        }
        catch (\Exception $e) {

        }

        $this->render('results', ['films' => $films, 'userRole' => $userRole ?? null]);
    }


    private function validate(array $image): bool
    {
        if (empty($image['name'])) {
            $this->messages[] = 'No file selected';
            return false;
        }

        if ($image['size'] > self::MAX_FILE_SIZE) {
            $this->messages[] = 'File is too large for destination file system';
            return false;
        }


        if (!isset($image['type']) || !in_array($image['type'], self::SUPPORTED_TYPES)) {
            $this->messages[] = 'File type is not supported';
            return false;
        }

        return true;
    }

    public function details()
    {
        $userId = $this->validateSessionToken();
        if($userId) {
            $userRole = $this->getUserRole($userId);
        }

        if (!isset($_GET['id'])) {
            die('Brak ID filmu!');
        }

        $filmId = $_GET['id'];
        $filmRepository = new FilmRepository();
        $film = $filmRepository->getFilmDetailsById($filmId);

        $this->render('details', ['film' => $film, 'userRole' => $userRole ?? null]);
    }

    public function addToWatchlist(int $filmId)
    {
        $userId = $this->validateSessionToken();

        if (!$userId) {
            http_response_code(403);
            echo json_encode(["error" => "Not logged in"]);

        }



        try {
            $this->filmRepository->addFilmToWatchList($filmId, $userId);
            http_response_code(200);
            echo json_encode(["success" => "Film added to watchlist"]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(["error" => "An error occurred: " . $e->getMessage()]);
        }
    }

    public function isGenreInDataBase(string $genres) {

        $userId = $this->validateSessionToken();
        $userRole = null;
        if ($userId) {
            $userRole = $this->getUserRole($userId);
        }

        if($userRole !== 'admin') {
            header("Location: /dashboard");
            return;
        }


        $missingGenres = [];
        $genresArray = array_filter(array_map('trim', explode(',', $genres)));

        foreach ($genresArray as $genre) {
            if (!$this->filmRepository->isGenreExist($genre)) {
                $missingGenres[] = $genre;
            }
        }

        if (empty($missingGenres)) {
            http_response_code(200);
            echo json_encode(['success' => 'Wszystkie gatunki istnieją.']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Brakujące gatunki: ' . implode(', ', $missingGenres)]);
        }
    }

    public function getAllGenres(){
        $userId = $this->validateSessionToken();
        $userRole = null;
        if ($userId) {
            $userRole = $this->getUserRole($userId);
        }

        if($userRole !== 'admin') {
            header("Location: /dashboard");
            return;
        }

        $genres = $this->filmRepository->getAllGenres();
        header('Content-Type: application/json');

        http_response_code(200);

        echo json_encode($genres);
    }

    public function isPeopleInDataBase(string $peopleString) {
        $userId = $this->validateSessionToken();
        $userRole = null;
        if ($userId) {
            $userRole = $this->getUserRole($userId);
        }

        if($userRole !== 'admin') {
            header("Location: /dashboard");
            return;
        }
        $peopleString = urldecode($peopleString);

        $peopleArray = preg_split('/[\/,]+/', $peopleString);
        $peopleArray = array_filter(array_map('trim', $peopleArray));

        $missingPeople = [];

        foreach ($peopleArray as $fullName) {
            $fullName = preg_replace('/\s*\(.*?\)/', '', $fullName);

            $parts = preg_split('/\s+/', $fullName);

            if (count($parts) >= 2) {
                $firstName = $parts[0];
                $lastName = implode(' ', array_slice($parts, 1));
            } else {
                $firstName = $fullName;
                $lastName = "";
            }

            if (!$this->filmRepository->isPeopleInDataBase($firstName, $lastName)) {
                $missingPeople[] = $fullName;
            }
        }

        if (empty($missingPeople)) {
            http_response_code(200);
            echo json_encode(["success" => "AllPeople are in database."]);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "People not found: " . implode(", ", $missingPeople)]);
        }
    }

    public function addFilmToCategory(Film $film, Genre $genre)
    {
      $this->filmRepository->addFilmToCategory($film, $genre);
    }

    function parseActorAndCharacter($str) {
        $posOpen = strpos($str, '(');
        $actorPart = trim(substr($str, 0, $posOpen));

        $posClose = strpos($str, ')', $posOpen);
        $characterPart = trim(substr($str, $posOpen + 1, $posClose - $posOpen - 1));

        $actorParts = explode(' ', $actorPart, 2);
        $actorFirstName = $actorParts[0];
        $actorLastName = isset($actorParts[1]) ? $actorParts[1] : '';

        $characterParts = explode(' ', $characterPart, 2);
        $characterFirstName = $characterParts[0];
        $characterLastName = isset($characterParts[1]) ? $characterParts[1] : '';

        return [
            'nameActor'               => $actorFirstName,
            'surnameActor'           => $actorLastName,
            'nameInFilm'      => $characterFirstName,
            'surnameInFilm'  => $characterLastName
        ];
    }


}