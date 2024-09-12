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

// Inventory
$sql = "SELECT * FROM shoes";
$result = $conn->query($sql);

echo "<h2>Inventory</h2>";
while ($row = $result->fetch_assoc()) {
  echo "<div>";
  echo "<img src='" . $row["image_url"] . "' alt='" . $row["name"] . "' style='width: 100px; height: 100px;'>";
  echo "<p>" . $row["name"] . " - Stock: " . $row["stock"] . "</p>";
  echo "</div>";
}

// Sales
$sql = "SELECT s.name, COUNT(p.shoe_id) AS sold, SUM(s.price) AS earnings
        FROM purchases p
        JOIN shoes s ON p.shoe_id = s.id
        GROUP BY s.name";
$result = $conn->query($sql);

echo "<h2>Sales and Earnings</h2>";
while ($row = $result->fetch_assoc()) {
  echo "<div>";
  echo "<p>" . $row["name"] . " - Sold: " . $row["sold"] . "</p>";
  echo "<p>Earnings: $" . $row["earnings"] . "</p>";
  echo "</div>";
}

$conn->close();
?>
