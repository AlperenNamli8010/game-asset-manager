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
