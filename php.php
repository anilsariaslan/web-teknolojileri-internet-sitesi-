<?php
session_start();

// Öğrenci numarası ve şifre kontrolü
function authenticate($username, $password) {
    // Öğrenci numarasından @ öncesi alınarak kontrol ediliyor
    $student_number = substr($username, 1, strpos($username, '@') - 1);
    
    // Şifre ile öğrenci numarasının aynı olup olmadığı kontrol ediliyor
    if ($password === $student_number) {
        return true;
    } else {
        return false;
    }
}

// Giriş formu post edildiğinde
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kullanıcı adı ve şifre alanlarının boş olup olmadığı kontrol ediliyor
    if (empty($_POST['username']) || empty($_POST['password'])) {
        echo "Kullanıcı adı veya şifre boş bırakılamaz.";
    } else {
        // Kullanıcı adının bir e-posta adresi olup olmadığı kontrol ediliyor
        if (!filter_var($_POST['username'], FILTER_VALIDATE_EMAIL)) {
            echo "Geçersiz e-posta adresi.";
        } else {
            // Kullanıcı adı ve şifre alınıyor
            $username = $_POST['username'];
            $password = $_POST['password'];
            
            // Kullanıcı doğrulama işlemi
            if (authenticate($username, $password)) {
                // Doğrulama başarılı ise kullanıcı oturumu başlatılıyor
                $_SESSION['username'] = $username;
                echo "Hoşgeldiniz " . $username;
                // Başarılı giriş sonrası istenilen sayfaya yönlendirme yapılabilir
            } else {
                // Doğrulama başarısız ise hata mesajı veriliyor
                echo "Kullanıcı adı veya şifre hatalı.";
            }
        }
    }
}
?>
