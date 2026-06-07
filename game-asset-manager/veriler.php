<?php
require_once 'config/db.php';
require_once 'includes/header.php';

// Güvenlik Kontrolü: Eğer kullanıcı giriş yapmamışsa, login sayfasına geri gönder (URL'den izinsiz girişi engeller)
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Giriş yapan kullanıcının ID'sini alıyoruz
$user_id = $_SESSION['user_id'];

// Sadece bu kullanıcıya ait olan verileri veritabanından çekiyoruz (En son eklenen en üstte olacak şekilde)
$stmt = $db->prepare("SELECT * FROM assets WHERE user_id = :user_id ORDER BY created_at DESC");
$stmt->execute(['user_id' => $user_id]);
$assets = $stmt->fetchAll();
?>

<div class="row mb-4">
    <div class="col-md-8">
        <h2><i class="fa-solid fa-box-open me-2"></i>Varlık (Asset) Kütüphanem</h2>
        <p class="text-muted">Projenize ait tüm dijital varlıkları buradan yönetebilirsiniz.</p>
    </div>
    <div class="col-md-4 text-md-end">
        <a href="veri-ekle.php" class="btn btn-success mt-2">
            <i class="fa-solid fa-plus me-1"></i> Yeni Varlık Ekle
        </a>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0 table-responsive">
        <table class="table table-hover table-striped mb-0">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Varlık Adı</th>
                    <th>Tür</th>
                    <th>Format</th>
                    <th>Lisans</th>
                    <th class="text-end">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($assets) > 0): ?>
                    <?php foreach ($assets as $index => $asset): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td class="fw-bold"><?php echo htmlspecialchars($asset['asset_name']); ?></td>
                            <td>
                                <span class="badge bg-secondary"><?php echo htmlspecialchars($asset['asset_type']); ?></span>
                            </td>
                            <td><?php echo htmlspecialchars($asset['file_format']); ?></td>
                            <td><?php echo htmlspecialchars($asset['license_type']); ?></td>
                            <td class="text-end">
                                <a href="veri-duzenle.php?id=<?php echo $asset['id']; ?>" class="btn btn-sm btn-primary" title="Düzenle">
                                    <i class="fa-solid fa-pen-to-square"></i> Düzenle
                                </a>
                                <a href="veri-sil.php?id=<?php echo $asset['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bu varlığı silmek istediğinize emin misiniz?');" title="Sil">
                                    <i class="fa-solid fa-trash"></i> Sil
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            <i class="fa-solid fa-folder-open fs-1 mb-3 d-block"></i>
                            Henüz hiç varlık eklemediniz.<br>
                            Yukarıdaki "Yeni Varlık Ekle" butonunu kullanarak ilk öğenizi oluşturun.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>