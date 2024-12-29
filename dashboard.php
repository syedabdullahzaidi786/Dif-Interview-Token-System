<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php'); // Replace with your login page
    exit;
}

// Database connection
$host = 'localhost';
$db = 'token_system';
$user = 'root';
$pass = '';
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}

// Search functionality
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Fetch tokens from the database
$tokens = [];
$sql = "SELECT token_number, name, bform, date, time FROM tokens";
if (!empty($search)) {
    $sql .= " WHERE name LIKE '%" . $conn->real_escape_string($search) . "%'";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tokens[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Token Management Dashboard</title>
    <link rel="icon" type="webp" href="logo.webp">
    <style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f9;
        margin: 0;
        padding: 0;
        color: #333;
    }

    .container {
        max-width: 1200px;
        margin: 20px auto;
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .header img {
        width: 80px;
        height: 80px;
    }

    .header h1 {
        font-size: 24px;
        margin: 0;
        color: #4CAF50;
    }

    .btn {
        background-color: #4CAF50;
        color: #fff;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
    }

    .btn:hover {
        background-color: #45a049;
    }

    .btn.red {
        background-color: red;
    }

    .btn.red:hover {
        background-color: darkred;
    }

    .search-bar {
        margin-bottom: 20px;
        text-align: center;
    }

    .search-bar input {
        width: 300px;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-right: 10px;
    }

    .dashboard table {
        width: 100%;
        border-collapse: collapse;
    }

    .dashboard table th, .dashboard table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .dashboard table th {
        background-color: #4CAF50;
        color: #fff;
    }

    .dashboard table tr:hover {
        background-color: #f1f1f1;
    }

    /* Modern Centered Alert Styling */
    .alert-container {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5); /* Dark background to dim the rest of the screen */
        z-index: 9999;
        justify-content: center;
        align-items: center;
    }

    .alert-box {
        background-color: #f44336; /* Red for error */
        color: white;
        padding: 20px 40px;
        border-radius: 8px;
        font-size: 18px;
        text-align: center;
        position: relative;
        max-width: 400px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        opacity: 0;
        transform: scale(0.9);
        animation: zoomIn 0.3s forwards; /* Animation for zoom-in effect */
    }

    .alert-box.success {
        background-color: #4CAF50; /* Green for success */
    }

    .alert-box .close-btn {
        color: white;
        font-size: 22px;
        font-weight: bold;
        background: none;
        border: none;
        cursor: pointer;
        position: absolute;
        top: 5px;
        right: 10px;
    }

    .alert-box .close-btn:hover {
        transform: scale(1.2);
    }

    /* Zoom In Animation */
    @keyframes zoomIn {
        0% {
            opacity: 0;
            transform: scale(0.8);
        }
        100% {
            opacity: 1;
            transform: scale(1);
        }
    }
</style>

</head>
<body>
    <div class="container">
        <div class="header">
            <img src="logo.webp" alt="Logo">
            <h1>Token Management Dashboard</h1>
            <a href="logout.php" class="btn red">Logout</a>
        </div>

        <!-- Search Bar -->
        <div class="search-bar">
            <form method="GET" action="">
                <input type="text" name="search" placeholder="Search by Name..." value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit" class="btn">Search</button>
            </form>
        </div>

        <!-- Button for Get Token Slip below logout -->
        <div class="buttons-container">
            <a href="token_slip_view.php" class="btn blue" style="background-color: #006400; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-size: 16px;">Get Token Slip</a>
        </div>

        <!-- Token Data Table -->
        <div class="dashboard">
            <h2>Generated Tokens</h2>
            <?php if (count($tokens) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Token Number</th>
                            <th>Student Name</th>
                            <th>B-Form</th>
                            <th>Date</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tokens as $token): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($token['token_number']); ?></td>
                                <td><?php echo htmlspecialchars($token['name']); ?></td>
                                <td><?php echo htmlspecialchars($token['bform']); ?></td>
                                <td><?php echo htmlspecialchars($token['date']); ?></td>
                                <td><?php echo htmlspecialchars($token['time']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <script>
                    window.onload = function() {
                        var alertContainer = document.getElementById("noDataAlertContainer");
                        alertContainer.style.display = "flex";  // Show the alert box
                    }
                </script>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modern Centered Alert -->
    <div id="noDataAlertContainer" class="alert-container">
        <div class="alert-box">
            <button class="close-btn">&times;</button>
            <p>No Data Found...</p>
        </div>
    </div>

    <script>
        // Get the alert container and close button
        var alertContainer = document.getElementById("noDataAlertContainer");
        var closeBtn = document.getElementsByClassName("close-btn")[0];

        // Close the alert when the user clicks the close button
        closeBtn.onclick = function() {
            alertContainer.style.display = "none";
        }

        // Close the alert after 5 seconds
        setTimeout(function() {
            alertContainer.style.display = "none";
        }, 5000);
    </script>
</body>
</html>
