<?php
require 'db.php';
if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='login.php';</script>";
}
$user_id = $_SESSION['user_id'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $recipient = $_POST['recipient'];
    $amount = $_POST['amount'];
    $pin = $_POST['pin'];
    $stmt = $pdo->prepare("SELECT pin, balance FROM users u JOIN wallets w ON u.id = w.user_id WHERE u.id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();
    if (password_verify($pin, $user['pin'])) {
        if ($user['balance'] >= $amount) {
            $pdo->prepare("UPDATE wallets SET balance = balance - ? WHERE user_id = ?")->execute([$amount, $user_id]);
            $pdo->prepare("INSERT INTO transactions (user_id, type, amount, recipient, status) VALUES (?, 'transfer_sent', ?, ?, 'completed')")->execute([$user_id, $amount, $recipient]);
            echo "<script>alert('Transfer successful');</script>";
        } else {
            echo "<script>alert('Insufficient balance');</script>";
        }
    } else {
        echo "<script>alert('Invalid PIN');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Money Transfer</title>
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
        <h1>Money Transfer</h1>
        <button onclick="redirect('dashboard.php')">Back to Dashboard</button>
    </header>
    <div class="container">
        <h2>Send Money</h2>
        <form method="POST">
            <input type="text" name="recipient" placeholder="Phone/IBAN/QR Code" required>
            <input type="number" name="amount" placeholder="Amount" required>
            <input type="password" name="pin" placeholder="4-digit PIN" required>
            <button type="submit">Transfer</button>
        </form>
    </div>
    <script>
        function redirect(url) { window.location.href = url; }
    </script>
</body>
</html>
