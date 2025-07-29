<?php
require 'db.php';
if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='login.php';</script>";
}
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT username, email, phone FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pin = password_hash($_POST['pin'], PASSWORD_BCRYPT);
    $pdo->prepare("UPDATE users SET pin = ? WHERE id = ?")->execute([$pin, $user_id]);
    echo "<script>alert('PIN updated successfully');</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f4f4f4; }
        header { background: linear-gradient(to right, #1e3c72, #2a5298); color: #fff; padding: 20px; text-align: center; }
        .container { padding: 30px; max-width: 600px; margin: auto; background: #fff; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        input, button { width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; font-size: 16px; }
        button { background: #2a5298; color: #fff; border: none; cursor: pointer; }
        button:hover { background: #1e3c72; }
        @media (max-width: 600px) { .container { padding: 20px; } }
    </style>
</head>
<body>
    <header>
        <h1>Account Settings</h1>
        <button onclick="redirect('dashboard.php')">Back to Dashboard</button>
    </header>
    <div class="container">
        <h2>Account Details</h2>
        <p>Username: <?php echo $user['username']; ?></p>
        <p>Email: <?php echo $user['email']; ?></p>
        <p>Phone: <?php echo $user['phone']; ?></p>
        <h2>Reset PIN</h2>
        <form method="POST">
            <input type="password" name="pin" placeholder="New 4-digit PIN" required>
            <button type="submit">Update PIN</button>
        </form>
    </div>
    <script>
        function redirect(url) { window.location.href = url; }
    </script>
</body>
</html>
