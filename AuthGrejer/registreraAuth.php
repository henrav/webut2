<?php
require_once __DIR__ . '/../dbGrejer/db.php';
require_once __DIR__ . '/auth.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userName = $_POST['username'];
    $password = $_POST['password'];

    $user = get_user($userName);

    if (!$user){
        add_user($userName, $password);
        $userInfo = get_user($userName);
        createSession($userInfo['username'], $userInfo['id'] ,3600);
        header('Location: ../index.php');
    }else{
        header('Location: ../registrera.php?error=Användarnamnet+finns+redan');
        exit;
    }

}