<?php defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register &middot; Products</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="split-auth">
        <div class="visual-panel">
            <span class="ring-outer" aria-hidden="true"></span>
            <span class="ring-inner" aria-hidden="true"></span>
            <div class="brand">
                <p class="brand-mark">Products</p>
                <span class="brand-rule" aria-hidden="true"></span>
                <p class="brand-tagline">Track inventory, manage records, and keep your catalog organized.</p>
            </div>
        </div>
        <div class="form-panel">
            <div class="auth-box">
                <h1>Create an account</h1>
                <?php if (!empty($error)): ?>
                    <p class="alert"><?= html_escape($error) ?></p>
                <?php endif; ?>
                <form method="post" action="<?= site_url('register') ?>">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required autofocus>

                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required minlength="6">

                    <div class="form-actions">
                        <button type="submit">Create account</button>
                    </div>
                </form>
                <p class="muted">Already have an account? <a href="<?= site_url('login') ?>">Log in</a></p>
            </div>
        </div>
    </div>
</body>
</html>