<?php
$page_title = "Edit Alat Elektromedis";
$active_menu = "dashboard";

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/auth_check.php';

$error = '';

// Proses update saat form dikirim
if (isset($_POST['update'])) {
    $id = intval($_POST['id'] ?? 0);
    $nama_alat = trim($_POST['nama_alat'] ?? '');
    $tahun = trim($_POST['tahun'] ?? '');
    $merek = trim($_POST['merek'] ?? '');
    $lokasi = trim($_POST['lokasi'] ?? '');

    if (empty($id) || empty($nama_alat) || empty($tahun) || empty($merek) || empty($lokasi)) {
        $error = "Semua kolom data alat wajib diisi!";
    } else {
        $stmtUpdate = mysqli_prepare($mysqli, "UPDATE alat SET nama_alat = ?, tahun = ?, merek = ?, lokasi = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmtUpdate, "ssssi", $nama_alat, $tahun, $merek, $lokasi, $id);

        if (mysqli_stmt_execute($stmtUpdate)) {
            header("Location: index.php?msg=updated");
            exit;
        } else {
            $error = "Gagal memperbarui data alat: " . mysqli_error($mysqli);
        }
    }
}

// Ambil ID dari URL
$id = isset($_GET['id']) ? intval($_GET['id']) : (isset($_POST['id']) ? intval($_POST['id']) : 0);

if ($id <= 0) {
    header("Location: index.php");
    exit;
}

// Ambil data alat yang ingin diedit
$stmt = mysqli_prepare($mysqli, "SELECT * FROM alat WHERE id = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user_data = mysqli_fetch_assoc($result);

if (!$user_data) {
    header("Location: index.php");
    exit;
}

$nama_alat = $user_data['nama_alat'];
$tahun = $user_data['tahun'];
$merek = $user_data['merek'];
$lokasi = $user_data['lokasi'];

include_once __DIR__ . '/includes/header.php';
?>

<!-- START: Page Header -->
<div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
  <div>
    <h1 class="page-title">Edit Alat Elektromedis</h1>
    <p class="page-subtitle">Perbarui rincian informasi data alat elektromedis #<?php echo $id; ?></p>
  </div>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none text-muted-green">Home</a></li>
      <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none text-muted-green">Data Alat</a></li>
      <li class="breadcrumb-item active text-main" aria-current="page">Edit #<?php echo $id; ?></li>
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
          <i class="bi bi-pencil-square fs-4"></i>
        </div>
        <div>
          <h5 class="fw-bold text-main mb-0">Formulir Perubahan Data Alat</h5>
          <small class="text-muted">Perbarui data yang diperlukan kemudian simpan perubahan</small>
        </div>
      </div>

      <form action="edit.php" method="POST" name="update_user" class="needs-validation">
        <input type="hidden" name="id" value="<?php echo $id; ?>">

        <div class="mb-3">
          <label for="nama_alat" class="form-label-custom">
            <i class="bi bi-cpu me-1 text-success"></i> Nama Alat Elektromedis <span class="text-danger">*</span>
          </label>
          <input type="text" class="form-control form-control-custom" id="nama_alat" name="nama_alat" 
                 value="<?php echo htmlspecialchars($nama_alat); ?>" required>
        </div>

        <div class="row g-3 mb-3">
          <div class="col-12 col-md-6">
            <label for="tahun" class="form-label-custom">
              <i class="bi bi-calendar-event me-1 text-success"></i> Tahun Pengadaan <span class="text-danger">*</span>
            </label>
            <input type="number" class="form-control form-control-custom" id="tahun" name="tahun" 
                   min="1990" max="<?php echo date('Y') + 2; ?>" 
                   value="<?php echo htmlspecialchars($tahun); ?>" required>
          </div>

          <div class="col-12 col-md-6">
            <label for="merek" class="form-label-custom">
              <i class="bi bi-tag me-1 text-success"></i> Merek / Produsen <span class="text-danger">*</span>
            </label>
            <input type="text" class="form-control form-control-custom" id="merek" name="merek" 
                 value="<?php echo htmlspecialchars($merek); ?>" required>
          </div>
        </div>

        <div class="mb-4">
          <label for="lokasi" class="form-label-custom">
            <i class="bi bi-geo-alt me-1 text-success"></i> Lokasi / Ruangan <span class="text-danger">*</span>
          </label>
          <input type="text" class="form-control form-control-custom" id="lokasi" name="lokasi" 
                 value="<?php echo htmlspecialchars($lokasi); ?>" required>
        </div>

        <div class="d-flex align-items-center gap-2 pt-3 border-top">
          <button type="submit" name="update" class="btn-custom btn-custom-primary">
            <i class="bi bi-check-lg"></i> Update Data Alat
          </button>
          <a href="index.php" class="btn-custom btn-custom-light">
            <i class="bi bi-arrow-left"></i> Batal
          </a>
        </div>

      </form>
    </div>

  </div>
</div>
<!-- END: Form Container -->

<?php include_once __DIR__ . '/includes/footer.php'; ?>
