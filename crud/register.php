<?php
require_once __DIR__ . '/config.php';

// Jika sudah login, langsung alihkan ke dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$error = '';
$nama = '';
$username = '';
$email = '';

// Proses form registrasi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Validasi input
    if (empty($nama) || empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = 'Semua kolom wajib diisi!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Format email tidak valid!';
    } elseif (strlen($password) < 5) {
        $error = 'Password minimal terdiri dari 5 karakter!';
    } elseif ($password !== $confirm_password) {
        $error = 'Konfirmasi password tidak cocok!';
    } else {
        // Cek apakah username sudah terdaftar
        $stmtCheck = mysqli_prepare($mysqli, "SELECT id FROM users WHERE username = ? OR email = ? LIMIT 1");
        mysqli_stmt_bind_param($stmtCheck, "ss", $username, $email);
        mysqli_stmt_execute($stmtCheck);
        $resCheck = mysqli_stmt_get_result($stmtCheck);

        if (mysqli_num_rows($resCheck) > 0) {
            $error = 'Username atau Email sudah terdaftar! Silakan gunakan yang lain.';
        } else {
            // Hash password dan simpan ke database
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmtInsert = mysqli_prepare($mysqli, "INSERT INTO users (nama, username, email, password) VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmtInsert, "ssss", $nama, $username, $email, $hashedPassword);

            if (mysqli_stmt_execute($stmtInsert)) {
                header("Location: login.php?registered=1");
                exit;
            } else {
                $error = 'Terjadi kesalahan saat pendaftaran: ' . mysqli_error($mysqli);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Akun - SIM RS Data Alat Elektromedis</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="assets/images/favicon.ico">
    
    <!-- Local Third-Party Libraries -->
    <link rel="stylesheet" href="assets/libs/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/libs/bootstrap-icons/bootstrap-icons.css">
    
    <!-- Main Design System & Custom Stylesheet -->
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>

    <!-- Authentication Container & Register Card -->
    <div class="login-wrapper">
        <div class="login-bg-shape login-bg-shape-1"></div>
        <div class="login-bg-shape login-bg-shape-2"></div>
        
        <div class="login-card" style="max-width: 480px;">
            
            <!-- Brand Identity -->
            <a href="login.php" class="login-brand text-decoration-none">
                <i class="bi bi-hospital"></i>
                <span>SIM RS Medis</span>
            </a>
            
            <p class="login-subtitle">Daftarkan akun baru untuk mengelola sistem elektromedis</p>
            
            <!-- Alerts / Notifications -->
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger d-flex align-items-center py-2 px-3 mb-3 rounded-3" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                    <div><?php echo htmlspecialchars($error); ?></div>
                </div>
            <?php endif; ?>

            <!-- Register Form -->
            <form action="register.php" method="POST" id="registerForm" class="needs-validation" novalidate>
                
                <!-- Nama Lengkap Input -->
                <div class="login-form-group">
                    <label for="nama" class="login-form-label">Nama Lengkap</label>
                    <div class="login-input-group">
                        <i class="bi bi-person-badge input-icon"></i>
                        <input type="text" id="nama" name="nama" class="login-input" 
                               placeholder="Nama Lengkap Anda" 
                               value="<?php echo htmlspecialchars($nama); ?>" required>
                    </div>
                </div>

                <!-- Username Input -->
                <div class="login-form-group">
                    <label for="username" class="login-form-label">Username</label>
                    <div class="login-input-group">
                        <i class="bi bi-person input-icon"></i>
                        <input type="text" id="username" name="username" class="login-input" 
                               placeholder="Username unik" 
                               value="<?php echo htmlspecialchars($username); ?>" required>
                    </div>
                </div>

                <!-- Email Input -->
                <div class="login-form-group">
                    <label for="email" class="login-form-label">Email</label>
                    <div class="login-input-group">
                        <i class="bi bi-envelope input-icon"></i>
                        <input type="email" id="email" name="email" class="login-input" 
                               placeholder="nama@email.com" 
                               value="<?php echo htmlspecialchars($email); ?>" required>
                    </div>
                </div>
                
                <!-- Password Input -->
                <div class="login-form-group">
                    <label for="password" class="login-form-label">Password</label>
                    <div class="login-input-group">
                        <i class="bi bi-shield-lock input-icon"></i>
                        <input type="password" id="password" name="password" class="login-input login-input-password" 
                               placeholder="Minimal 5 karakter" required>
                        <button type="button" class="password-toggle-btn" id="toggle-password" aria-label="Lihat password">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Konfirmasi Password Input -->
                <div class="login-form-group">
                    <label for="confirm_password" class="login-form-label">Konfirmasi Password</label>
                    <div class="login-input-group">
                        <i class="bi bi-shield-check input-icon"></i>
                        <input type="password" id="confirm_password" name="confirm_password" class="login-input login-input-password" 
                               placeholder="Ulangi password" required>
                    </div>
                </div>
                
                <!-- Submit Button -->
                <button type="submit" class="btn-login mt-3" id="btn-submit">
                    <span>Daftar Akun Baru</span>
                    <i class="bi bi-check2-circle"></i>
                </button>
                
            </form>
            
            <!-- Footer Link -->
            <p class="login-footer-text mt-3">
                Sudah memiliki akun? <a href="login.php" class="fw-semibold">Masuk di Sini</a>
            </p>
            
        </div>
    </div>

    <!-- Scripts -->
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        // Password visibility toggle
        const toggleBtn = document.getElementById('toggle-password');
        const passInput = document.getElementById('password');
        const confirmPassInput = document.getElementById('confirm_password');
        
        if (toggleBtn && passInput) {
            toggleBtn.addEventListener('click', function () {
                const type = passInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passInput.setAttribute('type', type);
                if (confirmPassInput) confirmPassInput.setAttribute('type', type);
                
                const icon = this.querySelector('i');
                if (type === 'text') {
                    icon.classList.remove('bi-eye');
                    icon.classList.add('bi-eye-slash');
                } else {
                    icon.classList.remove('bi-eye-slash');
                    icon.classList.add('bi-eye');
                }
            });
        }
    </script>
</body>
</html>
