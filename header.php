
<div class="main-header">
    <div class="main-header-grid">
        <div class="grid-content">
            <button class="nav-home" onclick="window.location.href='/index.php';">Hem</button>
        </div>
        <div class="grid-content">
            <?php if (isset($_SESSION["loggedIn"])): ?>
                <div >Välkommen <?= $_SESSION['username']?> till Henkes blogg</div>
            <?php else:?>
                <div>Välkommen till Henkes blogg</div>
            <?php endif;?>
        </div>
        <div class="grid-content">
            <?php if (isset($_SESSION["loggedIn"])): ?>
            <button class="logout-login-button" onclick="window.location.href='/AuthGrejer/logautAuth.php';"> logout</button>
            <?php else:?>
            <button class="logout-login-button" onclick="window.location.href='/loggain.php';"> logain</button>
            <?php endif;?>
        </div>
    </div>
</div>