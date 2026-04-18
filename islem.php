<?php
// 1. Veritabanı bağlantısını dahil et (Madde 9)
require_once 'inc/baglan.php';

// ==========================================
// KULLANICI KAYIT İŞLEMİ (Madde 5)
// ==========================================
if (isset($_POST['kayitol'])) {
    $ad = $_POST['ad'];
    $soyad = $_POST['soyad'];
    $eposta = $_POST['eposta'];
    $sifre = $_POST['sifre'];
    $sifre_tekrar = $_POST['sifre_tekrar'];
    $rol_id = 4; // Varsayılan: Müşteri

    if ($sifre != $sifre_tekrar) {
        header("Location: register.php?durum=sifre_uyusmuyor");
        exit;
    }

    // Madde 3: Prepared Statements
    $kullanicisor = $db->prepare("SELECT * FROM kullanicilar WHERE eposta = ?");
    $kullanicisor->execute([$eposta]);
    if ($kullanicisor->rowCount() > 0) {
        header("Location: register.php?durum=mukerrer_kayit");
        exit;
    }

    // Madde 5: Password Hashing
    $hashed_password = password_hash($sifre, PASSWORD_BCRYPT);

    $kaydet = $db->prepare("INSERT INTO kullanicilar SET ad=?, soyad=?, eposta=?, sifre=?, rol_id=?");
    $sonuc = $kaydet->execute([$ad, $soyad, $eposta, $hashed_password, $rol_id]);

    if ($sonuc) {
        header("Location: login.php?durum=kayit_basarili");
    } else {
        header("Location: register.php?durum=no");
    }
    exit;
}

// ==========================================
// KULLANICI GİRİŞ İŞLEMİ (Madde 7 & 9)
// ==========================================
if (isset($_POST['girisyap'])) {
    $eposta = $_POST['eposta'];
    $sifre = $_POST['sifre'];

    $sorgu = $db->prepare("SELECT * FROM kullanicilar WHERE eposta = ?");
    $sorgu->execute([$eposta]);
    $kullanici = $sorgu->fetch(PDO::FETCH_ASSOC);

    if ($kullanici && password_verify($sifre, $kullanici['sifre'])) {
        $_SESSION['kullanici_id'] = $kullanici['id'];
        $_SESSION['kullanici_ad_soyad'] = $kullanici['ad'] . " " . $kullanici['soyad'];
        $_SESSION['kullanici_rol'] = $kullanici['rol_id'];

        if ($kullanici['rol_id'] <= 3) {
            header("Location: admin_dashboard.php?durum=hosgeldin");
        } else {
            header("Location: index.php?durum=giris_basarili");
        }
    } else {
        header("Location: login.php?durum=giris_hatali");
    }
    exit;
}

// ==========================================
// ÜRÜN EKLEME İŞLEMİ (Madde 10 & 11)
// ==========================================
if (isset($_POST['urun_ekle'])) {
    $baslik = $_POST['baslik'];
    $kategori_id = $_POST['kategori_id'];
    $fiyat = $_POST['fiyat'];
    $aciklama = $_POST['aciklama'];
    $stok = $_POST['stok'];

    // Resim Yükleme
    $dizin = 'img/urunler/';
    $benzersizad = uniqid() . "-" . $_FILES['resim']['name'];
    $yol = $dizin . $benzersizad;

    if (move_uploaded_file($_FILES['resim']['tmp_name'], $yol)) {
        $kaydet = $db->prepare("INSERT INTO urunler SET baslik=?, kategori_id=?, fiyat=?, aciklama=?, stok=?, resim=?");
        $sonuc = $kaydet->execute([$baslik, $kategori_id, $fiyat, $aciklama, $stok, $benzersizad]);
        
        header("Location: admin_dashboard.php?durum=" . ($sonuc ? "ok" : "no"));
    } else {
        header("Location: admin_dashboard.php?durum=resim_hatasi");
    }
    exit;
}

