<?php

    session_start();

    $pdo = new PDO(
        'mysql:host=localhost;dbname=corning;charset=utf8',
        'root',
        ''
    );

?>