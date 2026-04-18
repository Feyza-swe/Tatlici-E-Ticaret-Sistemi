<?php 
// 1. Header'ı dahil et (İçinde baglan.php ve session_start() var)
include 'inc/header.php'; 
?>

<main class="container">
  <h2 class="section-title">🛒 Sepetim</h2>

  <div class="stat-card p-24">

    <?php 
    // 2. Sepet Boş mu Dolu mu Kontrol Et
    if (!empty($_SESSION['sepet'])): 
        $genel_toplam = 0; // Toplam tutarı tutacak değişken
    ?>
        
        <!-- Ürün Listesi Başlangıcı -->
        <div class="overflow-x-auto">
            <?php 
            // 3. Sepetteki her bir ürünü döngüye al
            foreach ($_SESSION['sepet'] as $id => $urun): 
                $ara_toplam = $urun['fiyat'] * $urun['adet']; // Fiyat x Adet
                $genel_toplam += $ara_toplam; // Toplam tutara ekle
            ?>
            <div class="flex items-center mb-20 border-bottom-light pb-12" style="border-bottom: 1px solid #eee; padding-bottom: 15px;">
              
              <!-- Ürün Resmi -->
              <img class="img-80" src="img/urunler/<?php echo $urun['resim']; ?>" alt="<?php echo $urun['ad']; ?>" onerror="this.src='https://via.placeholder.com/80';">
              
              <!-- Ürün Adı ve Adet -->
              <div class="flex-1 ml-16">
                <h4 class="text-dark-strong"><?php echo $urun['ad']; ?></h4>
                <p class="small-muted">
                    Birim Fiyat: <?php echo number_format($urun['fiyat'], 2, ',', '.'); ?> TL x 
                    <strong><?php echo $urun['adet']; ?> Adet</strong>
                </p>
              </div>

              <!-- Ara Toplam (Fiyat x Adet) -->
              <div class="fw-700 text-primary fs-1-1 mr-16" style="min-width: 120px; text-align: right;">
                <?php echo number_format($ara_toplam, 2, ',', '.'); ?> TL
              </div>

              <!-- Madde 16: Sepetten Tekli Silme Butonu -->
              <a href="sepet_islem.php?sil=ok&id=<?php echo $id; ?>" class="btn-small btn-danger" title="Ürünü Çıkar" onclick="return confirm('Bu ürünü sepetten çıkarmak istediğinize emin misiniz?')">
                <i class="fas fa-trash"></i>
              </a>

            </div>
            <?php endforeach; ?>
        </div>

        <!-- 4. Toplam ve Satın Al Bölümü -->
        <div class="cart-footer" style="display: flex; justify-content: space-between; align-items: center; margin-top: 30px; padding-top: 20px; border-top: 2px solid var(--primary);">
          
          <div class="total-area">
              <p class="muted" style="margin-bottom: 5px;">Ödenecek Toplam Tutar:</p>
              <strong style="font-size: 1.5rem; color: var(--primary);">
                <?php echo number_format($genel_toplam, 2, ',', '.'); ?> TL
              </strong>
          </div>

          <!-- Madde 14 & 15: Sipariş Tamamlama Formu -->
          <form action="islem.php" method="POST">
              <!-- Toplam tutarı islem.php'ye gizli olarak gönderiyoruz -->
              <input type="hidden" name="toplam_tutar" value="<?php echo $genel_toplam; ?>">
              
              <div class="flex gap-12">
                  <a href="index.php" class="btn-detail">Alışverişe Devam Et</a>
                  <button type="submit" name="siparis_ver" class="btn-cta">
                    <i class="fas fa-check-circle"></i> Siparişi Tamamla
                  </button>
              </div>
          </form>
        </div>

    <?php else: ?>
        
        <!-- 5. Sepet Boşsa Gösterilecek Alan -->
        <div class="text-center p-60">
            <i class="fas fa-shopping-basket" style="font-size: 5rem; color: var(--text-muted); opacity: 0.2; margin-bottom: 20px;"></i>
            <h3 class="text-dark-strong">Sepetiniz Şu An Boş</h3>
            <p class="muted mb-24">Henüz sepetinize bir lezzet eklemediniz.</p>
            <a href="index.php" class="btn-cta">
                <i class="fas fa-arrow-left"></i> Hemen Alışverişe Başla
            </a>
        </div>

    <?php endif; ?>

  </div>
</main>

<?php 
// Footer'ı dahil et
include 'inc/footer.php'; 
?>