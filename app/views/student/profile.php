<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Profile · <?= $portal_title ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Sora:wght@600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url('assets/css/student.css') ?>">
</head>
<body>

  <nav class="nav">
    <a href="<?= site_url('student') ?>">Home</a>
    <a href="<?= site_url('student/profile') ?>" class="active">Student Profile</a>
  </nav>

  <main class="wrap">
    <section class="id-card">
      <div class="id-card__band">
        <h2 class="band-label">Student Information</h2>
      </div>

      <div class="id-card__body">
        <div class="avatar"><?= strtoupper(substr($student['name'], 0, 1)) ?></div>

        <h1><?= $student['name'] ?></h1>
        <p class="muted"><?= $student['course'] ?> · <?= $student['year'] ?> · Section <?= $student['section'] ?></p>

        <dl class="fields">
          <div class="field">
            <dt>Student ID</dt>
            <dd><?= $student['student_id'] ?></dd>
          </div>
          <div class="field">
            <dt>Name</dt>
            <dd><?= $student['name'] ?></dd>
          </div>
          <div class="field">
            <dt>Course</dt>
            <dd><?= $student['course'] ?></dd>
          </div>
          <div class="field">
            <dt>Year Level</dt>
            <dd><?= $student['year'] ?></dd>
          </div>
          <div class="field">
            <dt>Section</dt>
            <dd><?= $student['section'] ?></dd>
          </div>
          <div class="field">
            <dt>Email</dt>
            <dd><?= $student['email'] ?></dd>
          </div>
        </dl>
      </div>
    </section>
  </main>

  <footer class="footer">
    <p>🔒 This page is protected by StudentMiddleware.</p>
  </footer>

</body>
</html>
