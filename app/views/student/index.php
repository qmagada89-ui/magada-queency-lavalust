<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $portal_title ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Sora:wght@600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url('assets/css/student.css') ?>">
</head>
<body>

  <nav class="nav">
    <a href="<?= site_url('student') ?>" class="active">Home</a>
    <a href="<?= site_url('student/profile') ?>">Student Profile</a>
  </nav>

  <main class="wrap">

    <?php if (!empty($denied)): ?>
      <div class="notice">
        🔒 You were redirected back here because your session hadn't
        checked in yet. You're checked in now — Student Profile is
        unlocked below.
      </div>
    <?php endif; ?>

    <section class="card hero">
      <p class="eyebrow">Web Systems and Technologies · LavaLust</p>
      <h1><?= $portal_title ?></h1>
      <p class="lead">
        This is the student home page for the Routing, Controllers,
        Views, and Middleware laboratory activity. Visiting this page
        checks in your session — head to Student Profile to see the
        data <code>StudentController</code> passes to the view, guarded
        by <code>StudentMiddleware</code>.
      </p>
      <a class="btn" href="<?= site_url('student/profile') ?>">View Student Profile →</a>
    </section>

    <section class="grid">
      <div class="mini-card">
        <span class="tag">Route</span>
        <p>/student → StudentController::index</p>
      </div>
      <div class="mini-card">
        <span class="tag">Route</span>
        <p>/student/profile → StudentController::profile</p>
      </div>
      <div class="mini-card">
        <span class="tag">Middleware</span>
        <p>StudentMiddleware guards the profile route</p>
      </div>
    </section>

  </main>

  <footer class="footer">
    <p>Laboratory Activity No. 3 — Routing, Controllers, Views &amp; Middleware</p>
  </footer>

</body>
</html>
