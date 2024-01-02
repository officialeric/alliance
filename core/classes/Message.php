<?php

class Message extends User
{
    function __construct($pdo) {
        $this->pdo = $pdo;
    }
}