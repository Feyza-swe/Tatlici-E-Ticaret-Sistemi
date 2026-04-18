<?php 
require_once 'inc/baglan.php'; 

// Madde 13: Site Ayarlarını Çek
$ayarsor = $db->prepare("SELECT * FROM ayarlar WHERE id = ?");
$ayarsor->execute([1]);
$ayarcek = $ayarsor->fetch(PDO::FETCH_ASSOC);

// Madde 12: Kategorileri (Menüleri) Çek
$kategorisor = $db->prepare("SELECT * FROM kategoriler ORDER BY id ASC");
$kategorisor->execute();
$kategoriler = $kategorisor->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <!-- Madde 13: Dinamik Başlık -->
  <title><?php echo $ayarcek['site_basligi']; ?></title> 
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"/>
</head>
<body>
  
  <header class="main-header">
    <div class="container header-inner">
      <!-- Madde 13: Dinamik Logo/İsim -->
      <h1 class="logo"><a href="index.php"><?php echo $ayarcek['site_basligi']; ?><span>.</span></a></h1>
      
      <form action="index.php" method="GET" class="search-bar">
        <input name="ara" type="text" placeholder="Canınız ne çekti?" required />
        <button type="submit"><i class="fas fa-search"></i></button>
      </form>

      <nav class="user-nav">
        <ul>
          <?php if(isset($_SESSION['kullanici_id'])): ?>
            <li><a href="#"><i class="fas fa-user"></i> <?php echo explode(' ', $_SESSION['kullanici_ad_soyad'])[0]; ?></a></li>
            <?php if($_SESSION['kullanici_rol'] <= 3): ?>
                <li><a href="admin_dashboard.php"><i class="fas fa-user-shield"></i> Panel</a></li>
            <?php endif; ?>
            <li><a href="cikis.php"><i class="fas fa-sign-out-alt"></i></a></li>
          <?php else: ?>
            <li><a href="login.php">Giriş</a></li>
            <li><a href="register.php">Kayıt</a></li>
          <?php endif; ?>
          <li><a href="cart.php"><i class="fas fa-shopping-basket"></i></a></li>
        </ul>
      </nav>
    </div>
  </header>

  <nav class="main-nav">
    <div class="container">
      <ul>
        <li><a href="index.php">Tümü</a></li>
        <!-- Madde 12: Dinamik Menü Döngüsü -->
        <?php foreach($kategoriler as $kat): ?>
            <li><a href="index.php?kategori=<?php echo $kat['id']; ?>"><?php echo $kat['kategori_adi']; ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </nav>