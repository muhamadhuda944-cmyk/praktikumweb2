<?php
$page_title = "Data Alat Elektromedis";
$active_menu = "dashboard";

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/auth_check.php';

// Fitur Pencarian Data
$search = trim($_GET['search'] ?? '');
if (!empty($search)) {
    $search_safe = mysqli_real_escape_string($mysqli, $search);
    $query = "SELECT * FROM alat WHERE 
              nama_alat LIKE '%$search_safe%' OR 
              tahun LIKE '%$search_safe%' OR 
              merek LIKE '%$search_safe%' OR 
              lokasi LIKE '%$search_safe%' 
              ORDER BY id DESC";
} else {
    $query = "SELECT * FROM alat ORDER BY id DESC";
}
$result = mysqli_query($mysqli, $query);

// Hitung Statistik Ringkasan
$statTotalAlat = mysqli_fetch_row(mysqli_query($mysqli, "SELECT COUNT(*) FROM alat"))[0] ?? 0;
$statTotalLokasi = mysqli_fetch_row(mysqli_query($mysqli, "SELECT COUNT(DISTINCT lokasi) FROM alat"))[0] ?? 0;
$statTotalMerek = mysqli_fetch_row(mysqli_query($mysqli, "SELECT COUNT(DISTINCT merek) FROM alat"))[0] ?? 0;

include_once __DIR__ . '/includes/header.php';
?>

<!-- START: Page Header -->
<div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
  <div>
    <h1 class="page-title">Data Alat Elektromedis</h1>
    <p class="page-subtitle">Sistem Informasi Manajemen Rumah Sakit - Inventaris dan Pemeliharaan Alat Medis</p>
  </div>
  <div class="d-flex align-items-center gap-2">
    <a href="add.php" class="btn-custom btn-custom-secondary">
      <i class="bi bi-plus-lg"></i>
      <span>Tambah Alat Baru</span>
    </a>
  </div>
</div>
<!-- END: Page Header -->

<!-- START: Flash Message Notifications -->
<?php if (isset($_GET['msg'])): ?>
  <?php if ($_GET['msg'] === 'added'): ?>
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center rounded-3 shadow-sm mb-4" role="alert">
      <i class="bi bi-check-circle-fill fs-5 me-2"></i>
      <div><strong>Sukses!</strong> Data alat medis baru berhasil ditambahkan ke sistem.</div>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php elseif ($_GET['msg'] === 'updated'): ?>
    <div class="alert alert-info alert-dismissible fade show d-flex align-items-center rounded-3 shadow-sm mb-4" role="alert">
      <i class="bi bi-info-circle-fill fs-5 me-2"></i>
      <div><strong>Sukses!</strong> Data alat medis berhasil diperbarui.</div>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php elseif ($_GET['msg'] === 'deleted'): ?>
    <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center rounded-3 shadow-sm mb-4" role="alert">
      <i class="bi bi-trash-fill fs-5 me-2"></i>
      <div><strong>Berhasil!</strong> Data alat medis telah dihapus dari sistem.</div>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php endif; ?>
<?php endif; ?>
<!-- END: Flash Message Notifications -->

<!-- START: Statistik Cards Row -->
<div class="row g-3 mb-4">
  <div class="col-12 col-sm-6 col-xl-4">
    <div class="card p-3 border-0 shadow-sm rounded-4 h-100" style="background: linear-gradient(135deg, #072F1F 0%, #1A3E30 100%); color: #fff;">
      <div class="d-flex align-items-center justify-content-between">
        <div>
          <span class="text-white-50 small text-uppercase fw-semibold">Total Alat Medis</span>
          <h2 class="display-6 fw-bold mb-0 text-white mt-1"><?php echo $statTotalAlat; ?></h2>
          <small class="text-white-50"><i class="bi bi-activity text-warning me-1"></i> Terdata aktif</small>
        </div>
        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 54px; height: 54px; background: rgba(180, 241, 5, 0.2); color: #B4F105;">
          <i class="bi bi-heart-pulse fs-3"></i>
        </div>
      </div>
    </div>
  </div>

  <div class="col-12 col-sm-6 col-xl-4">
    <div class="card p-3 border-0 shadow-sm rounded-4 h-100 bg-white">
      <div class="d-flex align-items-center justify-content-between">
        <div>
          <span class="text-muted-green small text-uppercase fw-semibold">Lokasi Ruangan</span>
          <h2 class="display-6 fw-bold mb-0 text-main mt-1"><?php echo $statTotalLokasi; ?></h2>
          <small class="text-muted-green"><i class="bi bi-geo-alt-fill text-danger me-1"></i> Titik sebaran alat</small>
        </div>
        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 54px; height: 54px; background: rgba(7, 47, 31, 0.08); color: #072F1F;">
          <i class="bi bi-hospital fs-3"></i>
        </div>
      </div>
    </div>
  </div>

  <div class="col-12 col-sm-12 col-xl-4">
    <div class="card p-3 border-0 shadow-sm rounded-4 h-100 bg-white">
      <div class="d-flex align-items-center justify-content-between">
        <div>
          <span class="text-muted-green small text-uppercase fw-semibold">Merek Terdaftar</span>
          <h2 class="display-6 fw-bold mb-0 text-main mt-1"><?php echo $statTotalMerek; ?></h2>
          <small class="text-muted-green"><i class="bi bi-tag-fill text-primary me-1"></i> Produsen / Vendor</small>
        </div>
        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 54px; height: 54px; background: rgba(34, 197, 94, 0.12); color: #22C55E;">
          <i class="bi bi-award fs-3"></i>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- END: Statistik Cards Row -->

