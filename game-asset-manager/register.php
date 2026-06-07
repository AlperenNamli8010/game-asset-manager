<?php
// Veritabanı bağlantısını ve üst tasarımı sayfaya dahil ediyoruz
require_once 'config/db.php';
require_once 'includes/header.php';

// Eğer kullanıcı zaten giriş yapmışsa, onu kayıt sayfasından veriler sayfasına yönlendiriyoruz
if (isset($_SESSION['user_id'])) {
    header("Location: veriler.php");
    exit;
}

$mesaj = '';
$mesaj_tur = '';

// Form gönderildiğinde çalışacak PHP kodları
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Boş alan kontrolü
    if (empty($username) || empty($email) || empty($password)) {
        $mesaj = "Lütfen tüm alanları doldurun.";
        $mesaj_tur = "danger";
    } else {
        // Kullanıcı adı veya e-posta daha önce alınmış mı kontrolü
        $stmt = $db->prepare("SELECT id FROM users WHERE username = :username OR email = :email");
        $stmt->execute(['username' => $username, 'email' => $email]);
        
        if ($stmt->rowCount() > 0) {
            $mesaj = "Bu kullanıcı adı veya e-posta adresi zaten kullanılıyor.";
            $mesaj_tur = "warning";
        } else {
            // PROJE KURALI: Şifreyi hash'liyoruz (Güvenlik için)
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Veritabanına yeni kullanıcıyı ekliyoruz
            $insert_stmt = $db->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
            $basarili = $insert_stmt->execute([
                'username' => $username,
                'email' => $email,
                'password' => $hashed_password
            ]);

            if ($basarili) {
                $mesaj = "Kayıt başarıyla tamamlandı! Şimdi giriş yapabilirsiniz.";
                $mesaj_tur = "success";
            } else {
                $mesaj = "Kayıt sırasında bir hata oluştu. Lütfen tekrar deneyin.";
                $mesaj_tur = "danger";
            }
        }
    }
}
?>

<div class="row justify-content-center mt-5">
    <div class="col-md-6 col-lg-4">
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white text-center py-3">
                <h4 class="mb-0"><i class="fa-solid fa-user-plus me-2"></i>Kayıt Ol</h4>
            </div>
            <div class="card-body p-4">
                
                <?php if (!empty($mesaj)): ?>
                    <div class="alert alert-<?php echo $mesaj_tur; ?> alert-dismissible fade show" role="alert">
                        <?php echo $mesaj; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form action="register.php" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Kullanıcı Adı</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-posta Adresi</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label">Şifre</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-check me-2"></i>Hesap Oluştur</button>
                    </div>
                </form>
                
            </div>
            <div class="card-footer text-center bg-white py-3">
                <small>Zaten hesabın var mı? <a href="login.php" class="text-decoration-none">Giriş Yap</a></small>
            </div>
        </div>
    </div>
</div>

<?php 
// Alt tasarımı ve JS dosyalarını sayfaya dahil ediyoruz
require_once 'includes/footer.php'; 
?>