
<div class="main-header">
    <div class="main-header-grid">
        <div class="grid-content">
            <button class="header-button" onclick="window.location.href='index.php';">Hem</button>
        </div>
        <div class="grid-content">
            <?php if (isset($_SESSION["loggedIn"])): ?>
                <div >Välkommen <?= $_SESSION['username']?> till Henkes TF2 blogg</div>
            <?php else:?>
                <div>Välkommen till Henkes TF2 blogg, nya blogginlägg varje dag🤯</div>
            <?php endif;?>
        </div>
        <div class="grid-content">
            <?php if (isset($_SESSION["loggedIn"])): ?>
            <button class="header-button" onclick="window.location.href='AuthGrejer/logautAuth.php';"> Logga ut</button>
            <button class="header-button" style="margin-left: 10px" onclick="window.location.href='profile.php?ID=<?= $_SESSION['userID'] ?>';"> Min profil</button>            <?php else:?>
            <div style="display: flex; gap: 1vw; ">
                <button class="header-button" onclick="window.location.href='loggain.php';"> Logga in</button>
                <button class="header-button" onclick="window.location.href='registrera.php';"> Registrera</button>
            </div>

            <?php endif;?>
        </div>
    </div>
</div>