<?php
include "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_penumpang = $_POST["id_penumpang"];
    $id_jadwal = $_POST["id_jadwal"];
    $jumlah = $_POST["jumlah"];
    $status = $_POST["status"];

    $sql = "INSERT INTO pemesanan (id_penumpang, id_jadwal, jumlah_tiket, status)
            VALUES ('$id_penumpang', '$id_jadwal', '$jumlah', '$status')";
    $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data Pemesanan Tiket Bus</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style>
  body {
    font-family: 'Poppins', sans-serif;
    background: url('https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&w=1400&q=80') no-repeat center center fixed;
    background-size: cover;
    margin: 0;
    padding: 0;
    color: #333;
  }

  .container {
    background-color: rgba(255, 255, 255, 0.92);
    width: 90%;
    max-width: 900px;
    margin: 40px auto;
    padding: 30px 40px;
    border-radius: 16px;
    box-shadow: 0 8px 16px rgba(0,0,0,0.2);
  }

  h2 {
    text-align: center;
    color: #007BFF;
    margin-bottom: 25px;
  }

  form {
    margin-bottom: 25px;
  }

  label {
    font-weight: 600;
  }

  select, input {
    width: 100%;
    padding: 8px;
    margin-top: 6px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 6px;
    transition: border-color 0.3s;
  }

  input:focus, select:focus {
    border-color: #007BFF;
    outline: none;
  }

  button {
    background-color: #007BFF;
    border: none;
    color: white;
    padding: 10px 20px;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    transition: background-color 0.3s;
  }

  button:hover {
    background-color: #0056b3;
  }

  table {
    width: 100%;
    border-collapse: collapse;
    background-color: white;
    border-radius: 10px;
    overflow: hidden;
  }

  th {
    background-color: #007BFF;
    color: white;
    padding: 10px;
  }

  td {
    padding: 10px;
    text-align: center;
    border-bottom: 1px solid #ddd;
  }

  tr:hover {
    background-color: #f0f8ff;
  }

  a {
    color: #007BFF;
    text-decoration: none;
    font-weight: 600;
  }

  a:hover {
    text-decoration: underline;
  }

  hr {
    border: 0;
    height: 1px;
    background: #ccc;
    margin: 30px 0;
  }
</style>
</head>
<body>

<div class="container">
  <h2>🚌 Data Pemesanan Tiket Bus</h2>

  <form method="POST">
    <label>Penumpang:</label>
    <select name="id_penumpang" required>
      <option value="">-- Pilih Penumpang --</option>
      <?php
      $penumpang = $conn->query("SELECT * FROM penumpang");
      while ($p = $penumpang->fetch_assoc()) {
          echo "<option value='{$p['id_penumpang']}'>{$p['nama_penumpang']}</option>";
      }
      ?>
    </select>

    <label>Jadwal:</label>
    <select name="id_jadwal" required>
      <option value="">-- Pilih Jadwal --</option>
      <?php
      $jadwal = $conn->query("SELECT * FROM jadwal");
      while ($j = $jadwal->fetch_assoc()) {
          echo "<option value='{$j['id_jadwal']}'>{$j['tujuan']} - {$j['waktu_berangkat']}</option>";
      }
      ?>
    </select>

    <label>Jumlah Tiket:</label>
    <input name="jumlah" type="number" min="1" placeholder="Masukkan jumlah tiket" required>

    <label>Status:</label>
    <select name="status" required>
      <option value="Menunggu">Belum Bayar</option>
      <option value="Dikonfirmasi">Sudah Bayar</option>
      <option value="Dibatalkan">Dibatalkan</option>
    </select>

    <button type="submit">Tambah Pemesanan</button>
  </form>

  <hr>

  <h3>📋 Daftar Pemesanan</h3>
  <table>
    <tr>
      <th>Penumpang</th>
      <th>Tujuan</th>
      <th>Jumlah Tiket</th>
      <th>Status</th>
      <th>Aksi</th>
    </tr>
    <?php
    $result = $conn->query("
      SELECT p.id_pemesanan, pn.nama_penumpang, j.tujuan, p.jumlah_tiket, p.status
      FROM pemesanan p
      JOIN penumpang pn ON p.id_penumpang = pn.id_penumpang
      JOIN jadwal j ON p.id_jadwal = j.id_jadwal
    ");

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
          <td>{$row['nama_penumpang']}</td>
          <td>{$row['tujuan']}</td>
          <td>{$row['jumlah_tiket']}</td>
          <td style='color:" . ($row['status'] == 'Dikonfirmasi' ? 'green' : 'red') . "; font-weight:600;'>{$row['status']}</td>
          <td><a href='cetak_tiket.php?id={$row['id_pemesanan']}'>Cetak Tiket</a></td>
        </tr>";
    }
    ?>
  </table>
</div>

</body>
</html>
