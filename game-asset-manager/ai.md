Konu Seçimi ve Veritabanı Tasarımı
İnternette kopyası çok bulunmayan, hem hocanın listesindeki özgün maddelere yakın hem de üzerinde çalışması keyifli bir konu seçmeliyiz.

Sana özel, kurallara tamamen uyan ve geliştirilmesi keyifli 3 konu önerisi:

Veteriner Eczane Stok ve Reçete Takip Sistemi: (Veterinerlerin kliniklerinde bulunan ilaçları, son kullanma tarihlerini, stok miktarlarını ve hangi hayvana hangi ilacın yazıldığını takip ettiği bir sistem).

Yerel Tohum ve Takas Bankası Uygulaması: (Geleneksel/organik tarımla uğraşanların ellerindeki ata tohumlarını sisteme girdiği, miktarını, yetiştirme koşullarını yazdığı ve diğer üyelerle takas talebi oluşturabildiği bir platform).

Bağımsız Oyun Geliştiricileri (Indie Game) Varlık (Asset) Yönetimi: (Küçük oyun ekiplerinin projelerinde kullandıkları ses, 3D model, script veya görselleri, formatları ve lisans tipleriyle birlikte listeleyip yönettiği bir iç sistem).

Soru: Bu konulardan hangisi daha çok ilgini çeker? Ya da aklında tamamen farklı, kendine ait spesifik bir fikir var mı? Konuyu netleştirelim, veritabanı tablolarını (users ve bilgiler tablosu) ona göre tasarlayalım.

------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Üst Kısım ve Menü Şablonu (includes/header.php)
Proje kurallarında oturum yönetimi (session) istendiği ve arayüzün tamamen stillendirilmiş olması gerektiği belirtilmişti. header.php dosyasının en başına session_start() ekleyerek tüm projede oturum kontrolünü tek noktadan başlatmış olacağız. Ayrıca giriş yapmış kullanıcı ile yapmamış kullanıcıya farklı menüler göstereceğiz.

includes klasörünün içinde header.php adında bir dosya oluştur ve içine şu kodları yapıştır:

