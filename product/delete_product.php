<?php

    include("../pdo.php");

    if ($_POST) {
        $deleteProduct = $pdo->prepare("DELETE FROM product WHERE ID_PRODUCT = :id");
        $deleteProduct->execute([
            'id' => $_POST['id']
        ]);
    }

    
    header('Location: ../index.php');

?>