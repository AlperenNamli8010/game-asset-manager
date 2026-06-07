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

Secret Code: CjX05GTeQmhI

Student Number: 23360859074

FTP

IP/Host: 95.130.171.20

FTP Port: 21

Linux Username: st23360859074

Linux Password: bZOhn93injOc

Your website: http://95.130.171.20/~st23360859074

MariaDB (MySQL)

Database User: dbusr23360859074

Database Password: CO03UeioFVTc

Database Name: dbstorage23360859074

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
