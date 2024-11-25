<?php
include('koneksi.php');

$nama = trim($_POST['nama']);
$uploadSuccess = false;

// Validate name
if (empty($nama)) {
    echo "Nama masih kosong.<br/><a href='input_foto.php'>Kembali</a>";
    exit;
}

// File upload validation
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['foto']['name'];
    $tmp_dir = $_FILES['foto']['tmp_name'];
    $ukuran = $_FILES['foto']['size'];

    $direktori = 'gambar/';
    $ektensi = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    $valid_ektensi = array('jpeg', 'jpg', 'png', 'gif');
    $gambar = rand(1000, 1000000) . "." . $ektensi;

    // Validate file extension
    if (in_array($ektensi, $valid_ektensi)) {
        // Validate file size (< 1MB)
        if ($ukuran < 1000000) {
            // Move uploaded file
            if (move_uploaded_file($tmp_dir, $direktori . $gambar)) {
                $uploadSuccess = true;
            } else {
                echo "Gagal mengunggah gambar.<br/><a href='input_foto.php'>Kembali</a>";
                exit;
            }
        } else {
            echo "Ukuran gambar terlalu besar (maksimal 1MB).<br/><a href='input_foto.php'>Kembali</a>";
            exit;
        }
    } else {
        echo "Format file tidak didukung. Hanya jpeg, jpg, png, gif.<br/><a href='input_foto.php'>Kembali</a>";
        exit;
    }
} else {
    echo "Tidak ada file yang diunggah atau terjadi kesalahan.<br/><a href='input_foto.php'>Kembali</a>";
    exit;
}

// Save to database
if ($uploadSuccess) {
    $stmt = $koneksi->prepare("INSERT INTO mahasiswa (id, nama, foto) VALUES (NULL, ?, ?)");
    $stmt->bind_param("ss", $nama, $gambar);

    if ($stmt->execute()) {
        echo "Berhasil disimpan.<br/>";
        echo "Nama: $nama<br/>";
        echo "<img src='$direktori$gambar' height='200'><br/>";
        echo "<a href='tampil_foto.php'>Lihat Halaman Berikutnya</a>";
    } else {
        echo "Gagal menyimpan ke database: " . $stmt->error . "<br/><a href='input_foto.php'>Kembali</a>";
    }

    $stmt->close();
}
?>