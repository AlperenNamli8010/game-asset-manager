<?php
require_once 'config/db.php';
require_once 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$mesaj = '';
$mesaj_tur = '';
$user_id = $_SESSION['user_id'];

// 1. AŞAMA: URL'den gelen ID'ye göre mevcut veriyi veritabanından çekip forma doldurma
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $stmt = $db->prepare("SELECT * FROM assets WHERE id = :id AND user_id = :user_id");
    $stmt->execute(['id' => $id, 'user_id' => $user_id]);
    $asset = $stmt->fetch();

    if (!$asset) {
        // Eğer böyle bir veri yoksa veya başkasının verisiyse tabloya geri gönder
        header("Location: veriler.php");
        exit;
    }
} else {
    header("Location: veriler.php");
    exit;
}

// 2. AŞAMA: Form gönderildiğinde veriyi güncelleme (Update)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $asset_name = trim($_POST['asset_name']);
    $asset_type = $_POST['asset_type'];
    $file_format = trim($_POST['file_format']);
    $license_type = trim($_POST['license_type']);
    $description = trim($_POST['description']);

    if (empty($asset_name) || empty($asset_type) || empty($file_format) || empty($license_type)) {
        $mesaj = "Lütfen zorunlu alanları doldurun.";
        $mesaj_tur = "danger";
    } else {
        $update_stmt = $db->prepare("UPDATE assets SET asset_name = :asset_name, asset_type = :asset_type, 
                                     file_format = :file_format, license_type = :license_type, description = :description 
                                     WHERE id = :id AND user_id = :user_id");
        
        $basarili = $update_stmt->execute([
            'asset_name' => $asset_name,
            'asset_type' => $asset_type,
            'file_format' => $file_format,
            'license_type' => $license_type,
            'description' => $description,
            'id' => $id,
            'user_id' => $user_id
        ]);

        if ($basarili) {
            $mesaj = "Varlık başarıyla güncellendi!";
            $mesaj_tur = "success";
            
            // Güncel veriyi tekrar çekiyoruz ki formda yeni hali görünsün
            $stmt->execute(['id' => $id, 'user_id' => $user_id]);
            $asset = $stmt->fetch();
        } else {
            $mesaj = "Güncelleme sırasında bir hata oluştu.";
            $mesaj_tur = "danger";
        }
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fa-solid fa-pen-to-square me-2"></i>Varlığı Düzenle</h5>
            </div>
            <div class="card-body">
                
                <?php if (!empty($mesaj)): ?>
                    <div class="alert alert-<?php echo $mesaj_tur; ?> alert-dismissible fade show" role="alert">
                        <?php echo $mesaj; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form action="veri-duzenle.php?id=<?php echo $asset['id']; ?>" method="POST">
                    <div class="mb-3">
                        <label for="asset_name" class="form-label">Varlık Adı <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="asset_name" name="asset_name" value="<?php echo htmlspecialchars($asset['asset_name']); ?>" required>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="asset_type" class="form-label">Varlık Türü <span class="text-danger">*</span></label>
                            <select class="form-select" id="asset_type" name="asset_type" required>
                                <option value="Ses/Müzik" <?php echo ($asset['asset_type'] == 'Ses/Müzik') ? 'selected' : ''; ?>>Ses / Müzik</option>
                                <option value="3D Model" <?php echo ($asset['asset_type'] == '3D Model') ? 'selected' : ''; ?>>3D Model</option>
                                <option value="2D Grafik/UI" <?php echo ($asset['asset_type'] == '2D Grafik/UI') ? 'selected' : ''; ?>>2D Grafik / UI</option>
                                <option value="Kod/Script" <?php echo ($asset['asset_type'] == 'Kod/Script') ? 'selected' : ''; ?>>Kod / Script</option>
                                <option value="Animasyon" <?php echo ($asset['asset_type'] == 'Animasyon') ? 'selected' : ''; ?>>Animasyon</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="file_format" class="form-label">Dosya Formatı <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="file_format" name="file_format" value="<?php echo htmlspecialchars($asset['file_format']); ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="license_type" class="form-label">Lisans Türü <span class="text-danger">*</span></label>
                        <select class="form-select" id="license_type" name="license_type" required>
                            <option value="MIT" <?php echo ($asset['license_type'] == 'MIT') ? 'selected' : ''; ?>>MIT</option>
                            <option value="CC0 (Public Domain)" <?php echo ($asset['license_type'] == 'CC0 (Public Domain)') ? 'selected' : ''; ?>>CC0 (Telif Hakkı Yok)</option>
                            <option value="Ticari" <?php echo ($asset['license_type'] == 'Ticari') ? 'selected' : ''; ?>>Ticari Lisans</option>
                            <option value="Sadece Kişisel Kullanım" <?php echo ($asset['license_type'] == 'Sadece Kişisel Kullanım') ? 'selected' : ''; ?>>Sadece Kişisel Kullanım</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label">Açıklama / Notlar</label>
                        <textarea class="form-control" id="description" name="description" rows="3"><?php echo htmlspecialchars($asset['description']); ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save me-2"></i>Değişiklikleri Kaydet</button>
                    <a href="veriler.php" class="btn btn-secondary">İptal / Geri Dön</a>
                </form>

            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>