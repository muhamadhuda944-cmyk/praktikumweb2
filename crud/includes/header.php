<?php
require_once __DIR__ . '/../auth_check.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo isset($page_title) ? htmlspecialchars($page_title) . ' - SIM RS' : 'SIM RS - Sistem Informasi Rumah Sakit'; ?></title>

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="assets/images/favicon.ico">

  <!-- Local Third-Party Libraries -->
  <link rel="stylesheet" href="assets/libs/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/libs/bootstrap-icons/bootstrap-icons.css">

  <!-- Main Design System & Custom Stylesheet -->
  <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>

  <!-- Sidebar Component -->
  <?php include_once __DIR__ . '/sidebar.php'; ?>

  <!-- Main Content Wrapper -->
  <div class="main-wrapper">

    <!-- Top Navbar Component -->
    <?php include_once __DIR__ . '/navbar.php'; ?>
