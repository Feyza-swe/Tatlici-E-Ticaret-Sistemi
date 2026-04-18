<?php 
// 1. Header'ı dahil et (İçinde baglan.php ve session_start() zaten var)
include 'inc/header.php'; 

// DİKKAT: Buradaki manuel session_start(); satırı hata verdiği için kaldırıldı.
?>

<main class="container main-narrow">
    <div class="stat-card p-40">
        <div class="text-center mb-30">
            <i class="fas fa-sign-in-alt icon-large text-primary"></i>
            <h2>Giriş Yap</h2>
            <p class="muted mt-8">Lezzet dolu dünyamıza hoş geldiniz</p>
        </div>

        <!-- Madde 3: Güvenlik için POST metodu kullanılır -->
        <form action="islem.php" method="POST" class="flex flex-col gap-8">
          
          <div class="form-control">
            <label for="loginEmail"><i class="fas fa-envelope"></i> E-posta Adresiniz</label>
            <!-- name="eposta" islem.php'deki değişkenle aynı olmalı -->
            <input id="loginEmail" name="eposta" class="input" type="email" placeholder="örnek@mail.com" required>
          </div>

          <div class="form-control">
            <label for="loginPassword"><i class="fas fa-lock"></i> Parolanız</label>
            <!-- name="sifre" islem.php'deki değişkenle aynı olmalı -->
            <input id="loginPassword" name="sifre" class="input" type="password" placeholder="******" minlength="6" required>
          </div>

          <div class="flex space-between items-center mt-8">
            <div class="remember-area">
                <label style="cursor:pointer; display:flex; align-items:center; gap:8px;">
                  <input type="checkbox" class="remember-check" style="width:18px; height:18px;">
                  Beni Hatırla
                </label>
            </div>
            <a href="#" class="link-strong small-muted">Şifremi Unuttum?</a>
          </div>

          <div class="mt-20">
            <!-- name="girisyap" islem.php'deki if kontrolünü tetikler -->
            <button class="btn-cta btn-full" name="girisyap" type="submit">
                <i class="fas fa-sign-in-alt"></i> Giriş Yap
            </button>
          </div>

          <div class="top-sep text-center">
            <p class="muted">Henüz bir hesabınız yok mu?</p>
            <a href="register.php" class="btn-detail mt-12" style="display:inline-block;">
                <i class="fas fa-user-plus"></i> Ücretsiz Kayıt Olun
            </a>
          </div>
          
        </form>
    </div>
</main>

<?php 
// Footer'ı dahil et
include 'inc/footer.php'; 
?>