<!-- START: Filter & Search Bar -->
<div class="card border-0 shadow-sm rounded-4 p-3 mb-4 bg-white">
  <form action="index.php" method="GET" class="row g-2 align-items-center">
    <div class="col-12 col-md-9">
      <div class="input-group">
        <span class="input-group-text bg-light border-end-0 text-muted">
          <i class="bi bi-search"></i>
        </span>
        <input type="text" name="search" class="form-control form-control-custom border-start-0" 
               placeholder="Cari berdasarkan nama alat, merek, tahun, atau lokasi..." 
               value="<?php echo htmlspecialchars($search); ?>">
      </div>
    </div>
    <div class="col-12 col-md-3 d-flex gap-2">
      <button type="submit" class="btn-custom btn-custom-primary w-100">
        <i class="bi bi-search"></i> Cari
      </button>
      <?php if (!empty($search)): ?>
        <a href="index.php" class="btn-custom btn-custom-light" title="Reset Pencarian">
          <i class="bi bi-arrow-counterclockwise"></i>
        </a>
      <?php endif; ?>
    </div>
  </form>
</div>
<!-- END: Filter & Search Bar -->

<!-- START: Table Card Container -->
<div class="table-card-custom mb-4">
  <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-white">
    <h5 class="mb-0 fw-bold text-main">
      <i class="bi bi-table me-2 text-success"></i>Daftar Alat Elektromedis
    </h5>
    <span class="badge bg-light text-dark border px-2 py-1">
      Total: <?php echo mysqli_num_rows($result); ?> Data
    </span>
  </div>

  <div class="table-responsive">
    <table class="table-custom mb-0">
      <thead>
        <tr>
          <th style="width: 60px;" class="text-center">No</th>
          <th>Nama Alat Elektromedis</th>
          <th>Tahun Pengadaan</th>
          <th>Merek</th>
          <th>Lokasi / Ruangan</th>
          <th style="width: 160px;" class="text-center">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php  
        $i = 1;
        if (mysqli_num_rows($result) > 0) {
            while ($user_data = mysqli_fetch_array($result)) {         
                echo "<tr>";
                echo "<td class='text-center fw-semibold text-muted'>" . $i . "</td>";
                echo "<td>";
                echo "<div class='d-flex align-items-center'>";
                echo "<div class='rounded-3 p-2 me-3 d-flex align-items-center justify-content-center' style='width: 38px; height: 38px; background-color: rgba(7, 47, 31, 0.08); color: #072F1F;'>";
                echo "<i class='bi bi-cpu-fill'></i>";
                echo "</div>";
                echo "<div>";
                echo "<div class='fw-bold text-main'>" . htmlspecialchars($user_data['nama_alat']) . "</div>";
                echo "<small class='text-muted'>ID Inventaris: #" . $user_data['id'] . "</small>";
                echo "</div>";
                echo "</div>";
                echo "</td>";

                echo "<td>";
                echo "<span class='badge bg-light text-dark border px-2 py-1'><i class='bi bi-calendar3 me-1'></i>" . htmlspecialchars($user_data['tahun']) . "</span>";
                echo "</td>";

                echo "<td>";
                echo "<span class='fw-semibold text-dark'><i class='bi bi-tag text-muted me-1'></i>" . htmlspecialchars($user_data['merek']) . "</span>";
                echo "</td>";

                echo "<td>";
                echo "<span class='badge bg-success-subtle text-success border border-success-subtle px-2 py-1'><i class='bi bi-geo-alt-fill me-1'></i>" . htmlspecialchars($user_data['lokasi']) . "</span>";
                echo "</td>";

                echo "<td class='text-center'>";
                echo "<div class='d-inline-flex gap-1'>";
                echo "<a href='edit.php?id=" . $user_data['id'] . "' class='btn-custom btn-custom-sm btn-custom-light text-primary' title='Edit Data'>";
                echo "<i class='bi bi-pencil-square'></i> Edit";
                echo "</a>";
                echo "<a href='delete.php?id=" . $user_data['id'] . "' class='btn-custom btn-custom-sm btn-custom-danger' title='Hapus Data' onclick=\"return confirm('Apakah Anda yakin ingin menghapus alat " . addslashes(htmlspecialchars($user_data['nama_alat'])) . "?');\">";
                echo "<i class='bi bi-trash'></i> Hapus";
                echo "</a>";
                echo "</div>";
                echo "</td>";
                echo "</tr>"; 
                $i++;       
            }
        } else {
            echo "<tr>";
            echo "<td colspan='6' class='text-center py-5'>";
            echo "<div class='text-muted'>";
            echo "<i class='bi bi-inbox fs-1 d-block mb-2 text-secondary'></i>";
            echo "<h6 class='fw-bold'>Belum Ada Data Alat</h6>";
            if (!empty($search)) {
                echo "<p class='small mb-3'>Tidak ada data yang cocok dengan pencarian <em>\"" . htmlspecialchars($search) . "\"</em></p>";
                echo "<a href='index.php' class='btn-custom btn-custom-light btn-custom-sm'><i class='bi bi-arrow-counterclockwise'></i> Tampilkan Semua Data</a>";
            } else {
                echo "<p class='small mb-3'>Belum ada alat elektromedis yang ditambahkan ke sistem.</p>";
                echo "<a href='add.php' class='btn-custom btn-custom-secondary btn-custom-sm'><i class='bi bi-plus-lg'></i> Tambah Data Sekarang</a>";
            }
            echo "</div>";
            echo "</td>";
            echo "</tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</div>
<!-- END: Table Card Container -->

<?php include_once __DIR__ . '/includes/footer.php'; ?>
