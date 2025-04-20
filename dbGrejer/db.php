<?php
require_once('db_credentials.php');

// Koppla upp mot databasen, detta gör vi en gång när skriptet startar (sidan laddas in)
$connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

function add_user($username, $password)
{
    global $connection; // Så vi kommer åt den globala variabeln

    // Skapa SQL-frågan
    $sql = 'INSERT INTO user (username, password) VALUES (?,?)';
    // Förbered frågan
    $statment = mysqli_prepare($connection, $sql);

    // Bind ihop variablerna med statement användarnamn och läsenord är strängar (s)
    mysqli_stmt_bind_param($statment, "ss", $username, $password);

    // Utför frågan
    mysqli_stmt_execute($statment);

    // Stäng statementet när vi är klara
    mysqli_stmt_close($statment);
}

function update_user($username, $title, $presentation, $id){
    global $connection;
    $sql = 'UPDATE user SET title = ?, presentation = ?, username = ? where id = ?';
    $statment = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($statment, "sssi", $title, $presentation, $username, $id);
    mysqli_stmt_execute($statment);
    mysqli_stmt_close($statment);

}



function get_newest_posts($limit)
{
    global $connection;
    $sql = 'SELECT post.id as postID, post.title, post.created, username, image  FROM post inner join user on post.userId = user.id    ORDER BY post.created DESC LIMIT ?';
    $statment = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($statment, "i", $limit);
    mysqli_stmt_execute($statment);
    $result = mysqli_stmt_get_result($statment);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);

}
function get_newest_users($limit)
{
    global $connection;
    $sql = 'SELECT id as userID, username, created, image from user ORDER BY created desc LIMIT ?';
    $statment = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($statment, "i", $limit);
    mysqli_stmt_execute($statment);
    $result = mysqli_stmt_get_result($statment);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function get_post($id){
    global $connection;
    $sql = 'SELECT
            p.id,
            p.title,
            p.content,
            p.created,
            p.userId,
            u.username,
            u.image
            FROM post AS p
                INNER JOIN user AS u
                    ON p.userId = u.id
            WHERE p.id = ?;';
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);

}

/**
 * Tar in ett statement som har körts, hämtar resultatet och lägger
 * resultatet i en array med rader där varje rad innehåller en array med fält
 */
function get_result($statment)
{
    $rows = array();
    $result = mysqli_stmt_get_result($statment);
    if($result) // Finns resultat
    {
        // Hämta rad för rad ur resultatet och lägg in i $row
        while ($row = mysqli_fetch_assoc($result))
        {
            $rows[] = $row;
        }
    }
    return $rows;
}

function get_users()
{
    global $connection;
    $sql = 'SELECT * FROM user';
    $statment = mysqli_prepare($connection, $sql);
    mysqli_stmt_execute($statment);
    $result = get_result($statment);
    mysqli_stmt_close($statment);
    return $result;
}

function get_posts()
{
    global $connection;
    $sql = 'SELECT post.id, post.title, content, post.created, userId, username, image FROM post inner join user on post.userId = user.id order by post.created DESC';
    $statment = mysqli_prepare($connection, $sql);
    mysqli_stmt_execute($statment);
    $result = get_result($statment);
    return $result;
}

function check_inlogg($userName, $password)
{
    global $connection;

    $sql = 'SELECT id, username  FROM user WHERE username = ? AND password = ?';
    $stmt = mysqli_prepare($connection, $sql);

    if (!$stmt) {
        die('Prepare failed: ' . mysqli_error($connection));
    }

    mysqli_stmt_bind_param($stmt, "ss", $userName, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    return mysqli_fetch_assoc($result);
}

function get_posts_userid($userId){
    global $connection;

    $sql = 'SELECT post.id, post.title, content, post.created, userId, username, image FROM post  left join user on post.userId = user.id where post.userId = ? order by post.created desc;';
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, "i",  $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);

}

function get_user($username)
{
    global $connection;
    $sql = 'SELECT id, username, title, presentation, image, created FROM user WHERE username=?';
    $statment = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($statment, "s", $username);
    mysqli_stmt_execute($statment);
    $result = get_result($statment);
    mysqli_stmt_close($statment);
    return $result;
}

