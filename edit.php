<?php





// äääääääh används inte längre
require_once __DIR__ . "/AuthGrejer/auth.php";
if (!isset($_GET['loggedIn'])) {
    header('Location: loggain.php?error=Måste+logga+in+först&nav=edit');
}
?>
<!DOCTYPE html>
<html>
<body>
<!--<a href="/AuthGrejer/logautAuth.php">
    <button type="button">Logga ut</button>
</a>

<a href="loggain.php">
    <button type="button">Logga in</button>
</a> -->


</body>
</html>
