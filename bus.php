<?php
include "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST["nama"];
    $plat = $_POST["plat"];
    $kapasitas = $_POST["kapasitas"];
    $conn->query("INSERT INTO bus (nama, plat_nomor, kapasitas) VALUES ('$nama', '$plat', '$kapasitas')");
}
?>

<h2>Data Bus</h2>
<form method="POST">
  <input name="nama" placeholder="Nama Bus"><br>
  <input name="plat" placeholder="Plat Nomor"><br>
  <input name="kapasitas" type="number" placeholder="Kapasitas"><br>
  <button type="submit">Tambah</button>
</form>

<table border="1">
<tr><th>Nama</th><th>Plat</th><th>Kapasitas</th></tr>
<?php
$result = $conn->query("SELECT * FROM bus");
while ($row = $result->fetch_assoc()) {
    echo "<tr><td>{$row['nama']}</td><td>{$row['plat_nomor']}</td><td>{$row['kapasitas']}</td></tr>";
}
?>
</table>
