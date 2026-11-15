<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: pembelian.php");
    exit;
}

$nama_produk = mysqli_real_escape_string($connect, trim($_POST['nama_produk']));
$jumlah = (int) $_POST['jumlah'];

$pesan = "";
$berhasil = false;
$produk = null;
$total = 0;

if ($nama_produk === "" || $jumlah < 1) {
    $pesan = "Nama produk dan jumlah tidak valid.";
} else {
    $data = mysqli_query($connect, "select * from produk where NamaProduk='$nama_produk'");
    $produk = mysqli_fetch_array($data);

    if (!$produk) {
        $pesan = "Produk tidak ditemukan.";
    } elseif ($produk['Stok'] < $jumlah) {
        $pesan = "Stok tidak cukup. Stok tersedia: " . $produk['Stok'];
    } else {
        mysqli_query($connect, "update produk set Stok = Stok - $jumlah where ProdukID='" . $produk['ProdukID'] . "' and Stok >= $jumlah");

        if (mysqli_affected_rows($connect) > 0) {
            $berhasil = true;
            $total = $produk['Harga'] * $jumlah;
        } else {
            $pesan = "Pembelian gagal diproses, silahkan coba lagi.";
        }
    }
}
?>

<body>
    <link rel="stylesheet" href="style.css">
    <?php if ($berhasil) { ?>
        <h1>Pembelian Berhasil</h1>
        <table border="1">
            <tr>
                <td>Nama Produk</td>
                <td><?php echo htmlspecialchars($produk['NamaProduk']); ?></td>
            </tr>
            <tr>
                <td>Harga</td>
                <td><?php echo $produk['Harga']; ?></td>
            </tr>
            <tr>
                <td>Jumlah</td>
                <td><?php echo $jumlah; ?></td>
            </tr>
            <tr>
                <td>Total Harga</td>
                <td><?php echo $total; ?></td>
            </tr>
        </table>
    <?php } else { ?>
        <h1>Pembelian Gagal</h1>
        <p><?php echo htmlspecialchars($pesan); ?></p>
    <?php } ?>
    <br>
    <a href="pembelian.php">Beli Lagi</a>
    <br>
    <a href="beranda.php">Beranda</a>
</body>

</html>