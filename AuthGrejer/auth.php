<?php
session_start();

// om session är slut
if (isset($_SESSION["expire_time"]) && (time() - $_SESSION["last_activity"] > $_SESSION["expire_time"]))  {
    session_destroy();
    header('Location: loggain.php?error=Din+session+tog+slut');
}

// uppdatera session
$_SESSION['last_activity'] = time();
// funktion för att skapa session
function createSession($username, $id ,$timeout)
{
    $_SESSION['userID'] =  $id;
    $_SESSION['username'] = $username;
    $_SESSION['loggedIn'] = true;
    $_SESSION['last_activity'] = time();
    $_SESSION['expire_time'] = $timeout;

}
