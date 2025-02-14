<?php
require_once 'Repository.php';
require_once __DIR__.'/../models/Session.php';

class SessionRepository extends Repository
{
    public function saveSession($userId, $token, $expiryTime)
    {
        $stmt = $this->db->connect()->prepare("
            INSERT INTO sessions (session_id, user_id, expires_at)
            VALUES (:session_id, :user_id, :expires_at)
        ");
        $stmt->bindValue(":session_id", $token);
        $stmt->bindValue(":user_id", $userId, PDO::PARAM_INT);
        $stmt->bindValue(":expires_at", date('Y-m-d H:i:s', $expiryTime));
        return $stmt->execute();
    }

    public function getSession($token) {
        $stmt = $this->db->connect()->prepare("SELECT user_id, expires_at FROM sessions WHERE session_id = :token");
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return false;
        }
        $expiryTimestamp = strtotime($data['expires_at']);
        return new Session($data['user_id'], $expiryTimestamp);
    }

    public function deleteSession($token)
    {
        $stmt = $this->db->connect()->prepare("
            DELETE FROM sessions WHERE session_id = :session_id
        ");
        $stmt->bindValue(":session_id", $token);
        return $stmt->execute();
    }


    public function updateSessionExpiry($token, $newExpiry) {
        $stmt = $this->db->connect()->prepare("
            UPDATE sessions SET expires_at = :expires_at WHERE session_id = :session_id
        ");
        $stmt->bindValue(":expires_at", date('Y-m-d H:i:s', $newExpiry));
        $stmt->bindValue(":session_id", $token);
        return $stmt->execute();
    }
}
