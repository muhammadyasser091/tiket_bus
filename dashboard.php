<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Dashboard</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f0f7ff;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .dashboard {
      background: #fff;
      border: 2px solid #007BFF;
      border-radius: 15px;
      box-shadow: 0 0 12px rgba(0, 123, 255, 0.2);
      padding: 25px 35px;
      width: 350px;
      text-align: center;
    }

    h2 {
      color: #007BFF;
    }

    a {
      display: block;
      margin: 10px 0;
      text-decoration: none;
      color: #007BFF;
      font-weight: bold;
      transition: 0.3s;
    }

    a:hover {
      color: #0056b3;
      text-decoration: underline;
    }

    .logout {
      margin-top: 20px;
      background-color: #007BFF;
      color: white;
      padding: 10px;
      border-radius: 8px;
      text-decoration: none;
      display: inline-block;
    }

    .logout:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>

  <div class="dashboard">
    <h2>Selamat datang, <?= htmlspecialchars($_SESSION['username']); ?>!</h2>
    
    <?php if ($_SESSION["role"] == "admin"): ?>
      <a href="bus.php">Kelola Bus</a>
      <a href="jadwal.php">Kelola Jadwal</a>
      <a href="penumpang.php">Kelola Penumpang</a>
      <a href="pemesanan.php">Kelola Pemesanan</a>
    <?php else: ?>
      <a href="pemesanan.php">Lihat Tiket Saya</a>
    <?php endif; ?>

    <a href="logout.php" class="logout">Logout</a>
  </div>

</body>
</html>