function get_user_by_id($id)
{
    global $connection;
    $sql = 'SELECT id, username, title, presentation, image, created FROM user WHERE id=?';
    $statment = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($statment, "i", $id);
    mysqli_stmt_execute($statment);
    $result = mysqli_stmt_get_result($statment);
    return mysqli_fetch_assoc($result);

}

function create_post($title, $content, $userId)
{
    global $connection;
    $sql = 'INSERT INTO post(title,  content, userId) VALUES( ?, ?, ?)';
    $statment = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($statment, "ssi", $title, $content, $userId);
    mysqli_stmt_execute($statment);
}

function update_post($id, $title, $content){
    global $connection;
    $sql = 'UPDATE post SET title = ?, content = ? WHERE id = ?;';
    $statment = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($statment, "ssi", $title, $content, $id);
    mysqli_stmt_execute($statment);
}

function get_password($id)
{
    global $connection;
    $sql = 'SELECT password FROM user WHERE id=?';
    $statment = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($statment, "s", $id);
    mysqli_stmt_execute($statment);
    $result = get_result($statment);
    mysqli_stmt_close($statment);
    return $result;
}

function get_images($id)
{
    global $connection;
    $sql = 'SELECT image.filename, image.description FROM image JOIN post ON image.postId=post.id WHERE post.userId=?';
    $statment = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($statment, "i", $id);
    mysqli_stmt_execute($statment);
    $result = get_result($statment);
    mysqli_stmt_close($statment);
    return $result;
}
function get_post_content($id)
{
    global $connection;
    $sql = 'SELECT content, title FROM post WHERE id=?';
    $statment = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($statment, "i", $id);
    mysqli_stmt_execute($statment);
    $result = mysqli_stmt_get_result($statment);
    return mysqli_fetch_assoc($result);

}

function change_avatar($filename, $id)
{
    global $connection;
    $sql = 'UPDATE user SET image=? WHERE id=?';
    $statment = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($statment, "si", $filename, $id);
    $result = mysqli_stmt_execute($statment);
    mysqli_stmt_close($statment);
    return $result;
}

function delete_post($id)
{
    global $connection;
    $sql = 'DELETE FROM post WHERE id=?';
    $statment = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($statment, "i", $id);
    $result = mysqli_stmt_execute($statment);
    mysqli_stmt_close($statment);
    return $result;
}

/**
 * OBS! Kan ta bort alla tabeller ut databasen om så önskas
 *
 * Importerar databastabeller och innehåll i databasen från en .sql-fil
 * Använd MyPhpAdmin för att exportera din lokala databas till en .sql-fil
 *
 * @param $db
 * @param $filename
 * @param $dropOldTables - skicka in TRUE om alla tabeller som finns ska tas bort
 */
function import($filename, $dropOldTables=FALSE)
{
    global $connection;
    // Om $dropOldTables är TRUE så ska vi ta bort alla gamla tabeller
    if ($dropOldTables)
    {
        // Börjar med att hämta eventuella tabeller som finns i databasen
        $query = 'SHOW TABLES';
        $result = mysqli_query($connection, $query);
        // Om några tabeller hämtats
        if ($result)
        {
            // Hämta rad för rad ur resultatet
            while ($row = mysqli_fetch_row($result))
            {
                $query = 'DROP TABLE ' . $row[0];
                if (mysqli_query($connection, $query))
                    echo 'Tabellen <strong>' . $row[0] . '</strong> togs bort<br>';
            }
        }
    }
    $query = '';
    // Läs in filens innehåll
    $lines = file($filename);

    // Hantera en rad i taget
    foreach ($lines as $line) {
        // Gör inget med kommentarer eller tomma rader (gå till nästa rad)
        if (substr($line, 0, 2) == '--' || $line == '')
            continue;

        // Varje rad läggs till i frågan (query)
        $query .= $line;

        // Slutet på frågan är hittad om ett semikolon hittades i slutet av raden
        if (substr(trim($line), -1, 1) == ';') {
            // Kör frågan mot databasen
            if (!mysqli_query($connection, $query))
                echo "<br>Fel i frågan: <strong>$query</strong><br><br>";

            // Töm $query så vi kan starta med nästa fråga
            $query = '';
        }
    }
    echo 'Importeringen är klar!<br>';
}
