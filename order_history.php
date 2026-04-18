<?php 
// 1. Header'ı dahil et (İçinde baglan.php ve session_start() zaten var)
include 'inc/header.php'; 

// DİKKAT: Buradaki session_start(); satırı hata verdiği için sildik.

// Madde 9: Eğer giriş yapılmamışsa bu sayfayı görmesin
if (!isset($_SESSION['kullanici_id'])) {
    header("Location: login.php?durum=giris_yapiniz");
    exit;
}

// Madde 14: Bu kullanıcının siparişlerini veritabanından çekelim
$kullanici_id = $_SESSION['kullanici_id'];
$siparis_sor = $db->prepare("SELECT * FROM siparisler WHERE kullanici_id = ? ORDER BY id DESC");
$siparis_sor->execute([$kullanici_id]);
$siparisler = $siparis_sor->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="container pb-60">

    <div class="text-center mb-40">
      <i class="fas fa-box-open icon-large text-primary"></i>
      <h2 class="section-title h2-large m-0" style="color:white;">Siparişlerim</h2>
      <p class="muted mt-8">Tüm siparişlerinizi buradan takip edebilirsiniz</p>
    </div>

    <!-- Sipariş Listesi -->
    <div class="grid-gap-16">
      
      <?php if(count($siparisler) > 0): ?>
          
          <?php foreach($siparisler as $siparis): ?>
          <div class="stat-card p-24 mb-20">
            <div class="flex space-between align-start flex-wrap gap-16 mb-20">
              <div>
                <h3 class="m-0 text-dark-strong mb-8">
                    <i class="fas fa-receipt"></i> Sipariş #<?php echo $siparis['id']; ?>
                </h3>
                <p class="small-muted m-0"> 
                    <i class="fas fa-calendar"></i> <?php echo date('d.m.Y H:i', strtotime($siparis['tarih'])); ?>
                </p>
              </div>
              <div class="text-right">
                <div class="badge-success"> <i class="fas fa-check-circle"></i> <?php echo $siparis['durum']; ?></div>
                <div class="product-price-lg" style="font-size: 1.5rem; font-weight: 900; color: var(--primary);">
                    <?php echo number_format($siparis['toplam_tutar'], 2, ',', '.'); ?> TL
                </div>
              </div>
            </div>

            <div class="flex gap-12 flex-wrap">
              <a href="order_detail.php?id=<?php echo $siparis['id']; ?>" class="btn-detail" style="text-decoration:none;">Sipariş Detayı</a>
              <button class="btn-detail">Fatura İndir</button>
            </div>
          </div>
          <?php endforeach; ?>

      <?php else: ?>
          <!-- Sipariş Yoksa Gösterilecek Alan -->
          <div class="stat-card" style="padding:60px; text-align:center;">
            <i class="fas fa-box-open" style="font-size:5rem; color:var(--text-muted); opacity:0.3; margin-bottom:20px;"></i>
            <h3 style="color:var(--text-dark); margin:0 0 12px;">Henüz Siparişiniz Yok</h3>
            <p style="color:var(--text-muted); margin:0 0 24px;">Hemen alışverişe başlayın ve lezzetli ürünlerimizi keşfedin!</p>
            <a href="index.php" class="btn-cta">Alışverişe Başla</a>
          </div>
      <?php endif; ?>

    </div>
</main>

<?php 
// Footer'ı dahil et
include 'inc/footer.php'; 
?>