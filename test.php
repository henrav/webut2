<?php
require_once 'db.php';
$username = "asdasdasd";
$user = get_user($username);

if (isset($user)){
    echo "test";
}