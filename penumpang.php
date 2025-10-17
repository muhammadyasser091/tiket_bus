<?php
include "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST["nama"];
    $hp = $_POST["hp"];
    $email = $_POST["email"];
    $conn->query("INSERT INTO penumpang (nama, no_hp, email) VALUES ('$nama', '$hp', '$email')");
}
?>

<h2>Data Penumpang</h2>
<form method="POST">
  <input name="nama" placeholder="Nama"><br>
  <input name="hp" placeholder="Nomor HP"><br>
  <input name="email" type="email" placeholder="Email"><br>
  <button type="submit">Tambah</button>
</form>

<table border="1">
<tr><th>Nama</th><th>HP</th><th>Email</th></tr>
<?php
$result = $conn->query("SELECT * FROM penumpang");
while ($row = $result->fetch_assoc()) {
    echo "<tr><td>{$row['nama']}</td><td>{$row['no_hp']}</td><td>{$row['email']}</td></tr>";
}
?>
</table>
