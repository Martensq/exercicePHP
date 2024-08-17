<?php

    include("../pdo.php");

    if ($_POST) {
        $newCategory = $pdo->prepare("INSERT INTO category(LABEL) VALUES(:label)");
        $newCategory->execute([
            'label' => $_POST['nom']
        ]);
    }

    
    header('Location: ../index.php');

?>