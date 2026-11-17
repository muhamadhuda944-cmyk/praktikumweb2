<?php
$page_title = "Tambah Alat Elektromedis";
$active_menu = "add";

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/auth_check.php';

$error = '';
$nama_alat = '';
$tahun = date('Y');
$merek = '';
$lokasi = '';

// Check if form is submitted
if (isset($_POST['Submit'])) {
    $nama_alat = trim($_POST['nama_alat'] ?? '');
    $tahun = trim($_POST['tahun'] ?? '');
    $merek = trim($_POST['merek'] ?? '');
    $lokasi = trim($_POST['lokasi'] ?? '');

    if (empty($nama_alat) || empty($tahun) || empty($merek) || empty($lokasi)) {
        $error = "Semua kolom data alat wajib diisi!";
    } else {
        // Insert data using prepared statement
        $stmt = mysqli_prepare($mysqli, "INSERT INTO alat(nama_alat, tahun, merek, lokasi) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssss", $nama_alat, $tahun, $merek, $lokasi);

        if (mysqli_stmt_execute($stmt)) {
            // Redirect ke halaman index dengan pesan sukses
            header("Location: index.php?msg=added");
            exit;
        } else {
            $error = "Gagal menambahkan data alat: " . mysqli_error($mysqli);
        }
    }
}

include_once __DIR__ . '/includes/header.php';
?>

<!-- START: Page Header -->
<div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
  <div>
    <h1 class="page-title">Tambah Alat Elektromedis</h1>
    <p class="page-subtitle">Daftarkan instrumen atau peralatan medis baru ke dalam database rumah sakit</p>
  </div>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none text-muted-green">Home</a></li>
      <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none text-muted-green">Data Alat</a></li>
      <li class="breadcrumb-item active text-main" aria-current="page">Tambah</li>
    </ol>
  </nav>
</div>
<!-- END: Page Header -->

<!-- START: Form Container -->
<div class="row justify-content-center">
  <div class="col-12 col-lg-8">
    
    <?php if (!empty($error)): ?>
      <div class="alert alert-danger d-flex align-items-center rounded-3 shadow-sm mb-4" role="alert">
        <i class="bi bi-exclamation-triangle-fill fs-5 me-2"></i>
        <div><?php echo htmlspecialchars($error); ?></div>
      </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
      <div class="d-flex align-items-center pb-3 mb-4 border-bottom">
        <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
             style="width: 48px; height: 48px; background: rgba(7, 47, 31, 0.08); color: #072F1F;">
          <i class="bi bi-plus-circle-fill fs-4"></i>
        </div>
        <div>
          <h5 class="fw-bold text-main mb-0">Formulir Tambah Alat Medis</h5>
          <small class="text-muted">Isi rincian informasi alat elektromedis dengan benar</small>
        </div>
      </div>

      <form action="add.php" method="POST" name="form1" class="needs-validation">
        
        <div class="mb-3">
          <label for="nama_alat" class="form-label-custom">
            <i class="bi bi-cpu me-1 text-success"></i> Nama Alat Elektromedis <span class="text-danger">*</span>
          </label>
          <input type="text" class="form-control form-control-custom" id="nama_alat" name="nama_alat" 
                 placeholder="Contoh: Defibrillator, USG 4D, Patient Monitor" 
                 value="<?php echo htmlspecialchars($nama_alat); ?>" required>
        </div>

        <div class="row g-3 mb-3">
          <div class="col-12 col-md-6">
            <label for="tahun" class="form-label-custom">
              <i class="bi bi-calendar-event me-1 text-success"></i> Tahun Pengadaan <span class="text-danger">*</span>
            </label>
            <input type="number" class="form-control form-control-custom" id="tahun" name="tahun" 
                   placeholder="Contoh: <?php echo date('Y'); ?>" min="1990" max="<?php echo date('Y') + 2; ?>" 
                   value="<?php echo htmlspecialchars($tahun); ?>" required>
          </div>

          <div class="col-12 col-md-6">
            <label for="merek" class="form-label-custom">
              <i class="bi bi-tag me-1 text-success"></i> Merek / Produsen <span class="text-danger">*</span>
            </label>
            <input type="text" class="form-control form-control-custom" id="merek" name="merek" 
                   placeholder="Contoh: Philips, GE, Siemens, Mindray" 
                   value="<?php echo htmlspecialchars($merek); ?>" required>
          </div>
        </div>

        <div class="mb-4">
          <label for="lokasi" class="form-label-custom">
            <i class="bi bi-geo-alt me-1 text-success"></i> Lokasi / Ruangan <span class="text-danger">*</span>
          </label>
          <input type="text" class="form-control form-control-custom" id="lokasi" name="lokasi" 
                 placeholder="Contoh: ICU, IGD, Poli Gigi, Radiologi" 
                 value="<?php echo htmlspecialchars($lokasi); ?>" required>
        </div>

        <div class="d-flex align-items-center gap-2 pt-3 border-top">
          <button type="submit" name="Submit" class="btn-custom btn-custom-primary">
            <i class="bi bi-check-lg"></i> Simpan Data Alat
          </button>
          <a href="index.php" class="btn-custom btn-custom-light">
            <i class="bi bi-arrow-left"></i> Kembali
          </a>
        </div>

      </form>
    </div>

  </div>
</div>
<!-- END: Form Container -->

<?php include_once __DIR__ . '/includes/footer.php'; ?>
