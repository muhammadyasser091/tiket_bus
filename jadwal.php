<?php
include "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_bus = $_POST["id_bus"];
    $tujuan = $_POST["tujuan"];
    $waktu = $_POST["waktu"];
    $harga = $_POST["harga"];
    $conn->query("INSERT INTO jadwal (id_bus, tujuan, waktu_berangkat, harga) VALUES ('$id_bus', '$tujuan', '$waktu', '$harga')");
}
?>

<h2>Data Jadwal</h2>
<form method="POST">
  <select name="id_bus">
    <?php
    $bus = $conn->query("SELECT * FROM bus");
    while ($b = $bus->fetch_assoc()) {
        echo "<option value='{$b['id']}'>{$b['nama']}</option>";
    }
    ?>
  </select><br>
  <input name="tujuan" placeholder="Tujuan"><br>
  <input name="waktu" type="datetime-local"><br>
  <input name="harga" type="number" placeholder="Harga"><br>
  <button type="submit">Tambah</button>
</form>

<table border="1">
<tr><th>Bus</th><th>Tujuan</th><th>Waktu</th><th>Harga</th></tr>
<?php
$result = $conn->query("SELECT jadwal.*, bus.nama FROM jadwal JOIN bus ON jadwal.id_bus = bus.id");
while ($row = $result->fetch_assoc()) {
    echo "<tr><td>{$row['nama']}</td><td>{$row['tujuan']}</td><td>{$row['waktu_berangkat']}</td><td>{$row['harga']}</td></tr>";
}
?>
</table>
