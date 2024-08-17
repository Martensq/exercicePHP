<?php

    include("../pdo.php");

    if ($_POST) {
        $updateProduct = $pdo->prepare("UPDATE product SET LABEL = :label, PRICE = :price, ID_CATEGORY = :id_category WHERE ID_PRODUCT = :id");
        $updateProduct->execute([
            'label' => $_POST['nom'],
            'price' => $_POST['prix'],
            'id_category' => $_POST['categorie'],
            'id' => $_POST['id']
        ]);
    }

    header('Location: ../index.php');