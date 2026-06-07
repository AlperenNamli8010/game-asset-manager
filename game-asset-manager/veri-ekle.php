<?php
require_once 'config/db.php';
require_once 'includes/header.php';

// Güvenlik: Sadece giriş yapmış kullanıcılar bu sayfayı görebilir
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$mesaj = '';
$mesaj_tur = '';

// Form gönderildiğinde verileri al ve kaydet
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $asset_name = trim($_POST['asset_name']);
    $asset_type = $_POST['asset_type'];
    $file_format = trim($_POST['file_format']);
    $license_type = trim($_POST['license_type']);
    $description = trim($_POST['description']);
    $user_id = $_SESSION['user_id']; // Hangi kullanıcının eklediğini buradan biliyoruz

    // Basit bir boş alan kontrolü
    if (empty($asset_name) || empty($asset_type) || empty($file_format) || empty($license_type)) {
        $mesaj = "Lütfen zorunlu alanları (Ad, Tür, Format, Lisans) doldurun.";
        $mesaj_tur = "danger";
    } else {
        // Veritabanına Ekleme (Create) İşlemi
        $stmt = $db->prepare("INSERT INTO assets (user_id, asset_name, asset_type, file_format, license_type, description) 
                              VALUES (:user_id, :asset_name, :asset_type, :file_format, :license_type, :description)");
        
        $basarili = $stmt->execute([
            'user_id' => $user_id,
            'asset_name' => $asset_name,
            'asset_type' => $asset_type,
            'file_format' => $file_format,
            'license_type' => $license_type,
            'description' => $description
        ]);

        if ($basarili) {
            $mesaj = "Oyun varlığı başarıyla eklendi!";
            $mesaj_tur = "success";
        } else {
            $mesaj = "Eklerken bir hata oluştu.";
            $mesaj_tur = "danger";
        }
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fa-solid fa-plus me-2"></i>Yeni Varlık Ekle</h5>
            </div>
            <div class="card-body">
                
                <?php if (!empty($mesaj)): ?>
                    <div class="alert alert-<?php echo $mesaj_tur; ?> alert-dismissible fade show" role="alert">
                        <?php echo $mesaj; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form action="veri-ekle.php" method="POST">
                    <div class="mb-3">
                        <label for="asset_name" class="form-label">Varlık Adı <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="asset_name" name="asset_name" placeholder="Örn: Ana Karakter Koşma Animasyonu" required>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="asset_type" class="form-label">Varlık Türü <span class="text-danger">*</span></label>
                            <select class="form-select" id="asset_type" name="asset_type" required>
                                <option value="">Seçiniz...</option>
                                <option value="Ses/Müzik">Ses / Müzik</option>
                                <option value="3D Model">3D Model</option>
                                <option value="2D Grafik/UI">2D Grafik / UI</option>
                                <option value="Kod/Script">Kod / Script</option>
                                <option value="Animasyon">Animasyon</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="file_format" class="form-label">Dosya Formatı <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="file_format" name="file_format" placeholder="Örn: fbx, mp3, png, cs" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="license_type" class="form-label">Lisans Türü <span class="text-danger">*</span></label>
                        <select class="form-select" id="license_type" name="license_type" required>
                            <option value="">Seçiniz...</option>
                            <option value="MIT">MIT</option>
                            <option value="CC0 (Public Domain)">CC0 (Telif Hakkı Yok)</option>
                            <option value="Ticari">Ticari Lisans</option>
                            <option value="Sadece Kişisel Kullanım">Sadece Kişisel Kullanım</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label">Açıklama / Notlar</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Bu varlıkla ilgili eklemek istedikleriniz..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-success"><i class="fa-solid fa-save me-2"></i>Kaydet</button>
                    <a href="veriler.php" class="btn btn-secondary">İptal</a>
                </form>

            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>