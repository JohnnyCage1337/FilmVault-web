<?php
require_once 'AppController.php';
require_once __DIR__ . '/../repository/PersonRepository.php';
require_once __DIR__ . '/../models/Film.php';
require_once __DIR__ . '/../models/Genre.php';
require_once __DIR__ . '/../models/Person.php';


class PersonController extends AppController
{
    const MAX_FILE_SIZE = 1024 * 1024;
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg', 'image/jpg'];
    const UPLOAD_DIRECTORY = __DIR__ . '/../../public/uploads/';

    private $messages = [];
    private $personRepository;


    public function __construct()
    {
        parent::__construct();
        $this->personRepository = new PersonRepository();
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

    public function addPerson(){
        $userId = $this->validateSessionToken();
        $userRole = null;
        if ($userId) {
            $userRole = $this->getUserRole($userId);
        }

        if($userRole !== 'admin') {
            header("Location: /dashboard");
            return;
        }


        if (
            $this->isPost() &&
            is_uploaded_file($_FILES['image']['tmp_name']) &&
            $this->validate($_FILES['image'])
        ) {

            $birthDate = new DateTime($_POST['birth_date']);
            $person = new Person($_POST['first_name'], $_POST['last_name'], $birthDate,$_POST['description'] ,$_FILES['image']['name']);
            if($this->personRepository->personExists($person)){
                return $this->render('formPerson', ['messages' => ['Person already exists']]);

            }
            try {
                $this->personRepository->addPerson($person);
                move_uploaded_file(
                    $_FILES['image']['tmp_name'],
                    self::UPLOAD_DIRECTORY . $_FILES['image']['name']
                );
            }
            catch (\Exception $e){
                $this->messages[] = 'Person already exists';
                return $this->render('formPerson', ['messages' => ['Error']]);


            }


        }
        $this->messages[] = 'Person added';
        return $this->render('formPerson', ['messages' => ['Person added']]);
    }


    public function addFilm(){
        $userId = $this->validateSessionToken();
        if (!$userId) {
            http_response_code(403);
            echo json_encode(["error" => "Nie jesteś zalogowany."]);
            return;
        }

        $userRole = $this->getUserRole($userId);
        if ($userRole !== 'admin') {
            http_response_code(403);
            echo json_encode(["error" => "Brak uprawnień do wykonania tej operacji."]);
            return;
        }

        if (
            $this->isPost() &&
            is_uploaded_file($_FILES['image']['tmp_name']) &&
            $this->validate($_FILES['image'])
        ) {
            move_uploaded_file(
                $_FILES['image']['tmp_name'],
                self::UPLOAD_DIRECTORY . $_FILES['image']['name']
            );

            $film = new Film($_POST['title'], $_POST['year'], $_POST['duration'], $_FILES['image']['name']);
            $this->filmRepository->addFilm($film);

            return $this->render('dashboard', ['messages' => $this->messages, 'film' => $film]);
        }

        $this->render('formPerson', ['messages' => $this->messages]);
    }




}