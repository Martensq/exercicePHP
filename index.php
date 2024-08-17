<?php

    include("pdo.php");


    // RECUPERATION PRODUITS
    $productsStatement = $pdo->query("SELECT product.ID_PRODUCT, product.LABEL, product.PRICE, product.ID_CATEGORY, category.LABEL AS category_label FROM product INNER JOIN category ON product.ID_CATEGORY = category.ID_CATEGORY");
    $products = $productsStatement->fetchAll();

    // RECUPERATION CATEGORIES
    $categoriesStatement = $pdo->query("SELECT * FROM category");
    $categories = $categoriesStatement->fetchAll();
    
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Exercice PHP</title>
</head>
<body>

    <!-- TABLEAU PRODUITS -->
    <div class="container p-5">
        <h2 class="text-center">PRODUITS</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nom du produit</th>
                    <th>Catégorie du produit</th>
                    <th>Prix</th>
                    <th class="text-end">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($products as $product): ?>
                <tr>
                    <td><?=$product['LABEL'];?></td>
                    <td><?=$product['category_label'];?></td>
                    <td><?=$product['PRICE'];?>€</td>
                    <td>
                        <div class="d-flex justify-content-end pt-2">

                            <!-- BOUTON MODIFICATION -->
                            <button
                                type="button"
                                class="btn btn-secondary"
                                data-bs-toggle="modal"
                                data-bs-target="#editProductModal"
                                data-id-product="<?= $product['ID_PRODUCT']; ?>"
                                data-label="<?= $product['LABEL']; ?>"
                                data-price="<?= $product['PRICE']; ?>"
                                data-category="<?= $product['ID_CATEGORY']; ?>"
                            >
                                <i class="fa-solid fa-pen-to-square fa-lg m-2"></i>
                            </button>
                            
                            <!-- MODALE MODIFICATION PRODUIT -->
                            <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="editProductModalLabel">Modifier produit</h1>
                                        </div>
                                        <form method="post" action="/product/update_product.php">
                                            <div class="modal-body">
                                                <input type="hidden" id="editProductId" name="id">
                                                <div class="mb-3">
                                                    <label for="editProductName" class="form-label">Nom</label>
                                                    <input type="text" class="form-control" id="editProductName" name="nom">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="editProductCategory">Catégorie</label>
                                                    <select class="form-select" id="editProductCategory" name="categorie">
                                                        <?php foreach ($categories as $category): ?>
                                                        <option value="<?= $category['ID_CATEGORY']; ?>"><?= $category['LABEL']; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="editProductPrice" class="form-label">Prix (€)</label>
                                                    <input type="number" class="form-control" id="editProductPrice" name="prix">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- BOUTON SUPPRESSION PRODUIT -->
                            <form action="/product/delete_product.php" method="post">
                                <input type="hidden" name="id" value="<?= $product['ID_PRODUCT']; ?>">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?');"><i class="fa-solid fa-trash m-2"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- BOUTON AJOUT PRODUIT -->
        <div class="text-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ajouterProduit">
                Ajouter produit
            </button>
        </div>

        <!-- MODALE AJOUT PRODUIT -->
        <div class="modal fade" id="ajouterProduit" tabindex="-1" aria-labelledby="ajouterProduitLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="ajouterProduitLabel">Ajouter produit</h1>
                    </div>
                    <form method="post" action="/product/create_product.php">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="nom" class="form-label">Nom</label>
                                <input type="text" class="form-control" id="nom" name="nom" required minlength="3" maxlength="255">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="categorie">Catégorie</label>
                                <select class="form-select" id="categorie" name="categorie" required>
                                    <option selected disabled >Choisissez une catégorie...</option>
                                    <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['ID_CATEGORY']; ?>"><?= $category['LABEL']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="prix" class="form-label">Prix (€)</label>
                                <input type="number" class="form-control" id="prix" name="prix" required min="1" step="1">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- TABLEAU CATEGORIES -->
    <div class="container p-5">
        <h2 class="text-center">CATEGORIES</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nom de la catégorie</th>
                    <th class="text-end">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($categories as $category): ?>
                <tr>
                    <td><?=$category['LABEL'];?></td>
                    <td>
                        <div class="d-flex justify-content-end p-2">

                            <!-- BOUTON MODIFICATION CATEGORIE -->
                            <button
                                type="button"
                                class="btn btn-secondary"
                                data-bs-toggle="modal"
                                data-bs-target="#editCategoryModal"
                                data-id-category="<?= $category['ID_CATEGORY']; ?>"
                                data-label-category="<?= $category['LABEL']; ?>"
                            >
                                <i class="fa-solid fa-pen-to-square fa-lg m-2"></i>
                            </button>
                            
                            <!-- MODALE MODIFICATION CATEGORIE -->
                            <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="modifierCategorieLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title-category fs-5" id="modifierCategorieLabel">Modifier catégorie</h1>
                                        </div>
                                        <form method="post" action="/category/update_category.php">
                                            <div class="modal-body">
                                                <input type="hidden" id="editCategoryId" name="id">
                                                <div class="mb-3">
                                                    <label for="editNom" class="form-label">Nom</label>
                                                    <input type="text" class="form-control" id="editCategoryName" name="nom">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- BOUTON SUPPRESSION CATEGORIE -->
                            <form action="/category/delete_category.php" method="post">
                                <input type="hidden" name="id" value="<?= $category['ID_CATEGORY']; ?>">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?');"><i class="fa-solid fa-trash m-2"></i></button>
                            </form>

                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <!-- BOUTON AJOUT CATEGORIE -->
        <div class="text-end">
            <button type="button" class="btn btn-dark m-2" data-bs-toggle="modal" data-bs-target="#ajouterCategorie">
                Ajouter catégorie
            </button>
        </div>

        <!-- MODALE AJOUT CATEGORIE -->
        <div class="modal fade" id="ajouterCategorie" tabindex="-1" aria-labelledby="ajouterCategorieLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="ajouterCategorieLabel">Ajouter catégorie</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="post" action="/category/create_category.php">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="nom" class="form-label">Nom</label>
                                <input type="text" class="form-control" id="nom" name="nom">
                            </div>
                        </div>

                        <!-- BOUTON SUPPRESSION CATEGORIE -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- JS BOOTSTRAP -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- SCRIPT FONTAWESOME -->
    <script src="https://kit.fontawesome.com/b12fc84aef.js" crossorigin="anonymous"></script>


    <!-- JS RECUPERATION INFO DANS MODALE MODIFICATION PRODUITS -->
    <script>
        var editProductModal = document.getElementById('editProductModal')
        editProductModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget

            var id = button.getAttribute('data-id-product')
            var label = button.getAttribute('data-label')
            var category = button.getAttribute('data-category')
            var price = button.getAttribute('data-price')

            var modalTitle = editProductModal.querySelector('.modal-title')
            var modalBodyInputName = editProductModal.querySelector('#editProductName')
            var modalBodyInputCategory = editProductModal.querySelector('#editProductCategory')
            var modalBodyInputPrice = editProductModal.querySelector('#editProductPrice')
            var modalBodyInputId = editProductModal.querySelector('#editProductId')

            modalTitle.textContent = 'Modifier le produit ' + label
            modalBodyInputName.value = label
            modalBodyInputCategory.value = category
            modalBodyInputPrice.value = price
            modalBodyInputId.value = id
        })
    </script>

    <!-- JS RECUPERATION INFO DANS MODALE MODIFICATION CATEGORIE -->
    <script>
        var editCategoryModal = document.getElementById('editCategoryModal')
        editCategoryModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget

            var id = button.getAttribute('data-id-category')
            var label = button.getAttribute('data-label-category')

            var modalTitle = editCategoryModal.querySelector('.modal-title-category')
            var modalBodyInputName = editCategoryModal.querySelector('#editCategoryName')
            var modalBodyInputId = editCategoryModal.querySelector('#editCategoryId')

            modalTitle.textContent = 'Modifier le produit ' + label
            modalBodyInputName.value = label
            modalBodyInputId.value = id
        })
    </script>

</body>
</html>
