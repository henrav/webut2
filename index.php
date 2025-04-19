<?php
require_once __DIR__ . '/AuthGrejer/auth.php';
require_once 'post.php';
require_once __DIR__ . '/dbGrejer/db.php';
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
</head>
<body>
<?php require_once __DIR__ . '/header.php'; ?>
<div class="main-body">
    <?php require_once __DIR__ . '/rightandLeft/left/left-container.php'; ?>
    <div class="main-body-center">
        <div class="center-main-content">
            <div class="h2-container">
                <h2>Senaste blogginläggen</h2>
            </div>
            <?php
            $posts = get_posts();
            ?>
            <?php foreach ($posts as $post) :
                $nyPost = new indexPost($post);
                echo $nyPost->renderPost();
                ?>
            <?php endforeach;?>
        </div>

    </div>


</div>



</body>
</html>