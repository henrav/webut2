<?php
require_once __DIR__ . '/../dbGrejer/db.php';
require_once __DIR__ . '/auth.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // hämta grejer
    $userName = $_POST['username'];
    $password = $_POST['password'];

    // kolla om finns någon med namnet
    $user = get_user($userName);

    if (!$user){
        // lägg till user och hämta id
        $id =  add_user($userName, $password);
        // skapa session
        createSession($userName, $id ,3600);
        header('Location: ../index.php');
    }else{
        header('Location: ../registrera.php?error=Användarnamnet+finns+redan');
        exit;
    }

}