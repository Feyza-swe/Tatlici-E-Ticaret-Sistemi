# 🥧 Tatlıcı E-Ticaret Sistemi

Bu proje, tam kapsamlı bir e-ticaret ve içerik yönetim sistemidir. 1985'ten beri süre gelen lezzet geleneğini dijital dünyaya taşımayı amaçlar.

## 🚀 Öne Çıkan Özellikler (Proje Gereksinimleri)

- **Responsive Tasarım :** Mobil, tablet ve masaüstü cihazlarla tam uyumlu (Duyarlı) arayüz.
- **Gelişmiş Veritabanı Mimarisi :** İlişkisel tablolar (Foreign Keys) ve Normalizasyon kurallarına uygun yapı.
- **Üst Düzey Güvenlik :** 
  - Tüm sorgularda **PDO Prepared Statements** kullanılarak SQL Injection engellenmiştir.
  - Kullanıcı şifreleri **BCRYPT** algoritmasıyla (`password_hash`) geri döndürülemez şekilde şifrelenmiştir.
- **Rol Bazlı Yetkilendirme :** Süper Admin, Editör ve Moderatör rolleriyle sayfa ve işlem bazlı yetki kontrolü.
- **Dinamik İçerik Yönetimi :** Menüler, slider modülü, ürünler ve site ayarları tamamen admin paneli üzerinden yönetilebilir.
- **Modüler Mimari :** Header, Footer ve Veritabanı bağlantısı gibi bölümler bağımsız dosyalarda tutularak kod tekrarı önlenmiştir.
- **Hata Loglama :** Kritik sistem hataları teknik detay gösterilmeden arka planda IP ve tarih bilgisiyle kaydedilmiş olur.

## 🛠️ Kullanılan Teknolojiler
- **Backend:** PHP 8.x
- **Veritabanı:** MySQL (MariaDB)
- **Frontend:** HTML5, CSS3, JavaScript
- **Kütüphaneler:** FontAwesome 6, Google Fonts

## 📦 Kurulum ve Çalıştırma
1. Dosyaları WampServer `www` klasörüne kopyalayın.
2. `phpMyAdmin` üzerinden `Tatlici` adında bir veritabanı oluşturun.
3. Klasör içindeki `Tatlici.sql` dosyasını içe aktarın (Import).
4. `inc/baglan.php` dosyasındaki veritabanı bilgilerini kontrol edin.
5. Tarayıcıdan `localhost/Tatlici` adresine gidin.

**Test Admin Bilgileri:**.
- **E-posta:** feyza@gmail.com 
- **Şifre:** feyza123  
