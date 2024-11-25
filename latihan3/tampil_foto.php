<?php
include('koneksi.php');

// Prepare the SQL query
$perintah = "SELECT * FROM mahasiswa ORDER BY id DESC";
$query = $koneksi->query($perintah);

// Check if query executed successfully
if (!$query) {
    die("Query gagal: " . $koneksi->error);
}
?>
<html>
<head>
    <title>Halaman Tampil Foto</title>
</head>
<body>
<table width="500" border="1">
    <tr>
        <th colspan="4">
            MENAMPILKAN FOTO / <a href="input_foto.php">TAMBAH DATA</a>
        </th>
    </tr>
    <tr>
        <td>NO</td>
        <td>NAMA</td>
        <td>FOTO</td>
        <td>DELETE</td>
    </tr>
    <?php
    while ($data = $query->fetch_assoc()) {
        ?>
        <tr>
            <td><?php echo $data['id']; ?></td>
            <td><?php echo htmlspecialchars($data['nama'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td align="center">
                <img src="gambar/<?php echo htmlspecialchars($data['foto'], ENT_QUOTES, 'UTF-8'); ?>" width="60" height="80">
            </td>
            <td align="center">
                <a href="delete.php?del=<?php echo urlencode($data['id']); ?>">DELETE</a>
            </td>
        </tr>
        <?php
    }
    ?>
</table>
</body>
</html>