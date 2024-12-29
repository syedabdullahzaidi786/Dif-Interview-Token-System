<?php
header("Content-Type: application/json");

// Database credentials
$servername = "localhost"; // Update with your server
$username = "root"; // Update with your database username
$password = ""; // Update with your database password
$dbname = "token_system"; // Update with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database connection failed: " . $conn->connect_error]));
}

// Function to fetch the last token number
function getLastToken($conn) {
    $result = $conn->query("SELECT MAX(token_number) AS lastToken FROM tokens");
    if ($result) {
        $row = $result->fetch_assoc();
        return $row['lastToken'] ?? 0;
    }
    return 0;
}

// Handle POST request for saving token details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? null;
    $bform = $_POST['bform'] ?? null;

    if (!$name || !$bform) {
        echo json_encode(["status" => "error", "message" => "Name and B-Form number are required."]);
        exit;
    }

    $lastToken = getLastToken($conn);
    $newToken = $lastToken + 1;

    if ($newToken > 100) {
        echo json_encode(["status" => "error", "message" => "All token numbers have been assigned."]);
        exit;
    }

    $date = date('Y-m-d');
    $time = date('H:i:s');

    $stmt = $conn->prepare("INSERT INTO tokens (token_number, name, bform, date, time) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $newToken, $name, $bform, $date, $time);

    if ($stmt->execute()) {
        echo json_encode([
            "status" => "success",
            "message" => "Token saved successfully.",
            "tokenNumber" => $newToken,
            "name" => $name,
            "bform" => $bform,
            "date" => $date,
            "time" => $time
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to save token: " . $stmt->error]);
    }

    $stmt->close();
} 
// Handle GET request to fetch the last token number
else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $lastToken = getLastToken($conn);
    echo json_encode(["lastToken" => $lastToken]);
}

// Close the database connection
$conn->close();
?>
