<?php
// 1. Veritabanı bağlantısını dahil et (Madde 9: session_start() bunun içindedir)
require_once 'inc/baglan.php';

// ==========================================
// SENARYO 1: ANA SAYFADAN HIZLI EKLEME (GET Metodu)
// index.php içindeki linke tıklandığında çalışır.
// ==========================================
if (isset($_GET['islem']) && $_GET['islem'] == "hizli_ekle") {
    
    $id = (int)$_GET['id']; // ID'yi sayıya çevirerek güvenliği artırıyoruz
    $adet = 1; // Ana sayfadan eklemede varsayılan her zaman 1'dir.

    // Madde 3: Prepared Statements ile ürün bilgilerini doğrula
    $urunsor = $db->prepare("SELECT * FROM urunler WHERE id = ? AND aktif_mi = 1");
    $urunsor->execute([$id]);
    $urun = $urunsor->fetch(PDO::FETCH_ASSOC);

    if ($urun) {
        // Sepet dizisi yoksa oluştur
        if (!isset($_SESSION['sepet'])) { $_SESSION['sepet'] = []; }

        // Eğer ürün zaten sepette varsa adedi 1 artır
        if (isset($_SESSION['sepet'][$id])) {
            $_SESSION['sepet'][$id]['adet'] += $adet;
        } else {
            // Yoksa yeni ürün olarak ekle
            $_SESSION['sepet'][$id] = [
                'ad' => $urun['baslik'],
                'fiyat' => $urun['fiyat'],
                'adet' => $adet,
                'resim' => $urun['resim']
            ];
        }
        // İşlem bitince sepet sayfasına git
        header("Location: cart.php?durum=eklendi");
        exit;
    } else {
        header("Location: index.php?durum=no");
        exit;
    }
}

// ==========================================
// SENARYO 2: ÜRÜN DETAYDAN ADETLİ EKLEME (POST Metodu)
// product_detail.php içindeki form gönderildiğinde çalışır.
// ==========================================
if (isset($_POST['sepete_ekle'])) {
    
    $id = (int)$_POST['urun_id'];
    $adet = (int)$_POST['adet']; // Kullanıcının seçtiği miktar (Örn: 5 adet)

    // Madde 3: Prepared Statements
    $urunsor = $db->prepare("SELECT * FROM urunler WHERE id = ? AND aktif_mi = 1");
    $urunsor->execute([$id]);
    $urun = $urunsor->fetch(PDO::FETCH_ASSOC);

    if ($urun) {
        if (!isset($_SESSION['sepet'])) { $_SESSION['sepet'] = []; }

        if (isset($_SESSION['sepet'][$id])) {
            // Sepette zaten varsa seçilen miktar kadar artır
            $_SESSION['sepet'][$id]['adet'] += $adet;
        } else {
            $_SESSION['sepet'][$id] = [
                'ad' => $urun['baslik'],
                'fiyat' => $urun['fiyat'],
                'adet' => $adet,
                'resim' => $urun['resim']
            ];
        }
        header("Location: cart.php?durum=eklendi");
        exit;
    } else {
        header("Location: index.php?durum=no");
        exit;
    }
}

// ==========================================
// SENARYO 3: SEPETTEN ÜRÜN SİLME (GET Metodu)
// cart.php içindeki çöp kutusu ikonuna tıklandığında çalışır.
// ==========================================
if (isset($_GET['sil']) && $_GET['sil'] == "ok") {
    
    $id = (int)$_GET['id'];

    // PHP'nin unset fonksiyonu ile o ID'ye ait sepet verisini siliyoruz
    if (isset($_SESSION['sepet'][$id])) {
        unset($_SESSION['sepet'][$id]);
        header("Location: cart.php?durum=silindi");
        exit;
    } else {
        header("Location: cart.php?durum=no");
        exit;
    }
}

// Eğer bu dosyaya yetkisiz veya boş bir şekilde erişilirse ana sayfaya at
header("Location: index.php");
exit;
?>