<?php
require_once '../dbGrejer/db.php';
require_once 'auth.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userName = $_POST['username']; // hämta credentials
    $password = $_POST['password'];


    $hits = check_inlogg($userName, $password); // kolla inlogg

    if ($hits == 1){ // bara om hittar en sådan
        createSession($userName, 3600);
        if (isset($_GET['nav'])){
            if ($_GET['nav'] == 'edit'){
                header('Location: /edit.php');
            }else{
                header('Location: /index.php');
            }
        }else{
            header('Location: /index.php');
        }
    }else{
        header('Location: /loggain.php?error=Felaktigt+användarnamn+eller+lösenord');
        exit;
    }

}

