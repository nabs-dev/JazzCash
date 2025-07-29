<?php
require 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $pin = password_hash($_POST['pin'], PASSWORD_BCRYPT);
    $otp = rand(100000, 999999); // Simulated OTP

    try {
        // Insert user into users table
        $stmt = $pdo->prepare("INSERT INTO users (username, email, phone, password, pin) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$username, $email, $phone, $password, $pin]);
        $user_id = $pdo->lastInsertId();

        // Create wallet with encryption key
        $encryption_key = bin2hex(random_bytes(16));
        $stmt = $pdo->prepare("INSERT INTO wallets (user_id, encryption_key, balance) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $encryption_key, 10000000.00]);

        // Record initial deposit transaction
        $stmt = $pdo->prepare("INSERT INTO transactions (user_id, type, amount, status) VALUES (?, 'deposit', ?, 'completed')");
        $stmt->execute([$user_id, 10000000.00]);

        echo "<script>alert('Signup successful! OTP: $otp'); window.location.href='login.php';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <style>
        body { font-family: Arial, sans-serif; background: linear-gradient(to right, #1e3c72, #2a5298); display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; color: #fff; }
        .container { background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 0 20px rgba(0,0,0,0.3); width: 100%; max-width: 400px; color: #333; }
        h2 { text-align: center; color: #2a5298; }
        input, button { width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; font-size: 16px; }
        button { background: #2a5298; color: #fff; border: none; cursor: pointer; transition: background 0.3s; }
        button:hover { background: #1e3c72; }
        @media (max-width: 600px) { .container { padding: 20px; max-width: 90%; } }
    </style>
</head>
<body>
    <div class="container">
        <h2>Signup</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="phone" placeholder="Phone" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="pin" placeholder="4-digit PIN" required>
            <button type="submit">Signup</button>
        </form>
        <p>Already have an account? <a href="javascript:redirect('login.php')">Login</a></p>
    </div>
    <script>
        function redirect(url) { window.location.href = url; }
    </script>
</body>
</html>
