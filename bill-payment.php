<?php
require 'db.php';
if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='login.php';</script>";
}
$user_id = $_SESSION['user_id'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bill_type = $_POST['bill_type'];
    $bill_number = $_POST['bill_number'];
    $amount = $_POST['amount'];
    $pin = $_POST['pin'];
    $stmt = $pdo->prepare("SELECT pin, balance FROM users u JOIN wallets w ON u.id = w.user_id WHERE u.id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();
    if (password_verify($pin, $user['pin'])) {
        if ($user['balance'] >= $amount) {
            $pdo->prepare("UPDATE wallets SET balance = balance - ? WHERE user_id = ?")->execute([$amount, $user_id]);
            $pdo->prepare("INSERT INTO bills (user_id, bill_type, amount, bill_number, status) VALUES (?, ?, ?, ?, 'paid')")->execute([$user_id, $bill_type, $amount, $bill_number]);
            echo "<script>alert('Bill paid successfully');</script>";
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
    <title>Bill Payment</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f4f4f4; }
        header { background: linear-gradient(to right, #1e3c72, #2a5298); color: #fff; padding: 20px; text-align: center; }
        .container { padding: 30px; max-width: 600px; margin: auto; background: #fff; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        input, button, select { width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; font-size: 16px; }
        button { background: #2a5298; color: #fff; border: none; cursor: pointer; }
        button:hover { background: #1e3c72; }
        @media (max-width: 600px) { .container { padding: 20px; } }
    </style>
</head>
<body>
    <header>
        <h1>Bill Payment</h1>
        <button onclick="redirect('dashboard.php')">Back to Dashboard</button>
    </header>
    <div class="container">
        <h2>Pay Bills</h2>
        <form method="POST">
            <select name="bill_type" required>
                <option value="electricity">Electricity</option>
                <option value="gas">Gas</option>
                <option value="water">Water</option>
                <option value="internet">Internet</option>
            </select>
            <input type="text" name="bill_number" placeholder="Bill Number" required>
            <input type="number" name="amount" placeholder="Amount" required>
            <input type="password" name="pin" placeholder="4-digit PIN" required>
            <button type="submit">Pay Bill</button>
        </form>
        <h2>Mobile Recharge</h2>
        <form method="POST" action="recharge.php">
            <input type="text" name="phone" placeholder="Phone Number" required>
            <input type="number" name="amount" placeholder="Amount" required>
            <select name="provider" required>
                <option value="jazz">Jazz</option>
                <option value="zong">Zong</option>
                <option value="ufone">Ufone</option>
            </select>
            <input type="password" name="pin" placeholder="4-digit PIN" required>
            <button type="submit">Recharge</button>
        </form>
    </div>
    <script>
        function redirect(url) { window.location.href = url; }
    </script>
</body>
</html>
