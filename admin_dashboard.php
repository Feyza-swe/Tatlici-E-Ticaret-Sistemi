<?php 
// 1. Veritabanı bağlantısını ve session_start()'ı dahil et (Madde 9)
require_once 'inc/baglan.php'; 

// 2. Yetki Kontrolü (Madde 7 & 9)
if (!isset($_SESSION['kullanici_id']) || !in_array($_SESSION['kullanici_rol'], [1, 2, 3])) {
    // Madde 18: Yetkisiz erişim denemesini logla
    logger($db, "Yetkisiz admin paneli erişim denemesi! Kullanıcı ID: " . ($_SESSION['kullanici_id'] ?? 'Giriş Yok'));
    header("Location: login.php?durum=yetkisiz_erisim");
    exit;
}

// 3. İstatistikleri Çekme (Madde 14)
$urun_sayisi = $db->query("SELECT COUNT(*) FROM urunler")->fetchColumn();
$kullanici_sayisi = $db->query("SELECT COUNT(*) FROM kullanicilar")->fetchColumn();
$siparis_sayisi = $db->query("SELECT COUNT(*) FROM siparisler")->fetchColumn();
$toplam_satis = $db->query("SELECT SUM(toplam_tutar) FROM siparisler WHERE durum='Tamamlandı'")->fetchColumn() ?? 0;

// 4. Ürünleri Listeleme (Dinamik)
$urunler = $db->query("SELECT u.*, k.kategori_adi FROM urunler u LEFT JOIN kategoriler k ON u.kategori_id = k.id ORDER BY u.id DESC")->fetchAll(PDO::FETCH_ASSOC);

// 5. Kategorileri Çekme
$kategoriler = $db->query("SELECT * FROM kategoriler")->fetchAll(PDO::FETCH_ASSOC);

// 6. Admin Bilgilerini Çek (Madde 8 için)
$adminsor = $db->prepare("SELECT * FROM kullanicilar WHERE id = ?");
$adminsor->execute([$_SESSION['kullanici_id']]);
$admincek = $adminsor->fetch(PDO::FETCH_ASSOC);

include 'inc/header.php'; 
?>

