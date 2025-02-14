<?php
require_once __DIR__ . '/../repository/SessionRepository.php';

class AppController {

    private string $request;

    public function __construct(){
        $this->request = $_SERVER['REQUEST_METHOD'];
    }

    protected function isGet() : bool{
        return $this->request == 'GET';
    }

    protected function isPost() : bool{
        return $this->request == 'POST';
    }

    protected function render(string $template = null, array $variables = []){
        $templatePath = 'public/views/' . $template . '.php';

        $output = 'File(View) not found';

        if(file_exists($templatePath)){
            extract($variables);

            ob_start();
            include $templatePath;

            $output = ob_get_clean();
        }

        print $output;
    }

    public function validateSessionToken() {
        if (!isset($_COOKIE['session_id'])) {
            return false;
        }

        $token = $_COOKIE['session_id'];
        $sessionRepository = new SessionRepository();
        $sessionData = $sessionRepository->getSession($token);

        if (!$sessionData || $sessionData->getExpiryTime() < time()) {
            return false;
        }

        $this->refreshSession($token, $sessionRepository);

        return $sessionData->getUserId();
    }


    protected function refreshSession(string $token, SessionRepository $sessionRepository) {
        $newExpiry = time() + 1800;
        $sessionRepository = new SessionRepository();
        $sessionRepository->updateSessionExpiry($token, $newExpiry);
        setcookie('session_id', $token, $newExpiry, '/');
    }


    public function getUserRole(int $userId) {
        $userRepository = new UserRepository();
        $user = $userRepository->getUserById($userId);
        return $user->getRole();
    }
}
