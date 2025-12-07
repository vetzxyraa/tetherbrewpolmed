<?php
session_start();
// Kalo user ternyata udah login, langsung lempar ke dashboard aja
if(isset($_SESSION['status']) && $_SESSION['status'] == "login"){
    header("location:dashboard.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Admin</title>
    <link rel="icon" href="../assets/favicon.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body { display: flex; justify-content: center; align-items: center; height: 100vh; background: #1a1a1a; }
        .login-box { background: #fff; padding: 2.5rem; border-radius: 12px; text-align: center; color: #333; width: 350px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
        .login-box h2 { color: var(--primary); margin-bottom: 20px; font-size: 1.8rem; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2><i class="fa-solid fa-mug-hot"></i> Admin Area</h2>
        
        <form method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login" class="btn-gold btn-block" style="margin-top: 15px;">
                <i class="fa-solid fa-right-to-bracket"></i> Masuk Dashboard
            </button>
        </form>
        
        <?php
        // Proses cek username sama password
        if(isset($_POST['login'])){
            $user = $_POST['username'];
            $pass = $_POST['password'];
            // Hardcode kredensial sederhana
            if($user == 'admin' && $pass == 'admin123'){
                $_SESSION['username'] = $user;
                $_SESSION['status'] = "login";
                header("location:dashboard.php");
            } else {
                echo "<p style='color:red; margin-top:10px; font-size:0.9rem;'>Username/Password salah!</p>";
            }
        }
        ?>
    </div>
</body>
</html>