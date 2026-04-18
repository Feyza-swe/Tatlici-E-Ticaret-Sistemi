<?php 
include 'inc/header.php'; // Header'ı dahil et
?>

<main class="container main-medium">
    <div class="stat-card p-40">
      <div class="text-center mb-30">
        <i class="fas fa-user-plus icon-large"></i>
        <h2>Aramıza Katılın!</h2>
        <p class="muted mt-8">Ücretsiz hesap oluşturun</p>
      </div>

      <!-- Madde 3: Güvenlik için POST metodu -->
      <!-- action="islem.php" kısmına backend işlemlerini yapacağın dosyanın adını yazacaksın -->
      <form action="islem.php" method="POST" novalidate>
        <div class="grid-2">
          <div class="form-control">
            <label for="rFirstName"><i class="fas fa-user"></i> Ad</label>
            <input id="rFirstName" name="ad" class="input" type="text" placeholder="Adınız" required>
          </div>

          <div class="form-control">
            <label for="rLastName"><i class="fas fa-user"></i> Soyad</label>
            <input id="rLastName" name="soyad" class="input" type="text" placeholder="Soyadınız" required>
          </div>
        </div>

        <div class="form-control">
          <label for="rEmail"><i class="fas fa-envelope"></i> E-posta</label>
          <input id="rEmail" name="eposta" class="input" type="email" placeholder="ornek@email.com" required>
        </div>

        <div class="form-control">
          <label for="rPhone"><i class="fas fa-phone"></i> Telefon</label>
          <input id="rPhone" name="telefon" class="input" type="tel" placeholder="+90 5xx xxx xx xx" pattern="^\+?\d{7,15}$">
          <small class="small-muted">Opsiyonel - Sipariş takibi için önerilir</small>
        </div>

        <div class="grid-2">
          <div class="form-control">
            <label for="rBirth"><i class="fas fa-calendar"></i> Doğum Tarihi</label>
            <input id="rBirth" name="dogumtarihi" class="input" type="date" max="2007-12-31">
          </div>

          <div class="form-control">
            <label for="rGender"><i class="fas fa-venus-mars"></i> Cinsiyet</label>
            <select id="rGender" name="cinsiyet" class="input">
              <option value="">Seçiniz</option>
              <option value="erkek">Erkek</option>
              <option value="kadin">Kadın</option>
              <option value="diger">Belirtmek İstemiyorum</option>
            </select>
          </div>
        </div>

        <div class="form-control">
          <label for="rPass"><i class="fas fa-lock"></i> Parola</label>
          <input id="rPass" name="sifre" class="input" type="password" placeholder="En az 6 karakter" minlength="6" required>
          <small class="small-muted">Güçlü parola: harf, rakam ve sembol içermeli</small>
        </div>

        <div class="form-control">
          <label for="rPassConfirm"><i class="fas fa-lock"></i> Parola Tekrar</label>
          <input id="rPassConfirm" name="sifre_tekrar" class="input" type="password" placeholder="Parolanızı tekrar girin" required>
        </div>

        <div class="mt-20 mb-20">
          <label class="flex items-start gap-12 cursor-pointer">
            <input type="checkbox" name="kosullar" required class="mt-4">
            <span class="small-muted">
              <a href="#" class="link-strong">Kullanım Koşullarını</a> ve 
              <a href="#" class="link-strong">Gizlilik Politikasını</a> okudum, kabul ediyorum.
            </span>
          </label>
        </div>

        <button type="submit" name="kayitol" class="btn-cta btn-full">
          <i class="fas fa-user-plus"></i> Kayıt Ol
        </button>

        <div class="top-sep">
          <p class="muted">Zaten hesabınız var mı?</p>
          <a href="login.php" class="btn-detail mt-12">
            <i class="fas fa-sign-in-alt"></i> Giriş Yapın
          </a>
        </div>
      </form>
    </div>
  </main>

<?php include 'inc/footer.php'; // Footer'ı dahil et ?>