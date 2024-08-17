<?php

    include("../pdo.php");

    if ($_POST) {
        $deleteCategory = $pdo->prepare("DELETE FROM category WHERE ID_CATEGORY = :id");
        $deleteCategory->execute([
            'id' => $_POST['id']
        ]);
    }

    
    header('Location: ../index.php');

?>