<?php
require_once __DIR__ . '/config.php';

// Jika sudah login, alihkan langsung ke halaman utama
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$error = '';
$username_or_email = '';

// Proses form login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username_or_email = trim($_POST['username_or_email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username_or_email) || empty($password)) {
        $error = 'Silakan isi username/email dan password!';
    } else {
        // Cari pengguna berdasarkan username atau email dengan prepared statement
        $stmt = mysqli_prepare($mysqli, "SELECT * FROM users WHERE username = ? OR email = ? LIMIT 1");
        mysqli_stmt_bind_param($stmt, "ss", $username_or_email, $username_or_email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);

        if ($user && password_verify($password, $user['password'])) {
            // Berhasil login: simpan data pengguna ke session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_nama'] = $user['nama'];
            $_SESSION['user_username'] = $user['username'];
            $_SESSION['user_email'] = $user['email'];

            header("Location: index.php");
            exit;
        } else {
            $error = 'Username/Email atau password salah!';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIM RS Data Alat Elektromedis</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="assets/images/favicon.ico">
    
    <!-- Local Third-Party Libraries -->
    <link rel="stylesheet" href="assets/libs/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/libs/bootstrap-icons/bootstrap-icons.css">
    
    <!-- Main Design System & Custom Stylesheet -->
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>

    <!-- Authentication Container & Login Card -->
    <div class="login-wrapper">
        <div class="login-bg-shape login-bg-shape-1"></div>
        <div class="login-bg-shape login-bg-shape-2"></div>
        
        <div class="login-card">
            
            <!-- Brand Identity -->
            <a href="login.php" class="login-brand text-decoration-none">
                <i class="bi bi-hospital"></i>
                <span>SIM RS Medis</span>
            </a>
            
            <p class="login-subtitle">Silakan masuk untuk mengelola data alat elektromedis</p>
            
            <!-- Alerts / Notifications -->
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger d-flex align-items-center py-2 px-3 mb-3 rounded-3" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                    <div><?php echo htmlspecialchars($error); ?></div>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['registered'])): ?>
                <div class="alert alert-success d-flex align-items-center py-2 px-3 mb-3 rounded-3" role="alert">
                    <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                    <div>Registrasi berhasil! Silakan masuk dengan akun Anda.</div>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['logout'])): ?>
                <div class="alert alert-info d-flex align-items-center py-2 px-3 mb-3 rounded-3" role="alert">
                    <i class="bi bi-info-circle-fill me-2 fs-5"></i>
                    <div>Anda telah berhasil logout.</div>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['auth_required'])): ?>
                <div class="alert alert-warning d-flex align-items-center py-2 px-3 mb-3 rounded-3" role="alert">
                    <i class="bi bi-lock-fill me-2 fs-5"></i>
                    <div>Silakan login terlebih dahulu untuk mengakses sistem.</div>
                </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form action="login.php" method="POST" id="loginForm" class="needs-validation" novalidate>
                
                <!-- Username / Email Input -->
                <div class="login-form-group">
                    <label for="username_or_email" class="login-form-label">Username atau Email</label>
                    <div class="login-input-group">
                        <i class="bi bi-person input-icon"></i>
                        <input type="text" id="username_or_email" name="username_or_email" class="login-input" 
                               placeholder="admin atau admin@simrs.local" 
                               value="<?php echo htmlspecialchars($username_or_email); ?>" required>
                    </div>
                </div>
                
                <!-- Password Input -->
                <div class="login-form-group">
                    <label for="password" class="login-form-label">Password</label>
                    <div class="login-input-group">
                        <i class="bi bi-shield-lock input-icon"></i>
                        <input type="password" id="password" name="password" class="login-input login-input-password" 
                               placeholder="••••••••" required>
                        <button type="button" class="password-toggle-btn" id="toggle-password" aria-label="Lihat password">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Submit Button -->
                <button type="submit" class="btn-login mt-3" id="btn-submit">
                    <span>Masuk ke Dashboard</span>
                    <i class="bi bi-arrow-right"></i>
                </button>
                
            </form>

            <!-- Info Demo Account -->
            <div class="p-2 mt-4 rounded-3 text-center" style="background-color: rgba(7, 47, 31, 0.05); border: 1px dashed rgba(7, 47, 31, 0.2); font-size: 0.8rem; color: #072F1F;">
                <i class="bi bi-key-fill text-success"></i> <strong>Akun Demo:</strong> Username: <code>admin</code> | Password: <code>admin123</code>
            </div>
            
            <!-- Footer Link -->
            <p class="login-footer-text mt-3">
                Belum memiliki akun? <a href="register.php" id="link-register" class="fw-semibold">Daftar Sekarang</a>
            </p>
            
        </div>
    </div>

    <!-- Scripts -->
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/auth.js"></script>
</body>
</html>
