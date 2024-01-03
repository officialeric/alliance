<?php

    session_start();
    include 'database/connection.php';
    include 'classes/User.php';
    include 'classes/Drop.php';
    include 'classes/Follow.php';
    include 'classes/Message.php';
    include 'classes/Group.php';
    global $pdo;

    $getFromU = new User($pdo);
    $getFromT = new Drop($pdo);
    $getFromF = new Follow($pdo);
    $getFromM = new Message($pdo);
    $getFromM = new Group($pdo);

    define('BASE_URL', 'http://localhost/alliance/');


