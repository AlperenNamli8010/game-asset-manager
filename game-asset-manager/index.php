<?php
require_once 'includes/header.php';
?>

<div class="px-4 py-5 my-5 text-center">
    <i class="fa-solid fa-gamepad text-primary mb-4" style="font-size: 5rem;"></i>
    <h1 class="display-5 fw-bold text-dark">Indie Game Asset Manager</h1>
    <div class="col-lg-6 mx-auto">
        <p class="lead mb-4 text-muted">
            Oyun geliştirme sürecinizde kullandığınız ses, 3D model, script, animasyon ve arayüz tasarımlarını tek bir merkezden düzenli bir şekilde yönetin.
        </p>
        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="veriler.php" class="btn btn-primary btn-lg px-4 gap-3"><i class="fa-solid fa-rocket me-2"></i>Kütüphaneme Git</a>
            <?php else: ?>
                <a href="register.php" class="btn btn-primary btn-lg px-4 gap-3"><i class="fa-solid fa-user-plus me-2"></i>Ücretsiz Kayıt Ol</a>
                <a href="login.php" class="btn btn-outline-secondary btn-lg px-4"><i class="fa-solid fa-right-to-bracket me-2"></i>Giriş Yap</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php 
require_once 'includes/footer.php'; 
?>