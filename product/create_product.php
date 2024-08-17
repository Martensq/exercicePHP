<?php

    include("../pdo.php");

    if ($_POST) {
        $newProduct = $pdo->prepare("INSERT INTO product(LABEL, PRICE, ID_CATEGORY) VALUES(:label, :price, :id_category)");
        $newProduct->execute([
            'label' => $_POST['nom'],
            'price' => $_POST['prix'],
            'id_category' => $_POST['categorie']
        ]);
    }

    
    header('Location: ../index.php');

?>