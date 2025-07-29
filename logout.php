<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <style>
        body { font-family: Arial, sans-serif; background: linear-gradient(to right, #1e3c72, #2a5298); display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; color: #fff; }
        .container { background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 0 20px rgba(0,0,0,0.3); text-align: center; color: #333; }
        h2 { color: #2a5298; }
        a { color: #2a5298; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Logged Out</h2>
        <p>You have been logged out successfully.</p>
        <p><a href="javascript:redirect('login.php')">Login Again</a></p>
    </div>
    <script>
        function redirect(url) { window.location.href = url; }
    </script>
</body>
</html>
