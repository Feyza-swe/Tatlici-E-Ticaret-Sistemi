<?php 
include 'inc/header.php'; // Header'ı dahil et
session_start(); // Oturum başlatma
?>

<main class="container">
  <h2 class="section-title">❤️ Favorilerim</h2>

  <div class="product-grid">
    <!-- Ürün kartları buraya gelecek -->
    <!-- Örnek Kart -->
    <div class="product-card">
      <img class="product-image" src="https://static.ticimax.cloud/54612/uploads/urunresimleri/buyuk/fistikli-kuru-baklava-136e-4.jpg">
      <div class="product-info">
        <h4 class="product-title">Fıstıklı Baklava (1 Kg)</h4>
        <p class="product-desc">Gerçek Antep lezzeti.</p>
        <div class="product-price">550.00 TL</div>

        <div class="card-actions">
          <button class="btn-add-to-cart">Sepete Ekle</button>
          <button class="btn-detail" style="color:red; border-color:red;">
            <i class="fas fa-heart"></i> Kaldır
          </button>
        </div>
      </div>
    </div>
    <!-- Diğer favoriler buraya gelecek -->
  </div>
</main>

<?php include 'inc/footer.php'; // Footer'ı dahil et ?>