<?php
require 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $pin = $_POST['pin'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password']) && password_verify($pin, $user['pin'])) {
            $_SESSION['user_id'] = $user['id'];
            echo "<script>window.location.href='dashboard.php';</script>";
        } else {
            echo "<script>alert('Invalid credentials');</script>";
        }
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
    <title>Login</title>
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
        <h2>Login</h2>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="pin" placeholder="4-digit PIN" required>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="javascript:redirect('signup.php')">Signup</a></p>
    </div>
    <script>
        function redirect(url) { window.location.href = url; }
    </script>
</body>
</html>
