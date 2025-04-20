<?php
require_once __DIR__ . '/AuthGrejer/auth.php';
require_once 'post.php';
require_once __DIR__ . '/dbGrejer/db.php';


$urlID = $_GET['ID'] ?? "";
$isOwner = false;
if (isset($_SESSION['userID']) && $urlID !== false) {
    $isOwner = ($_SESSION['userID'] === (int) $urlID);

}
$userInfo = get_user_by_id($urlID);
$userPosts = get_posts_userid($urlID);
if (empty($userInfo)) {
    echo '<div> 
            <h1> användaren hittades inte</h1>
          </div>';
    return;
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
    <link rel="stylesheet" href="css/profile.css">
    <link rel="stylesheet" href="css/screenCover.css"
</head>
<body>
<?php require_once __DIR__ . '/header.php'; ?>
<div class="main-body">
    <?php require_once __DIR__ . '/rightandLeft/left/left-container.php'; ?>
    <div class="main-body-center" style="margin-left: 20px" >
        <div class="right-content-container">
            <div class="picture-part">
                <div class="picture-box">
                    <img class="picture-box-picture" id="picture-box-picture" src="images/scout_eating.jpg" alt="">
                </div>
                <?=  $isOwner ? '<button class="picture-box-picture-button" id="picture-box-picture-button">ändra bild</button>' : '' ?>
            </div>
            <div class="view-profile-container" style="">
                <div style="margin-right: auto; margin-left: auto; border-radius: 6px ">
                        <div class="view-profile-h2-container">
                            <h2>
                               <?php if($isOwner) : ?>
                               Min profil
                                <?php else:?>
                                   <?php echo $userInfo['username']; ?>'s Profil
                               <?php endif;?>
                            </h2>
                        </div>

                    </div>
                    <div class="profile-rest-of-content" style="">
                        <div class="title-container">
                            <div class="user-title-box">
                                <?php if (isset($userInfo['title'])){
                                    echo '<h3>'.$userInfo['title'].'</h3>';
                                }else{
                                    echo 'Ingen titel finns';
                                } ?>
                            </div>
                        </div>
                        <div class="presentation-container">
                            <div style="font-size: 17px; font-weight: bold; margin-bottom: 10px; ">
                                om mig
                            </div>
                            <div class="presentation-container-text">
                                <?php if (isset($userInfo['presentation'])){
                                    echo $userInfo['presentation'];
                                }else{
                                    echo 'Ingen presentation har skrivits';
                                } ?>

                            </div>
                        </div>
                        <div class="joined-container">
                            <div>
                                Joina oss heavies:
                            </div>
                            <div style="font-size: 17px; font-weight: bold;margin-left: 10px; ">
                                <?= $userInfo['created'] ?>
                            </div>
                            <?= $isOwner ? '<div>
                                            <button class="redigera" id="edit-profile" onclick="getEditProfile(' . $userInfo['id'] . ')">Redigera din profil</button>
                                            <button class="redigera" id="new-post" onclick="addPost(' . $userInfo['id'] . ')">Nytt inlägg</button>
                                            </div>' : '' ?>
                        </div>
                    </div>

            </div>
            <div class="user-posts">
                <h1 style="color: blue; font-style: italic; text-decoration: underline">
                    <?php if ($isOwner) : ?>
                        Mina inlägg
                    <?php else : ?>
                        <?= $userInfo['username'] ?>'s inlägg
                    <?php endif; ?>
                </h1>
                <?php
                if (empty($userPosts)) : ?>
                    <?php if ($isOwner) : ?>
                    <h2 style="color: black">Du har inte postat något än</h2>
                    <?php else: ?>
                    <h2 style="color: black">Användaren har inte postat något än</h2>
                    <?php endif; ?>
                <?php else : ?>
                    <?php foreach ($userPosts as $post) : ?>
                        <?php
                        if ($isOwner){
                            $nyPost = new indexPost($post, true);
                             echo $nyPost->renderPost();
                        }else{
                            $nyPost = new indexPost($post, false);
                             echo $nyPost->renderPost();
                        }

                        ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>
<div id="gömdaDiven"></div>
</body>
</html>
<script src="javascript/minfinajsgrej.js"></script>
