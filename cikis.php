<?php
session_start();
session_destroy(); // Tüm oturumu temizle
header("Location: index.php?durum=cikis_yapildi");
exit;
?>