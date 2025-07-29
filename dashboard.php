<?php
require 'db.php';
if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='login.php';</script>";
}
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT balance FROM wallets WHERE user_id = ?");
$stmt->execute([$user_id]);
$wallet = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f4f4f4; }
        header { background: linear-gradient(to right, #1e3c72, #2a5298); color: #fff; padding: 20px; text-align: center; }
        .dashboard { padding: 30px; display: flex; flex-wrap: wrap; justify-content: space-around; }
        .card { background: #fff; padding: 20px; margin: 10px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); width: 30%; text-align: center; }
        button { background: #2a5298; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #1e3c72; }
        @media (max-width: 800px) { .card { width: 45%; } }
        @media (max-width: 500px) { .card { width: 100%; } }
    </style>
</head>
<body>
    <header>
        <h1>Dashboard</h1>
        <button onclick="redirect('logout.php')">Logout</button>
    </header>
    <div class="dashboard">
        <div class="card">
            <h3>Wallet Balance</h3>
            <p>PKR <?php echo $wallet['balance']; ?></p>
            <button onclick="redirect('wallet.php')">Manage Wallet</button>
        </div>
        <div class="card">
            <h3>Money Transfer</h3>
            <p>Send or receive funds.</p>
            <button onclick="redirect('transfer.php')">Transfer Now</button>
        </div>
        <div class="card">
            <h3>Bill Payments</h3>
            <p>Pay your utility bills.</p>
            <button onclick="redirect('bill-payment.php')">Pay Bills</button>
        </div>
        <div class="card">
            <h3>Transaction History</h3>
            <p>View your transactions.</p>
            <button onclick="redirect('history.php')">View History</button>
        </div>
        <div class="card">
            <h3>Account Settings</h3>
            <p>Manage your account.</p>
            <button onclick="redirect('account.php')">Account</button>
        </div>
    </div>
    <script>
        function redirect(url) { window.location.href = url; }
    </script>
</body>
</html>
