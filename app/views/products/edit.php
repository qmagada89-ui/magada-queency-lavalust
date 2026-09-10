<?php defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="container narrow">
        <h1>Edit product</h1>
        <form method="post" action="<?= site_url('products/edit/'.$product->id) ?>">
            <label for="product_name">Product name</label>
            <input type="text" id="product_name" name="product_name"
                   value="<?= html_escape($product->product_name) ?>" required autofocus>

            <label for="description">Description</label>
            <textarea id="description" name="description" rows="4"><?= html_escape($product->description) ?></textarea>

            <label for="price">Price</label>
            <input type="number" id="price" name="price" step="0.01" min="0"
                   value="<?= html_escape($product->price) ?>" required>

            <label for="quantity">Quantity</label>
            <input type="number" id="quantity" name="quantity" min="0"
                   value="<?= html_escape($product->quantity) ?>" required>

            <div class="form-actions">
                <button type="submit">Update product</button>
                <a href="<?= site_url('products') ?>" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
