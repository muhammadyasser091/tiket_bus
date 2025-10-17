<?php
session_start();
include "koneksi.php";

$login_status = ""; // buat deteksi hasil login

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = $conn->query("SELECT * FROM users WHERE username='$username' AND password='$password'");
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $_SESSION["username"] = $user["username"];
        $_SESSION["role"] = $user["role"];
        $login_status = "success";
    } else {
        $login_status = "error";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login Pelanggan</title>
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
      position: relative;
    }

    h2 {
      text-align: center;
      color: #007BFF;
    }

    input {
      width: 100%;
      padding: 8px;
      margin-top: 8px;
      border: 1px solid #ccc;
      border-radius: 8px;
      transition: border-color 0.3s;
    }

    input:focus {
      border-color: #007BFF;
      outline: none;
    }

    .password-container {
      position: relative;
      display: flex;
      align-items: center;
    }

    .toggle-password {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      color: #555;
      font-size: 18px;
    }

    .toggle-password:hover {
      color: #007BFF;
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
      margin-top: 10px;
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
    <h2>Login</h2>
    <form method="POST">
      <input name="username" placeholder="Username" required><br><br>

      <div class="password-container">
        <input name="password" id="password" type="password" placeholder="Password" required>
        <span class="toggle-password" onclick="togglePassword()">👁️</span>
      </div>

      <br>
      <button type="submit">Login</button>
    </form>

    <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
  </div>

  <script>
    function togglePassword() {
      const passInput = document.getElementById("password");
      const icon = document.querySelector(".toggle-password");
      if (passInput.type === "password") {
        passInput.type = "text";
        icon.textContent = "🙈";
      } else {
        passInput.type = "password";
        icon.textContent = "👁️";
      }
    }

    // Cek status login dari PHP
    const status = "<?php echo $login_status; ?>";

    if (status === "success") {
      Swal.fire({
        icon: 'success',
        title: 'Login Berhasil!',
        text: 'Selamat datang!',
        showConfirmButton: false,
        timer: 1500
      }).then(() => {
        window.location.href = 'dashboard.php';
      });
    } else if (status === "error") {
      Swal.fire({
        icon: 'error',
        title: 'Login Gagal',
        text: 'Username atau password salah!',
        confirmButtonColor: '#007BFF'
      });
    }
  </script>

</body>
</html>
