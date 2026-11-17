<!-- START: Top Navbar Component -->
<header class="navbar-custom">
  <div class="navbar-left">
    <!-- Desktop sidebar toggle -->
    <button class="btn-desktop-toggle d-none d-xl-flex align-items-center justify-content-center me-3"
      id="desktop-sidebar-toggle" aria-label="Minimize Sidebar">
      <i class="bi bi-chevron-bar-left"></i>
    </button>
    <!-- Mobile sidebar toggle -->
    <button class="sidebar-toggle-btn me-2" id="sidebar-toggle" aria-label="Toggle Navigation">
      <i class="bi bi-list"></i>
    </button>

    <!-- Quick Action -->
    <a href="add.php" class="btn-quick-action text-decoration-none">
      <i class="bi bi-plus-lg"></i>
      <span>Tambah Alat</span>
    </a>
  </div>

  <!-- Right actions -->
  <div class="navbar-actions ms-auto">
    <!-- Fullscreen Toggle -->
    <button class="navbar-action-btn me-2" aria-label="Toggle Fullscreen" id="btn-fullscreen">
      <i class="bi bi-arrows-fullscreen"></i>
    </button>

    <!-- User Profile Dropdown -->
    <div class="dropdown">
      <button class="navbar-profile-btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
        aria-expanded="false" id="profile-dropdown">
        <img src="assets/images/avatar.png" alt="Profile" class="navbar-profile-img"
          onerror="this.src='https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['user_nama'] ?? 'Admin'); ?>&background=072F1F&color=B4F105'">
        <span class="navbar-profile-name d-none d-md-inline">
          <?php echo htmlspecialchars($_SESSION['user_nama'] ?? 'Administrator'); ?>
        </span>
        <i class="bi bi-chevron-down navbar-profile-caret"></i>
      </button>
      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-profile shadow-sm border-0" aria-labelledby="profile-dropdown">
        <li class="dropdown-header">
          <div class="fw-bold text-dark"><?php echo htmlspecialchars($_SESSION['user_nama'] ?? 'Administrator'); ?></div>
          <small class="text-muted"><?php echo htmlspecialchars($_SESSION['user_email'] ?? 'admin@simrs.local'); ?></small>
        </li>
        <li><hr class="dropdown-divider"></li>
        <li>
          <a class="dropdown-item" href="index.php">
            <i class="bi bi-speedometer2"></i> Data Alat
          </a>
        </li>
        <li>
          <a class="dropdown-item" href="add.php">
            <i class="bi bi-plus-circle"></i> Tambah Alat
          </a>
        </li>
        <li><hr class="dropdown-divider"></li>
        <li>
          <a class="dropdown-item text-danger fw-semibold" href="logout.php">
            <i class="bi bi-box-arrow-right"></i> Keluar (Logout)
          </a>
        </li>
      </ul>
    </div>
  </div>
</header>
<!-- END: Top Navbar Component -->
