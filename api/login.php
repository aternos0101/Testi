<?php
session_start();

$file = '/tmp/users.json';

// Buat file JSON kosong jika belum ada
if (!file_exists($file)) {
    file_put_contents($file, json_encode([]));
}

$users = json_decode(file_get_contents($file), true);
$msg = "";

// Register
if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if (isset($users[$username])) {
        $msg = "❌ Username sudah digunakan!";
    } else {
        $users[$username] = ['password' => $password];
        file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT));
        $msg = "✅ Registrasi berhasil! Silakan login.";
    }
}

// Login
if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (isset($users[$username]) && password_verify($password, $users[$username]['password'])) {
        $_SESSION['username'] = $username;
        $msg = "✅ Login berhasil! Selamat datang $username.";
    } else {
        $msg = "❌ Username atau password salah!";
    }
}

// Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login & Register JSON</title>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial; background: #f4f4f4; padding: 20px; }
        form { background: white; padding: 15px; border-radius: 8px; width: 300px; margin: 10px auto; }
        input { width: 100%; padding: 10px; margin: 5px 0; }
        button { padding: 10px; width: 100%; cursor: pointer; }
        .msg { text-align: center; margin-bottom: 10px; }
    </style>
</head>
<body>

<h2 style="text-align:center">Login & Register</h2>
<?php if ($msg) echo "<p class='msg'>$msg</p>"; ?>

<?php if (!isset($_SESSION['username'])): ?>
<!-- Form Register -->
<form method="post">
    <h3>Register</h3>
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit" name="register">Register</button>
</form>

<!-- Form Login -->
<form method="post">
    <h3>Login</h3>
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit" name="login">Login</button>
</form>
<?php else: ?>
    <h3 style="text-align:center">Halo, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h3>
    <div style="text-align:center"><a href="?logout=1">Logout</a></div>
<?php endif; ?>

</body>
</html>
