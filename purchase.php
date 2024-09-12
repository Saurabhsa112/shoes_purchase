<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shoestore";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$shoe_id = $_POST['shoe_id'];

// Get current stock
$sql = "SELECT stock FROM shoes WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $shoe_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row['stock'] > 0) {
  // Update stock
  $sql = "UPDATE shoes SET stock = stock - 1 WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $shoe_id);
  $stmt->execute();

  // Record purchase
  $sql = "INSERT INTO purchases (shoe_id) VALUES (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $shoe_id);
  $stmt->execute();

  echo "Purchase successful!";
} else {
  echo "Out of stock!";
}

$stmt->close();
$conn->close();
?>
