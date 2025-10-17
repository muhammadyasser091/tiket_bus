<?php
include "koneksi.php";

$status = ""; // sukses / error
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $cek = $conn->query("SELECT * FROM users WHERE username='$username'");
    if ($cek->num_rows > 0) {
        $status = "error";
        $message = "Username sudah digunakan!";
    } else {
        $conn->query("INSERT INTO users (username, password, role) VALUES ('$username', '$password', 'pelanggan')");
        $status = "success";
        $message = "Registrasi berhasil! Silakan login.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Registrasi Pelanggan</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f0f7ff;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    form {
      background: #fff;
      padding: 25px 35px;
      border: 2px solid #007BFF;
      border-radius: 15px;
      box-shadow: 0 0 12px rgba(0, 123, 255, 0.2);
      width: 320px;
    }

    h2 {
      text-align: center;
      color: #007BFF;
    }

    label {
      font-weight: bold;
      color: #333;
    }

    input {
      width: 100%;
      padding: 8px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 8px;
      transition: border-color 0.3s;
    }

    input:focus {
      border-color: #007BFF;
      outline: none;
    }

    button {
      width: 100%;
      padding: 10px;
      background-color: #007BFF;
      border: none;
      border-radius: 8px;
      color: white;
      font-weight: bold;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    button:hover {
      background-color: #0056b3;
    }

    p {
      text-align: center;
      margin-top: 15px;
    }

    a {
      color: #007BFF;
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <div>
    <h2>Registrasi Pelanggan</h2>
    <form method="POST">
      <label>Username:</label><br>
      <input name="username" required><br><br>

      <label>Password:</label><br>
      <input name="password" type="password" required><br><br>

      <button type="submit">Daftar</button>
    </form>

    <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
  </div>

  <?php if (!empty($message)): ?>
  <script>
    Swal.fire({
      icon: '<?php echo $status; ?>',
      title: '<?php echo ucfirst($status); ?>',
      text: '<?php echo $message; ?>',
      confirmButtonColor: '#007BFF'
    });
  </script>
  <?php endif; ?>

</body>
</html>
