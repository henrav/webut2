<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/../AuthGrejer/auth.php';

function getUserPosts($id){
    try{
        return get_posts_userid($id);
    }catch (Exception $e){
        http_response_code(500);
    }
}


// delete inlägg
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id']) && isset($_GET['delete']) && $_GET['delete'] === 'true') {
    // hämta data
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $userID = $_SESSION['userID'];
    $validateUserPosts = getUserPosts($userID);
    $boolFound = false;
    // validera att det är dina posts
    foreach ($validateUserPosts as $validateUserPost) {
        if ($validateUserPost['id'] === $id) {
            $boolFound = true;
            break;
        }
    }
    // om inte din post, borde aldrig ske men men
    if (!$boolFound){
        return http_response_code(500);
    }

    // tabort bilden kopplad till posten
    //hämta nuvarande path(filnamn)
    $imageFilePath = get_image_path($id)['filename'];
    $uploadsDir =  dirname(__DIR__, 1) . '/uploads/';
    // om finns, ta bort
    if (file_exists($uploadsDir . $imageFilePath)) {
        unlink($uploadsDir . $imageFilePath);
    }

    try{
        // deleta image först för de e kaos med nycklar och enklast
        if (delete_image($id)){
            delete_post($id);
        }
        else{
            http_response_code(200);
        }
    }catch (Exception $e){
        http_response_code(400);
    }
}

// hämta data för redigering av inlägg
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['text']) && isset($_GET['id']) && $_GET['text'] === 'true') {
    try{
        // aaa vi hämtar data
        $data = get_post_content($_GET['id']);
        echo json_encode([
            "title"   => $data['title'],
            "content" => $data['content'],
            "description" => $data['description'],
        ]);
    }catch (Exception $e){
        json_encode($e->getMessage());
    }
}


// funktion för hantering av inläggbilder
// om edit != 0 så ska tar vi bort den gamla filen på servern
function handleFileUpload($fileName, $edit = 0): bool
{
    // paths
    $uploadDir = dirname(__DIR__, 1) . '/uploads/';
    $newPath      = $uploadDir . $fileName;

    // om edit != 0 , alltså det finns en gammal bild som du ska ta bort från fil grejen
    // edit == postId
    if ($edit != 0) {
        // get_image_path == select filename from image where postId = id
        $oldPath = $uploadDir. get_image_path($edit)['filename'];
        if (file_exists($oldPath)) {
            unlink($oldPath);
        }
    }

    // lägg in nya filen
    $content = file_get_contents($_FILES['filename']['tmp_name']);
    if (file_put_contents($newPath, $content) === false) {
        return false;
    }else{
        return true;
    }

}


// spara inlägg,
// beroende på om edit == true så uppdaterar den i databasen eller så lägger den in en ny post
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['savepost']) && isset($_GET['edit']) && $_GET['savepost'] === 'true') {
    // hämta data
    $id    = $_POST['id']    ?? null;
    $text  = $_POST['text']  ?? null;
    $title = $_POST['title'] ?? null;
    $edit = $_GET['edit'];
    $description = $_POST['description'] ?? null;
    try {
        $userID = $_SESSION['userID'];
        // om edit == true(alltså du redigerar en post)
        if ($edit == 'true') {
            // validera att det är dina posts
            $validateUserPosts = getUserPosts($userID);
            $boolFound = false;
            // kolla att det är users posts
            foreach ($validateUserPosts as $validateUserPost) {
                if ($validateUserPost['id'] == $id) {
                    $boolFound = true;
                    break;
                }
            }
            // venne varför jag gör detta tänkte det var bra att få in det i ryggmärgen eller något
            if (!$boolFound){
                return http_response_code(500);
            }


            // orka inte med procedures därför det är så många calls till DB

            // om user ladda upp fill
            if (isset($_FILES['filename']) && $_FILES['filename']['size'] > 0 && in_array($_FILES['filename']['type'], ['image/jpeg','image/png','image/webp'], true)) {
                // skapa nytt namn
                $newFileName = "{$id}_{$userID}_" . basename($_FILES['filename']['name']);
                // kolla om uppladningen till serverna fungera?
                if (handleFileUpload($newFileName, $id)) {
                   //om den fungera, uppdatera img path i db
                    update_img_path($id, $newFileName);
                }
            }
            // uppdatera description på image
            update_picture_description_postID($id, $description);
            // updatera posten
            update_post($id, $title, $text);
        } else {
            // om edit = false (alltså du gör en ny post)
            // skapa post och hämta dess id
            $newPostId = create_post($title, $text, (int)$userID);

            // om ladda upp fil
            if (isset($_FILES['filename']) && $_FILES['filename']['size'] > 0 && in_array($_FILES['filename']['type'], ['image/jpeg','image/png','image/webp'], true)) {
                // skapa ny unik namn för filen till posten
                $newFileName = "{$newPostId}_{$userID}_" . basename($_FILES['filename']['name']);

                //bool?
                // försök lägga in den i uploads folder
                $minbool = handleFileUpload($newFileName);
            } else {
                $newFileName = '';
            }
            // lägg in i db
            create_image_post($newFileName, $description ?? 'scout eating', $newPostId);
        }

        http_response_code(200);
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
    exit;
}

// hämta data för redigering av profil
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id']) &&  isset($_GET['userInfo']) && $_GET['userInfo']  === 'true') {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    try{
        // aa hämta data
        $data = get_user_by_id($id);
        echo json_encode([
            "username" => $data['username'],
            "title"   => $data['title'],
            "presentation" => $data['presentation'],
        ]);


    }catch (Exception $e){
        http_response_code(400);
    }
}


// uppdatera user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['updateUser']) && $_GET['updateUser'] === 'true'){
    // hämta data
    $data = json_decode(file_get_contents('php://input'), true);
    $id = (int) $data['id'];
    $title = trim((string)$data['title']);
    $presentation = trim((string)$data['presentation']);
    $username = $data['username'];
    // validera att det är din profil
    if ($id !== $_SESSION['userID']) {
        http_response_code(403);
    }
    // testa uppdatera
    try{
        update_user($username, $title, $presentation, $id);
        echo json_encode(['success' => true]);
    }catch (Exception $e){
        http_response_code(400);
    }
}



?>