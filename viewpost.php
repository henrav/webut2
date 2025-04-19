<?php
require_once __DIR__ . '/AuthGrejer/auth.php';
require_once 'post.php';
require_once __DIR__ . '/dbGrejer/db.php';

$postID = $_GET['ID'] ?? "";
if ($postID == ""){
    header('Location: /index.php');
}

try{
    $getpost = get_post($postID);

    $post = new viewPost($getpost);

}catch (Exception $e){
    header('Location: /index.php');
}

?>
<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <title>Hem</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/post.css">
    <link rel="stylesheet" href="css/right-main-content.css">
    <link rel="stylesheet" href="css/left-main-content.css">
    <link rel="stylesheet" href="css/viewpost.css">
</head>
<body>
<?php require_once __DIR__ . '/header.php'; ?>
<div class="container">
    <div class="view-post-container">
            <?= $post->renderPost() ?>
    </div>
</div>


</body>
</html>