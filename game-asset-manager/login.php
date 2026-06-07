<?php
require_once 'config/db.php';
require_once 'includes/header.php';

// Kullanıcı zaten giriş yapmışsa direkt ana panele yönlendir
if (isset($_SESSION['user_id'])) {
    header("Location: veriler.php");
    exit;
}

$mesaj = '';
$mesaj_tur = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $mesaj = "Lütfen kullanıcı adı ve şifrenizi girin.";
        $mesaj_tur = "danger";
    } else {
        // Kullanıcıyı veritabanında arıyoruz
        $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        // Kullanıcı bulunduysa ve şifre eşleşiyorsa (PROJE KURALI: password_verify kullanımı)
        if ($user && password_verify($password, $user['password'])) {
            
            // Oturum (session) değişkenlerini atıyoruz
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            
            // Başarılı giriş sonrası veriler sayfasına yönlendir
            header("Location: veriler.php");
            exit;
            
        } else {
            $mesaj = "Hatalı kullanıcı adı veya şifre!";
            $mesaj_tur = "danger";
        }
    }
}
?>

<div class="row justify-content-center mt-5">
    <div class="col-md-6 col-lg-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white text-center py-3">
                <h4 class="mb-0"><i class="fa-solid fa-right-to-bracket me-2"></i>Giriş Yap</h4>
            </div>
            <div class="card-body p-4">
                
                <?php if (!empty($mesaj)): ?>
                    <div class="alert alert-<?php echo $mesaj_tur; ?> alert-dismissible fade show" role="alert">
                        <?php echo $mesaj; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form action="login.php" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Kullanıcı Adı</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label">Şifre</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-arrow-right-to-bracket me-2"></i>Giriş Yap</button>
                    </div>
                </form>
                
            </div>
            <div class="card-footer text-center bg-white py-3">
                <small>Hesabın yok mu? <a href="register.php" class="text-decoration-none">Hemen Kayıt Ol</a></small>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>