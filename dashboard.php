<?php
// Database connection
$host = 'localhost';
$db = 'token_system';
$user = 'root';
$pass = '';
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}

// Fetch tokens from the database
$tokens = [];
$sql = "SELECT token_number, name, bform, date, time FROM tokens"; // Fetch the data
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
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: #eafaf1;
        }

        .container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 30px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #2c6b3b;
        }

        table {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-align: center;
            border-radius: 4px;
            text-decoration: none;
            font-size: 16px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .dashboard {
            margin-top: 30px;
        }
    </style>
</head>
<body>

    <div class="container">
        <img src="logo.webp" alt="Logo" style="display: block; margin: 0 auto; width: 100px; height: 100px;">
        <h1>Token Management Dashboard</h1>

        <!-- Button to View Tokens -->
        <div class="btn-group" style="text-align: center;">
            <a href="token_slip_view.php" class="btn">Get Token slip</a>
        </div>

        <!-- Token Data Table -->
        <div class="dashboard">
            <h2>Generated Tokens</h2>
            <?php if (count($tokens) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Token Number</th>
                            <th>Name</th>
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
                <p>No tokens generated yet.</p>
            <?php endif; ?>
        </div>

    </div>

</body>
</html>
