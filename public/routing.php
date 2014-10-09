<?php

if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js|otf)$/', $_SERVER["REQUEST_URI"])) {
    return false;
} else {
    $_GET['uri'] = $_SERVER["REQUEST_URI"];
    include __DIR__ . '/../app.php';
}

?>