<main class="container">

    <div class="text-center mb-40">
      <i class="fas fa-chart-line icon-3rem text-primary"></i>
      <h2 class="section-title h2-large">Yönetim Paneli</h2>
      <p class="muted mt-8">Hoş geldin, <strong><?php echo $_SESSION['kullanici_ad_soyad']; ?></strong></p>
    </div>

    <!-- İstatistik Widget'ları (Madde 14) -->
    <section class="admin-grid mb-40">
      <div class="stat-card stat-card--primary">
        <i class="fas fa-lira-sign icon-3rem"></i>
        <h4 class="h4-compact">Toplam Satış</h4>
        <div class="stat-number-large"><?php echo number_format($toplam_satis, 2, ',', '.'); ?> TL</div>
        <p class="stat-sub">Tamamlanan siparişler</p>
      </div>
      <div class="stat-card stat-card--success">
        <i class="fas fa-shopping-bag icon-3rem"></i>
        <h4 class="h4-compact">Toplam Sipariş</h4>
        <div class="stat-number-large"><?php echo $siparis_sayisi; ?></div>
      </div>
      <div class="stat-card stat-card--secondary">
        <i class="fas fa-box icon-3rem"></i>
        <h4 class="h4-compact">Ürün Çeşidi</h4>
        <div class="stat-number-large"><?php echo $urun_sayisi; ?></div>
      </div>
      <div class="stat-card stat-card--accent">
        <i class="fas fa-users icon-3rem"></i>
        <h4 class="h4-compact">Kayıtlı Kullanıcı</h4>
        <div class="stat-number-large"><?php echo $kullanici_sayisi; ?></div>
      </div>
    </section>

    <div class="two-col-1-1_5">
        
        <!-- ÜRÜN EKLEME FORMU -->
        <div class="stat-card p-24">
          <h4 class="h4-compact text-dark-strong"><i class="fas fa-plus-circle"></i> Yeni Ürün Ekle</h4>
          <form action="islem.php" method="POST" enctype="multipart/form-data">
            <div class="form-control">
              <label>Ürün Başlığı</label>
              <input name="baslik" class="input" type="text" required>
            </div>
            <div class="form-control">
              <label>Kategori</label>
              <select name="kategori_id" class="input" required>
                <?php foreach($kategoriler as $k): ?>
                    <option value="<?php echo $k['id']; ?>"><?php echo $k['kategori_adi']; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-control">
              <label>Fiyat (TL)</label>
              <input name="fiyat" class="input" type="number" step="0.01" required>
            </div>
            <div class="form-control">
              <label>Ürün Görseli</label>
              <input name="resim" class="input" type="file" required>
            </div>
            <div class="form-control">
              <label>Açıklama</label>
              <textarea name="aciklama" class="input" rows="3" required></textarea>
            </div>
            <div class="form-control">
              <label>Stok</label>
              <input name="stok" class="input" type="number" value="10" required>
            </div>
            <button type="submit" name="urun_ekle" class="btn-cta btn-full">Kaydet</button>
          </form>
        </div>

        <!-- ÜRÜN LİSTESİ VE TOPLU SİLME (Madde 16) -->
        <div class="stat-card p-24">
          <!-- Toplu Silme Formu Başlangıcı -->
          <form action="islem.php" method="POST">
              <div class="flex space-between mb-20 items-center">
                <h4 class="h4-compact text-dark-strong m-0"><i class="fas fa-list"></i> Ürün Listesi (<?php echo count($urunler); ?>)</h4>
                <button type="submit" name="toplu_sil" class="btn-small btn-danger" onclick="return confirm('Seçili ürünleri silmek istediğinize emin misiniz?')">
                    <i class="fas fa-trash-alt"></i> Seçilenleri Sil
                </button>
              </div>

              <div class="overflow-y-auto" style="max-height: 600px;">
                <?php foreach($urunler as $urun): ?>
                <div class="flex items-center box-muted mb-12">
                  <!-- Checkbox (Çoklu Seçim İçin) -->
                  <input type="checkbox" name="silinecek_id[]" value="<?php echo $urun['id']; ?>" style="width:20px; height:20px; margin-right:15px; cursor:pointer;">
                  
                  <img class="img-80" src="img/urunler/<?php echo $urun['resim']; ?>" onerror="this.src='https://via.placeholder.com/80';">
                  <div class="flex-1 ml-16">
                    <h4 class="text-dark-strong"><?php echo $urun['baslik']; ?></h4>
                    <p class="small-muted mt-4"><?php echo $urun['kategori_adi']; ?> • <?php echo $urun['fiyat']; ?> TL</p>
                  </div>
                  <div class="flex gap-4">
                    <a href="islem.php?urun_sil=ok&id=<?php echo $urun['id']; ?>" class="btn-small btn-compact btn-danger" onclick="return confirm('Silinsin mi?')"><i class="fas fa-trash"></i></a>
                  </div>
                </div>
                <?php endforeach; ?>
              </div>
          </form>
        </div>
    </div>

    <!-- KENDİ BİLGİLERİNİ GÜNCELLEME (Madde 8) -->
    <section class="mt-40">
        <h3 class="section-title"><i class="fas fa-user-edit"></i> Profil Bilgilerimi Güncelle</h3>
        <div class="stat-card p-30">
            <form action="islem.php" method="POST">
                <div class="grid-2">
                    <div class="form-control">
                        <label>Adınız</label>
                        <input name="ad" class="input" type="text" value="<?php echo $admincek['ad']; ?>" required>
                    </div>
                    <div class="form-control">
                        <label>Soyadınız</label>
                        <input name="soyad" class="input" type="text" value="<?php echo $admincek['soyad']; ?>" required>
                    </div>
                </div>
                <div class="form-control">
                    <label>E-posta Adresiniz</label>
                    <input name="eposta" class="input" type="email" value="<?php echo $admincek['eposta']; ?>" required>
                </div>
                <div class="form-control">
                    <label>Yeni Şifre (Değiştirmek istemiyorsanız boş bırakın)</label>
                    <input name="yeni_sifre" class="input" type="password" placeholder="******">
                </div>
                <button type="submit" name="profil_guncelle" class="btn-cta">Bilgilerimi Güncelle</button>
            </form>
        </div>
    </section>

</main>

<?php include 'inc/footer.php'; ?>