<?php
?>
<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <title>Logga in</title>

    <link rel="stylesheet" href="/css/inlogg.css">
</head>
<body>
<div class="login-container">
    <h2>Logga in</h2>

    <!-- Felmeddelande, om det finns -->
    <?php if (!empty($_GET['error'])) : ?>
        <p class="error-message">
            <?php echo htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8'); ?>
        </p>
    <?php endif; ?>
    <?php if (!empty($_GET['message'])): ?>
        <p class="message-message">
            <?php echo htmlspecialchars($_GET['message'], ENT_QUOTES, 'UTF-8'); ?>
        </p>
    <?php endif; ?>
    <!-- Formulär -->
    <form method="post" action="/AuthGrejer/loggainAuth.php" class="login-form">
        <div class="form-group">
            <label for="username">Användarnamn:</label>
            <input
                type="text"
                name="username"
                id="username"
                required
                placeholder="Ditt användarnamn"
            >
        </div>
        <div class="form-group">
            <label for="password">Lösenord:</label>
            <input
                type="password"
                name="password"
                id="password"
                required
                placeholder="Ditt lösenord"
            >
        </div>
        <button type="submit">Logga in</button>

        <div style="display: inline-flex; align-items: center; justify-content: center;margin-top: 20px; margin-bottom: 10px;">
            <button type="button" class="navigera-bloggen" onclick="window.location.href='/index.php';">Till bloggen</button>
            <button type="button" class="navigera-button" onclick="window.location.href='/registrera.php';">Registrera</button>
        </div>
    </form>
</div>
</body>
</html>


