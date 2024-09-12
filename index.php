<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shoe Store</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <header id="header" class="header-1">
    <div class="nav">
      <div class="nav__logo">ShoeStore</div>
      <div id="nav-toggle" class="nav__toggle">☰</div>
      <div id="nav-menu" class="nav__menu">
        <a href="#collection" class="nav__link">Collection</a>
        <a href="#admin" class="nav__link">Admin</a>
      </div>
    </div>
  </header>

  <main>
    <section class="home">
      <div class="home__container">
        <div class="home__sneaker">
          <div class="shoe">
            <div class="shoe__side shoe__side--front"></div>
            <div class="shoe__side shoe__side--back"></div>
            <div class="shoe__side shoe__side--top"></div>
            <div class="shoe__side shoe__side--bottom"></div>
            <div class="shoe__side shoe__side--left"></div>
            <div class="shoe__side shoe__side--right"></div>
          </div>
        </div>
      </div>
    </section>

    <section id="collection" class="section">
      <div class="bd-grid">
        <?php
        // Connect to database
        $conn = new mysqli("localhost", "root", "", "shoestore");

        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }

        // Fetch shoes from database
        $sql = "SELECT * FROM shoes";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo '<div class="sneaker">';
            echo '<img src="' . $row["image_url"] . '" alt="' . $row["name"] . '" class="sneaker__img">';
            echo '<div class="sneaker__name">' . $row["name"] . '</div>';
            echo '<div class="sneaker__preci">$' . $row["price"] . '</div>';
            echo '<form action="purchase.php" method="POST">';
            echo '<input type="hidden" name="shoe_id" value="' . $row["id"] . '">';
            echo '<button type="submit" class="purchase-btn">Purchase</button>';
            echo '</form>';
            echo '</div>';
          }
        } else {
          echo "<p>No shoes available.</p>";
        }

        $conn->close();
        ?>
      </div>
    </section>

    <section id="admin" class="section admin-section">
      <h2>Admin Dashboard</h2>
      <div class="inventory">
        <h3>Inventory</h3>
        <?php
        // Connect to database
        $conn = new mysqli("localhost", "root", "", "shoestore");

        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }

        // Fetch inventory from database
        $sql = "SELECT * FROM shoes";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo '<div class="inventory-item">';
            echo '<img src="' . $row["image_url"] . '" alt="' . $row["name"] . '" class="inventory-img">';
            echo '<div class="inventory-name">' . $row["name"] . '</div>';
            echo '<div class="inventory-stock">Stock: ' . $row["stock"] . '</div>';
            echo '</div>';
          }
        } else {
          echo "<p>No inventory available.</p>";
        }

        $conn->close();
        ?>
      </div>

      <div class="sales">
        <h3>Sales and Earnings</h3>
        <?php
        // Connect to database
        $conn = new mysqli("localhost", "root", "", "shoestore");

        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }

        // Fetch sales data
        $sql = "SELECT s.name, COUNT(p.shoe_id) AS sold, SUM(s.price) AS earnings
                FROM purchases p
                JOIN shoes s ON p.shoe_id = s.id
                GROUP BY s.name";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo '<div class="sales-item">';
            echo '<div class="sales-name">' . $row["name"] . '</div>';
            echo '<div class="sales-sold">Sold: ' . $row["sold"] . '</div>';
            echo '<div class="sales-earnings">Earnings: $' . $row["earnings"] . '</div>';
            echo '</div>';
          }
        } else {
          echo "<p>No sales data available.</p>";
        }

        $conn->close();
        ?>
      </div>
    </section>
  </main>

  <footer class="footer__container">
    <div class="footer__box">
      <h2 class="footer__title">Contact Us</h2>
      <p class="footer__copy">© 2024 ShoeStore. All rights reserved.</p>
    </div>
  </footer>

  <script src="script.js"></script>
</body>
</html>
