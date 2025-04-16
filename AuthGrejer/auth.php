<?php
session_start();
if (!isset($_SESSION['username'])) { // sätt site senare
    header('Location: /index.php?error=Behöver+logga+in+först');
}

if (isset($_SESSION["expire_time"]) && (time() - $_SESSION["last_activity"] > $_SESSION["expire_time"]))  {
    header('Location: /loggautAuth.php');
}


function createSession($username, $timeout)
{
    $_SESSION['username'] = $username;
    $_SESSION['loggedIn'] = true;
    $_SESSION['last_activity'] = time();
    $_SESSION['expire_time'] = $timeout;

    setcookie("username", $username, time() + $timeout, "/");
    setcookie("loggedIn", "true", time() + $timeout, "/");
}
