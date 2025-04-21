<?php
require_once __DIR__ . '/AuthGrejer/auth.php';
require_once __DIR__ . '/dbGrejer/db.php';



if ($_SERVER['REQUEST_METHOD'] !== 'POST' || ! isset($_FILES['filename'])) {
    http_response_code(400);
    exit('Bad request');
}

// hämta sakerna
$userID    = $_SESSION['userID'];
$filename  = basename($_FILES['filename']['name']);
$type      = $_FILES['filename']['type'];

// kolla format
if ($type !== 'image/jpeg' && $type !== 'image/png' && $type !== 'image/webp') {
    http_response_code(400);
    exit('Invalid file type');
}

// försökt med denna dumma uploads halva dagen nu på servern me vägrar fungera, tror jag blir galen
// directory på servern
$uploadDir    = __DIR__ . '/uploads'   ;

// skapa en ny filnamn så dem e relativt unika iallafall
$newFilename  = $userID . $filename;
$newPath      = $uploadDir . '/' . $newFilename;


// basicly ta bort din gamla bild från directory
// hämta senaste path från db
// om pathen finns i directory, ta bort den
$userinfo = get_user_by_id($userID);
if (!empty($userinfo['image'])) {
    $lastpath = $uploadDir.'/'.$userinfo['image'];
    if (is_file($lastpath)) {
        unlink($lastpath);
    }
}

// försökt med så många file_get_contents/ file move blabal men funkar inte på servern
$content = file_get_contents($_FILES['filename']['tmp_name']);
$dest = $uploadDir . '/' . $newFilename;
if (file_put_contents($dest, $content) === false) {
    $err = error_get_last();
    die("Failed to write upload to $dest: "
        . ($err['message'] ?? 'unknown error'));
}

// funktionen för att ändra bild
change_avatar('uploads/'.$newFilename, $userID);

header('Location: profile.php?ID=' . $userID . '&upload=success');
exit;
