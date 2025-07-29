<?php
require 'db.php';
if (isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='dashboard.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JazzCash Clone</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f4f4f4; }
        header { background: linear-gradient(to right, #1e3c72, #2a5298); color: #fff; padding: 20px; text-align: center; }
        .hero { background: url('https://via.placeholder.com/1200x400') no-repeat center; background-size: cover; padding: 50px; text-align: center; color: #fff; }
        .services { display: flex; justify-content: space-around; padding: 30px; flex-wrap: wrap; }
        .service { background: #fff; padding: 20px; margin: 10px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); width: 22%; text-align: center; }
        button { background: #2a5298; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; transition: background 0.3s; }
        button:hover { background: #1e3c72; }
        @media (max-width: 800px) { .service { width: 45%; } }
        @media (max-width: 500px) { .service { width: 100%; } }
    </style>
</head>
<body>
    <header>
        <h1>JazzCash Clone</h1>
        <p>Your Digital Payment Solution</p>
    </header>
    <div class="hero">
        <h2>Fast. Secure. Easy Payments.</h2>
        <button onclick="redirect('signup.php')">Get Started</button>
    </div>
    <div class="services">
        <div class="service">
            <h3>Money Transfer</h3>
            <p>Send and receive money instantly.</p>
        </div>
        <div class="service">
            <h3>Bill Payments</h3>
            <p>Pay utility bills with ease.</p>
        </div>
        <div class="service">
            <h3>Mobile Recharge</h3>
            <p>Top-up your mobile anytime.</p>
        </div>
        <div class="service">
            <h3>Digital Wallet</h3>
            <p>Manage your funds securely.</p>
        </div>
    </div>
    <script>
        function redirect(url) { window.location.href = url; }
    </script>
</body>
</html>
