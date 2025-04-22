<?php
require_once __DIR__ . '/AuthGrejer/auth.php';
require_once __DIR__ . '/post.php';
require_once __DIR__ . '/dbGrejer/db.php';

// om den inte hiddar urlen eller den inte har värde
$postID = $_GET['ID'] ?? "";
if ($postID == ""){
    header('Location: index.php');
}

try{
    // hämta post info
    $getpost = get_post($postID);

    // skapa post objekt
    $posten = new viewPost($getpost);

}catch (Exception $e){
    header('Location: index.php');
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
    <?php require_once __DIR__ . '/rightandLeft/left/left-container.php'; ?>
    <div class="thingy-orkar-inte-döpa-fler-containrar">
        <div class="view-post-container">
            <?=
            // printa objektet
            $posten->renderPost()
            ?>
        </div>
    </div>

</div>


</body>
</html>