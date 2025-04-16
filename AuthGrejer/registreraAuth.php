<?php
require_once '../dbGrejer/db.php';
require_once 'auth.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userName = $_POST['username'];
    $password = $_POST['password'];

    $user = get_user($userName);

    if (!$user){
        add_user($userName, $password);
        createSession($userName, 3600);
        header('Location: /index.php');
    }else{
        header('Location: /registrera.php?error=Användarnamnet+finns+redan');
        exit;
    }

}