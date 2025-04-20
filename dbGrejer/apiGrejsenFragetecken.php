<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id']) && isset($_GET['delete']) && $_GET['delete'] === 'true') {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    try{
        delete_post($id);
    }catch (Exception $e){
        http_response_code(400);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['text']) && isset($_GET['id']) && $_GET['text'] === 'true') {
    try{
        $data=  get_post_content($_GET['id']);
        echo json_encode([
            "title"   => $data['title'],
            "content" => $data['content'],
        ]);
    }catch (Exception $e){
        json_encode($e->getMessage());
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['savepost']) && isset($_GET['edit']) && $_GET['savepost'] === 'true') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (!is_array($data)
        || !isset($data['id'], $data['text'], $data['title'])
    ) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid payload']);
        exit;
    }
    $edit = $_GET['edit'];


    $id =(int) $data['id'];
    $text    = trim((string)$data['text']);
    $title   = trim((string)$data['title']);
    $userId  = isset($data['userid']) ? (int)$data['userid'] : null;
    try {
        if ($edit) {
            update_post($id, $title, $text);
        } else {
            create_post($title, $text, (int)$userId);
        }

        http_response_code(200);
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id']) &&  isset($_GET['userInfo']) && $_GET['userInfo']  === 'true') {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    try{

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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['updateUser']) && $_GET['updateUser'] === 'true'){
    $data = json_decode(file_get_contents('php://input'), true);
    $id = (int) $data['id'];
    $title = trim((string)$data['title']);
    $presentation = trim((string)$data['presentation']);
    $username = $data['username'];

    try{
        update_user($username, $title, $presentation, $id);
        echo json_encode(['success' => true]);
    }catch (Exception $e){
        http_response_code(400);
    }
}



?>