PHP
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indie Asset Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .navbar-brand { font-weight: bold; letter-spacing: 1px; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow">
    <div class="container">
        <a class="navbar-brand" href="index.php"><i class="fa-solid fa-gamepad me-2"></i>AssetManager</a>
        <button class="navbar-expand-lg navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="veriler.php"><i class="fa-solid fa-box-open me-1"></i> Varlıklarım</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="veri-ekle.php"><i class="fa-solid fa-plus me-1"></i> Yeni Ekle</a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-outline-danger btn-sm mt-1" href="logout.php"><i class="fa-solid fa-right-from-bracket me-1"></i> Çıkış Yap</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php"><i class="fa-solid fa-right-to-bracket me-1"></i> Giriş Yap</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php"><i class="fa-solid fa-user-plus me-1"></i> Kayıt Ol</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container">

----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
3. Alt Kısım Şablonu (includes/footer.php)
Açtığımız HTML etiketlerini kapatacağımız ve Bootstrap'in JavaScript kütüphanesini ekleyeceğimiz yer burası.

includes klasörünün içinde footer.php adında bir dosya oluştur ve içine şu kodları yapıştır:

PHP
</div> <footer class="footer mt-5 py-3 bg-white border-top text-center text-muted">
    <div class="container">
        <span>&copy; <?php echo date('Y'); ?> - Indie Game Asset Manager - Tüm Hakları Saklıdır.</span>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
-----------------------------------------------------------------
1. Veritabanı Bağlantı Dosyası (config/db.php)
Bu dosya, PHP'nin veritabanıyla konuşmasını sağlayacak. Güvenli ve modern bir yöntem olan PDO (PHP Data Objects) kullanacağız.

config klasörünün içinde db.php adında bir dosya oluştur ve içine şu kodları yapıştır:

PHP
<?php
$host = "localhost";
$db_name = "game_asset_db";
$username = "root";
$password = ""; // XAMPP'ta varsayılan olarak şifre boştur

try {
    $db = new PDO("mysql:host={$host};dbname={$db_name};charset=utf8mb4", $username, $password);
    // Hata ayıklama modunu aktif ediyoruz
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Varsayılan veri getirme şeklini ilişkisel dizi (associative array) yapıyoruz
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $exception) {
    die("Veritabanı bağlantı hatası: " . $exception->getMessage());
}
?>
------------------------------------------------------------------------------------------------------------------
bana verilen hosting ler bunlar bunlarla ne yapmam gerekiyor tam olarak

Here are your hosting informations:

Personal

Secret Code:****************************

Student Number: ***********************

FTP

IP/Host: **********************

FTP Port: **********************************

Linux Username: ******************

Linux Password: *********************

Your website: http://95.130.171.20/~st23360859074

MariaDB (MySQL)

Database User:*******************

Database Password: *************

Database Name: *******************************

phpMyAdmin: http://95.130.171.20/phpmyadmin 

Bu bilgiler, projeni canlıya almak için ihtiyacın olan her şey! Sana cPanel gibi tarayıcı üzerinden girilen bir panel yerine, tam bir yazılımcı gibi kullanman için doğrudan FTP (Dosya Transfer Protokolü) erişimi verilmiş.

İşte bu bilgileri kullanarak projeni canlıya alacağın 3 kritik adım:

1. Aşama: Veritabanını Canlıya Aktarma (phpMyAdmin)
Önce bilgisayarındaki yerel veritabanını üniversitenin sunucusuna taşıyacağız.

Bilgisayarında XAMPP açıkken http://localhost/phpmyadmin adresine gir. Soldan game_asset_db veritabanını seçip üst menüden Dışa Aktar (Export) diyerek .sql dosyasını bilgisayarına indir.

Sana verilen canlı veritabanı adresine tıkla: http://95.130.171.20/phpmyadmin

Giriş ekranına sana verilen veritabanı kullanıcı adı ve şifresini yaz:

Kullanıcı Adı: dbusr23360859074

Şifre: CO03UeioFVTc

Giriş yaptıktan sonra sol tarafta sana tahsis edilen dbstorage23360859074 isimli veritabanını göreceksin. Ona tıkla.

Üst menüden İçe Aktar (Import) butonuna bas, bilgisayarına indirdiğin .sql dosyasını seçip yükle. Tabloların başarıyla sunucuya taşındı!
----------------------------------------------------------------------------------------------------------------------------------------------------------------------------

Dosyaları İnternete Yükleme (FTP)
FTP (File Transfer Protocol) bilgileri, kod dosyalarını sunucuya atman içindir. Bunun için ücretsiz ve güvenilir bir FTP programı olan FileZilla'yı kullanacağız.

İnternetten FileZilla programını indirip bilgisayarına kur.

Programı açtığında en üstte bir hızlı bağlanma çubuğu göreceksin. Oraya şu bilgilerini gir:

Sunucu (Host): ***************************

Kullanıcı Adı:*******************

Parola:****************************

Kapı (Port): *************************

Hızlı Bağlan butonuna bas. Program üniversite sunucusuna bağlanacak.

Programın sağ alt penceresinde sunucudaki klasörleri göreceksin. Orada public_html (veya www) isimli bir klasör vardır, onun içine çift tıklayıp gir.

Programın sol alt penceresinden ise kendi bilgisayarındaki projeyi bul.

Klasörün içindeki tüm dosyaları (index.php, config klasörü, includes klasörü, AI.md vs.) seç ve sürükleyerek sağ taraftaki public_html klasörünün içine bırak.

Dosya aktarımı (aşağıdaki çubukta yeşil olarak ilerler) bittiğinde işlemin tamamdır!

Artık kendi sitene http://95.130.171.20/~st23360859074 adresinden girebilir, projeni test edebilir ve videonu rahatça çekebilirsin.
------------------------------------------------------------------------------------------------------------------------------------
login.php yi yukarıya yazınca http://localhost/game-asset-manager/veriler.php buraya atıyor orada da Not Found

The requested URL was not found on this server.

Apache/2.4.58 (Win64) OpenSSL/3.1.3 PHP/8.2.12 Server at localhost Port 80 var

Şimdi yapman gereken tek şey şu:
Klasöründe veri-ekle.php kalsın, ona hiç dokunma.

Klasörün içine veriler.php adında YENİ bir dosya daha oluştur.

Aşağıdaki kodları kopyala ve bu yeni oluşturduğun veriler.php dosyasının içine yapıştırıp kaydet (Ctrl + S):


PHP
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
Bu dosyayı oluşturup kodu içine yapıştırdıktan sonra tarayıcında o 404 hatası veren sayfayı yenile. Sorun tamamen çözülmüş olacak ve tablo karşına gelecek!
