<?php
// Hubungkan ke database
include "koneksi.php";

// Pastikan ada parameter ID di URL
if (!isset($_GET['id'])) {
    die("ID pemesanan tidak ditemukan.");
}

$id_pemesanan = $_GET['id'];

// Ambil data pemesanan berdasarkan ID
$query = "
SELECT 
    pemesanan.id_pemesanan, 
    penumpang.nama_penumpang AS nama_penumpang, 
    jadwal.tujuan, 
    jadwal.waktu_berangkat,
    pemesanan.jumlah_tiket, 
    pemesanan.total_harga,
    pemesanan.status, 
    pemesanan.tanggal_pesan
FROM pemesanan
JOIN penumpang ON pemesanan.id_penumpang = penumpang.id_penumpang
JOIN jadwal ON pemesanan.id_jadwal = jadwal.id_jadwal
WHERE pemesanan.id_pemesanan = '$id_pemesanan'
";

$result = $conn->query($query);

if ($result->num_rows == 0) {
    die("Data pemesanan tidak ditemukan.");
}

$data = $result->fetch_assoc();

// Buat link QR Code (pakai API gratis dari goqr.me)
$qr_url = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=TiketBus-" . $data['id_pemesanan'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Cetak Tiket Bus</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style>
body {
    font-family: 'Poppins', sans-serif;
    background: #f3f6fb;
    color: #333;
    padding: 40px;
}
.ticket {
    background-color: #fff;
    width: 650px;
    margin: 0 auto;
    padding: 30px 40px;
    border-radius: 12px;
    box-shadow: 0 0 15px rgba(0,0,0,0.2);
    position: relative;
}
.header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 3px solid #007BFF;
    padding-bottom: 10px;
}
.header img {
    width: 80px;
}
.header h2 {
    color: #007BFF;
    margin: 0;
}
.info {
    margin-top: 20px;
    font-size: 16px;
    line-height: 1.8;
}
.label {
    font-weight: 600;
    color: #007BFF;
}
.qr {
    position: absolute;
    top: 30px;
    right: 30px;
}
.qr img {
    border: 2px solid #007BFF;
    border-radius: 6px;
}
.print {
    text-align: center;
    margin-top: 30px;
}
button {
    background-color: #007BFF;
    color: white;
    border: none;
    padding: 10px 25px;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
}
button:hover {
    background-color: #0056b3;
}
@media print {
    button {
        display: none;
    }
    body {
        background: none;
    }
    .ticket {
        box-shadow: none;
        border: 1px solid #ccc;
    }
}
</style>
</head>
<body>

<div class="ticket">
    <div class="header">
        <div>
            <img src="bus.jpg" alt="Bus Logo">
        </div>
        <h2>🎫 Tiket Pemesanan Bus</h2>
        <div class="qr">
            <img src="<?= $qr_url ?>" alt="QR Code">
        </div>
    </div>

    <div class="info">
        <p><span class="label">Nama Penumpang:</span> <?= $data['nama_penumpang']; ?></p>
        <p><span class="label">Tujuan:</span> <?= $data['tujuan']; ?></p>
        <p><span class="label">Waktu Berangkat:</span> <?= $data['waktu_berangkat']; ?></p>
        <p><span class="label">Jumlah Tiket:</span> <?= $data['jumlah_tiket']; ?></p>
        <p><span class="label">Total Harga:</span> Rp <?= number_format($data['total_harga'], 0, ',', '.'); ?></p>
        <p><span class="label">Status:</span> <?= ucfirst($data['status']); ?></p>
        <p><span class="label">Tanggal Pemesanan:</span> <?= $data['tanggal_pesan']; ?></p>
    </div>

    <div class="print">
        <button onclick="window.print()">🖨 Cetak Tiket</button>
    </div>
</div>

</body>
</html>