// ==========================================
// TEKLİ ÜRÜN SİLME (Madde 16)
// ==========================================
if (isset($_GET['urun_sil']) && $_GET['urun_sil'] == "ok") {
    $id = $_GET['id'];
    
    // Resmi klasörden sil
    $resimsor = $db->prepare("SELECT resim FROM urunler WHERE id = ?");
    $resimsor->execute([$id]);
    $resimcek = $resimsor->fetch(PDO::FETCH_ASSOC);
    if($resimcek) { @unlink("img/urunler/".$resimcek['resim']); }

    $sil = $db->prepare("DELETE FROM urunler WHERE id = ?");
    $sonuc = $sil->execute([$id]);
    header("Location: admin_dashboard.php?durum=" . ($sonuc ? "ok" : "no"));
    exit;
}

// ==========================================
// TOPLU ÜRÜN SİLME (Madde 16)
// ==========================================
if (isset($_POST['toplu_sil'])) {
    if (!empty($_POST['silinecek_id'])) {
        $id_listesi = $_POST['silinecek_id'];
        $yer_tutucu = str_repeat('?,', count($id_listesi) - 1) . '?';
        
        $sil = $db->prepare("DELETE FROM urunler WHERE id IN ($yer_tutucu)");
        $sonuc = $sil->execute($id_listesi);
        header("Location: admin_dashboard.php?durum=" . ($sonuc ? "ok" : "no"));
    } else {
        header("Location: admin_dashboard.php?durum=secim_yapilmadi");
    }
    exit;
}

// ==========================================
// SİPARİŞ VERME İŞLEMİ (Madde 2 & 14)
// ==========================================
if (isset($_POST['siparis_ver'])) {
    if (!isset($_SESSION['kullanici_id'])) { header("Location: login.php"); exit; }

    $kullanici_id = $_SESSION['kullanici_id'];
    $toplam_tutar = $_POST['toplam_tutar'];

    // Sipariş Ana Kaydı
    $siparis = $db->prepare("INSERT INTO siparisler SET kullanici_id = ?, toplam_tutar = ?");
    $siparis->execute([$kullanici_id, $toplam_tutar]);
    $siparis_id = $db->lastInsertId();

    // Ürünleri Aktar
    foreach ($_SESSION['sepet'] as $urun_id => $detay) {
        $urun_kaydet = $db->prepare("INSERT INTO siparis_urunler SET siparis_id=?, urun_id=?, adet=?, fiyat=?");
        $urun_kaydet->execute([$siparis_id, $urun_id, $detay['adet'], $detay['fiyat']]);
    }

    unset($_SESSION['sepet']);
    header("Location: order_history.php?durum=siparis_alindi");
    exit;
}

// ==========================================
// ADMİN PROFİL GÜNCELLEME (Madde 8)
// ==========================================
if (isset($_POST['profil_guncelle'])) {
    $id = $_SESSION['kullanici_id'];
    $ad = $_POST['ad']; $soyad = $_POST['soyad']; $eposta = $_POST['eposta'];

    if (!empty($_POST['yeni_sifre'])) {
        $sifre = password_hash($_POST['yeni_sifre'], PASSWORD_BCRYPT);
        $guncelle = $db->prepare("UPDATE kullanicilar SET ad=?, soyad=?, eposta=?, sifre=? WHERE id=?");
        $sonuc = $guncelle->execute([$ad, $soyad, $eposta, $sifre, $id]);
    } else {
        $guncelle = $db->prepare("UPDATE kullanicilar SET ad=?, soyad=?, eposta=? WHERE id=?");
        $sonuc = $guncelle->execute([$ad, $soyad, $eposta, $id]);
    }

    if ($sonuc) { $_SESSION['kullanici_ad_soyad'] = $ad . " " . $soyad; }
    header("Location: admin_dashboard.php?durum=" . ($sonuc ? "ok" : "no"));
    exit;
}

// ==========================================
// YORUM YAPMA İŞLEMİ (Madde 19)
// ==========================================
if (isset($_POST['yorum_yap'])) {
    if (!isset($_SESSION['kullanici_id'])) { header("Location: login.php"); exit; }

    $urun_id = $_POST['urun_id'];
    $kullanici_id = $_SESSION['kullanici_id'];
    $puan = $_POST['puan'];
    $yorum = $_POST['yorum'];

    $kaydet = $db->prepare("INSERT INTO yorumlar SET urun_id=?, kullanici_id=?, puan=?, yorum=?");
    $sonuc = $kaydet->execute([$urun_id, $kullanici_id, $puan, $yorum]);

    header("Location: product_detail.php?id=$urun_id&durum=" . ($sonuc ? "ok" : "no"));
    exit;
}
?>