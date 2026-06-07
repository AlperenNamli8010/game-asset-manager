<?php
require_once 'config/db.php';
session_start();

// Güvenlik: Giriş yapılmamışsa yönlendir
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // Güvenlik: Sadece giriş yapan kullanıcının kendi verisini silmesine izin veriyoruz
    $stmt = $db->prepare("DELETE FROM assets WHERE id = :id AND user_id = :user_id");
    $stmt->execute(['id' => $id, 'user_id' => $user_id]);
}

// Silme işleminden sonra hemen tabloya geri dön
header("Location: veriler.php");
exit;
?>