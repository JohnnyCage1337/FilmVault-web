<?php

class Session {
    private $userId;
    private $expiryTime;

    public function __construct($userId, $expiryTime) {
        $this->userId = $userId;
        $this->expiryTime = $expiryTime;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getExpiryTime() {
        return $this->expiryTime;
    }
}