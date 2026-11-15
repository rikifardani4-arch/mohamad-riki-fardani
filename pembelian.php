<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <link rel ="stylesheet" href="style.css"> 
    <h1>Pembelian Produk</h1>
    <a href="beranda.php">Beranda</a>
    <h3>Daftar Barang</h3>
    <table border="1">
        <tr>
            <th>NO</th>
            <th>NamaProduk</th>
            <th>Harga</th>
            <th>Stok</th>
</tr>
<?php
include 'koneksi.php';
    $no = 1;
    $data = mysqli_query($connect, "select * from produk");
    while ($d = mysqli_fetch_array($data)) {
    ?>
        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo htmlspecialchars($d['NamaProduk']); ?></td>
            <td><?php echo $d['Harga']; ?></td>
            <td><?php echo $d['Stok']; ?></td>
        </tr>
    <?php
    }
    ?>
</table>
<br>
<form method="post" action="proses_pembelian.php">
    <label for="nama_produk">Nama Produk:</label>
    <input type="text" name="nama_produk" id="nama_produk" required><br><br>

    <label for="jumlah">Jumlah:</label>
    <input type="number" name="jumlah" id="jumlah" required><br><br>

    <input type="submit" value="Beli">
</form>

</body>

</html>