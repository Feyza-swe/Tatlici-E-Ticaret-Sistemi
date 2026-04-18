<?php 
include 'inc/header.php'; 

// 1. URL'den gelen Sipariş ID'sini al
if (!isset($_GET['id'])) { header("Location: order_history.php"); exit; }
$siparis_id = $_GET['id'];
$kullanici_id = $_SESSION['kullanici_id'];

// 2. Güvenlik: Bu sipariş gerçekten bu kullanıcıya mı ait? (Veya Admin mi?)
$siparis_kontrol = $db->prepare("SELECT * FROM siparisler WHERE id = ?");
$siparis_kontrol->execute([$siparis_id]);
$siparis_ana = $siparis_kontrol->fetch(PDO::FETCH_ASSOC);

if (!$siparis_ana || ($siparis_ana['kullanici_id'] != $kullanici_id && $_SESSION['kullanici_rol'] > 3)) {
    header("Location: order_history.php?durum=yetkisiz");
    exit;
}

// 3. Siparişin içindeki ürünleri çek (siparis_urunler ve urunler tablosunu birleştiriyoruz)
$urunler_sor = $db->prepare("SELECT su.*, u.baslik, u.resim FROM siparis_urunler su 
                             INNER JOIN urunler u ON su.urun_id = u.id 
                             WHERE su.siparis_id = ?");
$urunler_sor->execute([$siparis_id]);
$urunler = $urunler_sor->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="container">
    <div class="text-center mb-40">
      <i class="fas fa-receipt icon-large text-primary"></i>
      <h2 class="section-title h2-large m-0" style="color:white;">Sipariş Detayı #<?php echo $siparis_id; ?></h2>
      <p class="muted mt-8">Sipariş Durumu: <strong><?php echo $siparis_ana['durum']; ?></strong></p>
    </div>

    <div class="stat-card p-24">
        <h4 class="text-dark-strong mb-20 border-bottom-light pb-12">Satın Alınan Ürünler</h4>

        <?php foreach($urunler as $urun): ?>
        <div class="flex items-center mb-20 pb-12" style="border-bottom: 1px solid #eee;">
            <img class="img-80" src="img/urunler/<?php echo $urun['resim']; ?>" alt="">
            <div class="flex-1 ml-16">
                <h4 class="text-dark-strong"><?php echo $urun['baslik']; ?></h4>
                <p class="small-muted">Adet: <?php echo $urun['adet']; ?> x <?php echo number_format($urun['fiyat'], 2, ',', '.'); ?> TL</p>
            </div>
            <div class="fw-700 text-primary">
                <?php echo number_format($urun['adet'] * $urun['fiyat'], 2, ',', '.'); ?> TL
            </div>
        </div>
        <?php endforeach; ?>

        <div class="text-right mt-20">
            <p class="muted">Genel Toplam</p>
            <strong style="font-size: 1.8rem; color: var(--primary);">
                <?php echo number_format($siparis_ana['toplam_tutar'], 2, ',', '.'); ?> TL
            </strong>
        </div>

        <div class="mt-24">
            <a href="order_history.php" class="btn-detail"><i class="fas fa-arrow-left"></i> Siparişlerime Dön</a>
        </div>
    </div>
</main>

<?php include 'inc/footer.php'; ?>