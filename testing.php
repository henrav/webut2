<?php
require_once __DIR__ . '/dbGrejer/db.php';

$post=  get_post_content(2);
foreach ($post as $key => $value) {
    print_r($value);
}