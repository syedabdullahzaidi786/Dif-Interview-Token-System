<?php
session_start();

$message = ""; // Initialize the message variable

// Sample logic for login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate username and password (replace with your validation logic)
    if ($username === 'admin' && $password === 'password') {
        $_SESSION['logged_in'] = true;
        $message = "Login successful"; // Success message
        header('refresh:2; url=dashboard.php'); // Redirect after 2 seconds
    } else {
        $message = "Invalid login credentials"; // Error message
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Darul Ilm Islamic Academy</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to bottom, #0f4229, #1a6240);
            color: #fff;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background: rgba(255, 255, 255, 0.1);
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);
            text-align: center;
            width: 90%;
            max-width: 400px;
            position: relative;
            overflow: hidden;
        }

        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            background: rgba(0, 0, 0, 0.8);
            color: #fff;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            font-size: 14px;
            z-index: 1000;
            display: none;
        }

        .toast.success {
            background: #27a96f;
        }

        .toast.error {
            background: #ff4d4d;
        }

        .show {
            display: block;
            animation: fadeInOut 3s ease-in-out;
        }

        @keyframes fadeInOut {
            0%, 100% { opacity: 0; transform: translateY(-20px); }
            10%, 90% { opacity: 1; transform: translateY(0); }
        }

        .logo {
            display: block;
            margin: 0 auto 20px;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: #fff;
            padding: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        h1 {
            font-size: 24px;
            margin: 10px 0;
            color: #c3ffd4;
        }

        p {
            font-size: 14px;
            margin-bottom: 20px;
            color: #a1e5af;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 20px;
            text-color: #fff;
        }

        input {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            font-size: 14px;
            outline: none;
            transition: all 0.3s ease-in-out;
        }

        input:focus {
            border: 2px solid #27a96f;
            background: rgba(255, 255, 255, 0.3);
        }

        button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background: #27a96f;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease-in-out;
        }

        button:hover {
            background: #1d7048;
        }

        footer {
            margin-top: 20px;
            font-size: 12px;
            color: #a1e5af;
        }
    </style>
</head>
<body>
    <?php if (!empty($message)): ?>
        <div class="toast <?php echo ($message === "Login successful") ? 'success' : 'error'; ?> show">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <div class="container">
        <img src="logo.webp" alt="Islamic Academy Logo" class="logo">
        <h1>Darul Ilm Foundation Secondary School</h1>
        <p>Log in to Access the Admin Dashboard.</p>
        <form method="POST" action="">
            <div class="form-group">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        <footer>Powered By: AR Developers</footer>
    </div>
</body>
</html>
