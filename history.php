<?php
require 'db.php';
if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='login.php';</script>";
}
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM transactions WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$transactions = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f4f4f4; }
        header { background: linear-gradient(to right, #1e3c72, #2a5298); color: #fff; padding: 20px; text-align: center; }
        .container { padding: 30px; max-width: 800px; margin: auto; background: #fff; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; border: 1px solid #ccc; text-align: left; }
        th { background: #2a5298; color: #fff; }
        button { background: #2a5298; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #1e3c72; }
        @media (max-width: 600px) { .container { padding: 20px; } table { font-size: 14px; } }
    </style>
</head>
<body>
    <header>
        <h1>Transaction History</h1>
        <button onclick="redirect('dashboard.php')">Back to Dashboard</button>
    </header>
    <div class="container">
        <h2>Your Transactions</h2>
        <table>
            <tr>
                <th>Type</th>
                <th>Amount</th>
                <th>Recipient</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
            <?php foreach ($transactions as $tx): ?>
            <tr>
                <td><?php echo $tx['type']; ?></td>
                <td>PKR <?php echo $tx['amount']; ?></td>
                <td><?php echo $tx['recipient'] ?: '-'; ?></td>
                <td><?php echo $tx['status']; ?></td>
                <td><?php echo $tx['created_at']; ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <script>
        function redirect(url) { window.location.href = url; }
    </script>
</body>
</html>
