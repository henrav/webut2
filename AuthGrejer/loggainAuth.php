<?php
require_once __DIR__ . '/../dbGrejer/db.php';
require_once __DIR__ . '/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // hämta saker
    $userName = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // kolla om det finns och hämta data
    $user = check_inlogg($userName, $password);
    if (! $user) {
        header('Location: ../loggain.php?error=Felaktigt+användarnamn+eller+lösenord');
        exit;
    }

    $id = (int)$user['id'];
    // skapa session
    createSession($user['username'], $id, 3600);

    // hmmm gammal anvädns inte
    $target = (isset($_GET['nav']) && $_GET['nav']==='edit')
        ? '../edit.php'
        : '../index.php';
    header("Location: {$target}");
    exit;
}
