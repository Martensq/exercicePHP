<?php

    include("../pdo.php");

    if ($_POST) {
        
        $updateCategory = $pdo->prepare("UPDATE CATEGORY SET LABEL = :label WHERE ID_CATEGORY = :id");
        $updateCategory->execute([
            'label' => $_POST['nom'],
            'id' => $_POST['id']
        ]);
    }

    header('Location: ../index.php');