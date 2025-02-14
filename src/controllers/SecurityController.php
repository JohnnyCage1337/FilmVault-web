<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../repository/UserRepository.php';
require_once __DIR__.'/../repository/SessionRepository.php';

class SecurityController extends AppController
{
    public function login()
    {
        $userId = $this->validateSessionToken();
        if ($userId) {
            header("Location: /dashboard");
            return;
        }
        $userRepository = new UserRepository();

        if (!$this->isPost()) {
            return $this->render('login');
        }

        $email = $_POST["email"];
        $password = $_POST["password"];


        $user = $userRepository->getUserByEmail($email);
        if (!$user) {
            return $this->render('login', ['messages' => ['User not exist']]);
        }

        if ($user->getEmail() != $email) {
            return $this->render('login', ['messages' => ['User with this email does not exist']]);
        }

        if (!password_verify($password, $user->getPassword())) {
            return $this->render('login', ['messages' => ['Wrong password']]);
        }

        $new_session = $this->createUserToken($user->getId());
        setcookie('session_id', $new_session, time() + 3600);
        $url ="http://$_SERVER[HTTP_HOST]";
        header("Location: $url/dashboard");


        return $this->render('dashboard');

    }

    public function register()
    {
        $userId = $this->validateSessionToken();
        if ($userId) {
            header("Location: /dashboard");
            return;
        }

        $userRepository = new UserRepository();

        if (!$this->isPost()) {
            return $this->render('register');
        }

        $username = $_POST["username"];
        $email = $_POST["email"];
        $options = ['cost' => 12];
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT, $options);

        $user = $userRepository->getUserByEmail($email);
        if($user){
            return $this->render('login', ['messages' => ['User with this email already exist']]);
        }
        $user = new User($email, $password, $username);

        $userRepository->addUser($user);

        return $this->render('login', ['messages' => ['User created']]);
    }

    private function createUserToken($userId)
    {
        $token = bin2hex(random_bytes(32));
        $expiryTime = time() + 1800;

        $sessionRepository = new SessionRepository();
        $sessionRepository->saveSession($userId, $token, $expiryTime);

        return $token;
    }


    public function logout() {
        if (isset($_COOKIE['session_id'])) {
            $token = $_COOKIE['session_id'];
            $sessionRepository = new SessionRepository();
            $sessionRepository->deleteSession($token);
            setcookie('session_id', '', -1, '/');
        }
        header("Location: /dashboard");
        exit();
    }

}
