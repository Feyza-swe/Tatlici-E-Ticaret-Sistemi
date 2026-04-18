<?php 
include 'inc/header.php'; 

// 1. URL'den gelen ID'yi al ve ürünü çek (Madde 10)
if (!isset($_GET['id'])) { header("Location: index.php"); exit; }

$urunsor = $db->prepare("SELECT u.*, k.kategori_adi FROM urunler u 
                         LEFT JOIN kategoriler k ON u.kategori_id = k.id 
                         WHERE u.id = ? AND u.aktif_mi = 1");
$urunsor->execute([$_GET['id']]);
$urun = $urunsor->fetch(PDO::FETCH_ASSOC);

if (!$urun) { header("Location: index.php"); exit; }

// 2. Bu ürüne ait onaylı yorumları çek
$yorumsor = $db->prepare("SELECT y.*, k.ad, k.soyad FROM yorumlar y 
                          INNER JOIN kullanicilar k ON y.kullanici_id = k.id 
                          WHERE y.urun_id = ? AND y.aktif_mi = 1 
                          ORDER BY y.id DESC");
$yorumsor->execute([$urun['id']]);
$yorumlar = $yorumsor->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="container main-large">

    <div class="stat-card p-30">
      <div class="grid-2 gap-40 mb-40">
        
        <!-- Ürün Görseli -->
        <div>
          <img class="img-main" src="img/urunler/<?php echo $urun['resim']; ?>" alt="<?php echo $urun['baslik']; ?>">
        </div>

        <!-- Ürün Bilgileri -->
        <div>
          <div class="badge-success">
            <i class="fas fa-check-circle"></i> Stokta Var
          </div>

          <h2 class="text-dark-strong mb-12"><?php echo $urun['baslik']; ?></h2>
          <p class="small-muted mb-8">Kategori: <strong><?php echo $urun['kategori_adi']; ?></strong></p>

          <p class="product-desc mb-16"><?php echo $urun['aciklama']; ?></p>

          <div class="product-price-large"><?php echo number_format($urun['fiyat'], 2, ',', '.'); ?> TL</div>

          <!-- Miktar Seçimi (Opsiyonel) -->
          <!-- Ürün Detay Sayfası (product_detail.php) içindeki ilgili kısım -->
<form action="sepet_islem.php" method="POST">
    <!-- Ürünün ID'sini gizli olarak gönderiyoruz -->
    <input type="hidden" name="urun_id" value="<?php echo $urun['id']; ?>">
    
    <div class="flex items-center gap-16 mt-20">
        <label class="fw-700 text-dark-strong">Miktar:</label>
        <div class="flex items-center gap-8">
            <!-- input adını "adet" yapıyoruz -->
            <input type="number" name="adet" id="quantityInput" value="1" min="1" class="input-compact">
        </div>
    </div>

    <div class="flex gap-12 mt-24">
        <!-- Butonun tipini "submit" ve adını "sepete_ekle" yapıyoruz -->
        <button type="submit" name="sepete_ekle" class="btn-add-to-cart flex-1">
            <i class="fas fa-shopping-basket"></i> Sepete Ekle
        </button>
    </div>
</form>
        </div>
      </div>

      <!-- Yorumlar Bölümü -->
      <div class="border-top-light">
        <h3 class="mb-20 text-dark-strong"><i class="fas fa-comments"></i> Müşteri Yorumları (<?php echo count($yorumlar); ?>)</h3>
        
        <!-- Yorum Formu (Sadece giriş yapanlar görebilir) -->
        <?php if(isset($_SESSION['kullanici_id'])): ?>
            <div class="box-muted p-24 mb-24">
              <h4 class="mb-16 text-dark-strong">Yorumunuzu Paylaşın</h4>
              <form action="islem.php" method="POST">
                <input type="hidden" name="urun_id" value="<?php echo $urun['id']; ?>">
                
                <div class="form-control">
                  <label>Puanınız</label>
                  <select class="input" name="puan" required>
                    <option value="5">⭐⭐⭐⭐⭐ Mükemmel</option>
                    <option value="4">⭐⭐⭐⭐ Çok İyi</option>
                    <option value="3">⭐⭐⭐ Orta</option>
                    <option value="2">⭐⭐ Kötü</option>
                    <option value="1">⭐ Çok Kötü</option>
                  </select>
                </div>

                <div class="form-control">
                  <label>Yorumunuz</label>
                  <textarea class="input" rows="4" name="yorum" placeholder="Lezzet hakkında ne düşünüyorsunuz?" required></textarea>
                </div>

                <button type="submit" name="yorum_yap" class="btn-cta">Gönder</button>
              </form>
            </div>
        <?php else: ?>
            <div class="box-muted p-16 mb-24">
                <p class="muted">Yorum yapabilmek için lütfen <a href="login.php" class="link-strong">giriş yapın</a>.</p>
            </div>
        <?php endif; ?>

        <!-- Yorumlar Listesi -->
        <div class="grid-gap-16">
          <?php foreach($yorumlar as $y): ?>
          <div class="box-white p-16 mb-12">
            <div class="flex space-between align-start mb-8">
              <div>
                <strong class="text-dark-strong"><?php echo $y['ad'] . " " . $y['soyad']; ?></strong>
                <div class="small-muted"><?php echo date('d.m.Y', strtotime($y['tarih'])); ?></div>
              </div>
              <div class="text-success"><?php echo str_repeat('⭐', $y['puan']); ?></div>
            </div>
            <p class="text-dark-strong"><?php echo nl2br($y['yorum']); ?></p>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
</main>

<?php include 'inc/footer.php'; ?>