<?php
session_start();

// Madde 18: Log Yazma Fonksiyonu
function logger($db, $mesaj) {
    $ip = $_SERVER['REMOTE_ADDR']; // Kullanıcının IP adresi
    $sorgu = $db->prepare("INSERT INTO loglar SET hata_mesaji = ?, ip_adresi = ?");
    $sorgu->execute([$mesaj, $ip]);
}

$host = 'localhost';
$dbname = 'tatlici';
$user = 'root';
$pass = ''; 

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Madde 18: Kullanıcıya teknik detay gösterme, hatayı arka planda logla
    // Not: Bağlantı tamamen koptuysa log tablosuna yazamaz, bu yüzden dosyaya da yazılabilir.
    error_log("Veritabanı Hatası: " . $e->getMessage()); 
    echo "Sistemde teknik bir arıza oluştu. Lütfen daha sonra tekrar deneyiniz.";
    die();
}
?>