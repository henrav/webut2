<?php
require_once __DIR__ . '/../dbGrejer/db.php';
require_once __DIR__ . '/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userName = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $user = check_inlogg($userName, $password);
    if (! $user) {
        header('Location: ../loggain.php?error=Felaktigt+användarnamn+eller+lösenord');
        exit;
    }

    $id = (int)$user['id'];
    createSession($user['username'], $id, 3600);

    $target = (isset($_GET['nav']) && $_GET['nav']==='edit')
        ? '../edit.php'
        : '../index.php';
    header("Location: {$target}");
    exit;
}
