<?php 
// 1. Header'ı dahil et (İçinde baglan.php, ayarlar ve kategori çekme işlemleri var)
include 'inc/header.php'; 

// ==========================================
// Madde 15: Filtreleme ve Arama Mantığı
// ==========================================
if (isset($_GET['kategori'])) {
    // Belirli bir kategoriye tıklandıysa (Örn: Sütlü Tatlılar)
    $kategori_id = $_GET['kategori'];
    $urunsor = $db->prepare("SELECT * FROM urunler WHERE kategori_id = ? AND aktif_mi = 1 ORDER BY id DESC");
    $urunsor->execute([$kategori_id]);
    
    // Kategori adını başlıkta göstermek için çekelim
    $k_ad_sor = $db->prepare("SELECT kategori_adi FROM kategoriler WHERE id = ?");
    $k_ad_sor->execute([$kategori_id]);
    $k_adi = $k_ad_sor->fetchColumn();
    $baslik_metni = "✨ " . $k_adi;

} elseif (isset($_GET['ara'])) {
    // Arama kutusuna bir şey yazıldıysa (Madde 3: Prepared Statements)
    $arama_terimi = "%" . $_GET['ara'] . "%";
    $urunsor = $db->prepare("SELECT * FROM urunler WHERE (baslik LIKE ? OR aciklama LIKE ?) AND aktif_mi = 1");
    $urunsor->execute([$arama_terimi, $arama_terimi]);
    $baslik_metni = "🔍 '" . htmlspecialchars($_GET['ara']) . "' Araması İçin Sonuçlar";

} else {
    // Hiçbir filtreleme yoksa tüm aktif ürünleri getir
    $urunsor = $db->prepare("SELECT * FROM urunler WHERE aktif_mi = 1 ORDER BY id DESC");
    $urunsor->execute();
    $baslik_metni = "✨ Popüler Lezzetlerimiz";
}

$urunler = $urunsor->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="container">

    <!-- Madde 11: Dinamik Banner/Hero Alanı -->
    <section class="hero-banner" id="hero">
      <h2>Gerçek Gaziantep Lezzeti<br>Sofranıza Geliyor</h2>
      <p>Taş fırında pişen, bol fıstıklı ve tereyağlı efsane tatlar.</p>
      <a href="#urun-listesi" class="btn-cta">Hemen Keşfet <i class="fas fa-arrow-down"></i></a>
    </section>

    <!-- Ürün Listeleme Alanı -->
    <section id="urun-listesi">
      <h2 class="section-title"><?php echo $baslik_metni; ?></h2>

      <div class="product-grid">
        
        <?php if(count($urunler) > 0): ?>
            
            <?php foreach($urunler as $urun): ?>
            <div class="product-card">
              
              <!-- Ürün Görseli (Madde 10) -->
              <div style="overflow:hidden; border-radius:12px;">
                  <img class="product-image" src="img/urunler/<?php echo $urun['resim']; ?>" alt="<?php echo $urun['baslik']; ?>" onerror="this.src='https://via.placeholder.com/300x240';">
              </div>

              <div class="product-info">
                <h4 class="product-title"><?php echo $urun['baslik']; ?></h4>
                
                <!-- Fiyat Formatlama -->
                <div class="product-price">
                    <?php echo number_format($urun['fiyat'], 2, ',', '.'); ?> TL
                </div>

                <div class="card-actions">
                  <!-- SEPETE EKLE BUTONU (Link Metodu İle Aktif Edildi) -->
                  <a href="sepet_islem.php?islem=hizli_ekle&id=<?php echo $urun['id']; ?>" class="btn-add-to-cart" style="text-align: center; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <i class="fas fa-cart-plus"></i> Sepete Ekle
                  </a>

                  <!-- İNCELE BUTONU -->
                  <a class="btn-detail" href="product_detail.php?id=<?php echo $urun['id']; ?>" title="Ürün Detaylarını Gör">
                    <i class="fas fa-eye"></i>
                  </a>
                </div>
              </div>

            </div>
            <?php endforeach; ?>

        <?php else: ?>
            <!-- Ürün Bulunamazsa Gösterilecek Mesaj -->
            <div class="text-center p-40" style="grid-column: 1 / -1; background: rgba(255,255,255,0.1); border-radius: 15px;">
                <i class="fas fa-cookie-bite" style="font-size: 3rem; color: #eee; margin-bottom: 15px;"></i>
                <h3 style="color: white;">Henüz burada bir lezzet yok!</h3>
                <p class="muted">Aradığınız kriterlere uygun ürün bulamadık. Lütfen diğer kategorilere göz atın.</p>
                <a href="index.php" class="btn-cta mt-20" style="display:inline-block;">Tüm Ürünleri Gör</a>
            </div>
        <?php endif; ?>

      </div>
    </section>

</main>

<?php 
// Footer'ı dahil et
include 'inc/footer.php'; 
?>