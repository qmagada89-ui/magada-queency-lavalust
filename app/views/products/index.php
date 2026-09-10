<?php defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="container">
        <div class="topbar">
            <div class="topbar-heading">
                <h1>Products</h1>
                <span class="accent-rule" aria-hidden="true"></span>
            </div>
            <div class="topbar-meta">
                <span class="muted">Signed in as <?= html_escape($session->userdata('username')) ?></span>
                <a href="<?= site_url('logout') ?>" class="btn-outline btn-small">Log out</a>
            </div>
        </div>

        <a href="<?= site_url('products/create') ?>" class="btn">Add product</a>

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Created</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)): ?>
                <tr><td colspan="6" class="muted">No products yet — add your first one above.</td></tr>
                <?php else: ?>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= html_escape($product->product_name) ?></td>
                    <td><?= html_escape($product->description) ?></td>
                    <td><?= html_escape(number_format((float) $product->price, 2)) ?></td>
                    <td><?= html_escape($product->quantity) ?></td>
                    <td><?= html_escape($product->created_at) ?></td>
                    <td class="actions">
                        <a href="<?= site_url('products/edit/'.$product->id) ?>">Edit</a>
                        <a href="<?= site_url('products/delete/'.$product->id) ?>"
                           onclick="return confirm('Delete this product?');">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>