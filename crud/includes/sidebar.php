<!-- START: Sidebar Component -->
<div class="sidebar-wrapper" id="sidebar">
  <!-- Brand Logo / Identity -->
  <a href="index.php" class="sidebar-brand">
    <i class="bi bi-hospital"></i>
    <span>SIM RS Medis</span>
  </a>

  <!-- Navigation Menu -->
  <div class="flex-grow-1 overflow-y-auto">
    <!-- Group: Menu Utama -->
    <div class="sidebar-menu-section">
      <div class="sidebar-menu-title">Menu Utama</div>
      <ul class="sidebar-menu-list">
        <li class="sidebar-menu-item">
          <a href="index.php" class="sidebar-menu-link <?php echo (isset($active_menu) && $active_menu === 'dashboard') ? 'active' : ''; ?>" id="menu-overview" title="Data Alat Elektromedis">
            <i class="bi bi-speedometer2"></i>
            <span>Data Alat Medis</span>
          </a>
        </li>
        <li class="sidebar-menu-item">
          <a href="add.php" class="sidebar-menu-link <?php echo (isset($active_menu) && $active_menu === 'add') ? 'active' : ''; ?>" id="menu-add" title="Tambah Data Alat">
            <i class="bi bi-plus-circle-fill"></i>
            <span>Tambah Alat</span>
          </a>
        </li>
      </ul>
    </div>

    <!-- Group: Autentikasi -->
    <div class="sidebar-menu-section">
      <div class="sidebar-menu-title">Akun & Sistem</div>
      <ul class="sidebar-menu-list">
        <li class="sidebar-menu-item">
          <a href="logout.php" class="sidebar-menu-link text-danger" title="Logout">
            <i class="bi bi-box-arrow-right text-danger"></i>
            <span>Keluar (Logout)</span>
          </a>
        </li>
      </ul>
    </div>
  </div>

  <!-- Sidebar Profile Card (Dynamic Footer) -->
  <div class="sidebar-profile">
    <img src="assets/images/avatar.png" alt="User Avatar" class="sidebar-profile-img"
      onerror="this.src='https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['user_nama'] ?? 'Admin'); ?>&background=072F1F&color=B4F105'">
    <div class="sidebar-profile-info">
      <div class="sidebar-profile-name"><?php echo htmlspecialchars($_SESSION['user_nama'] ?? 'Administrator'); ?></div>
      <div class="sidebar-profile-email"><?php echo htmlspecialchars($_SESSION['user_email'] ?? 'admin@simrs.local'); ?></div>
    </div>
  </div>
</div>
<!-- END: Sidebar Component -->
