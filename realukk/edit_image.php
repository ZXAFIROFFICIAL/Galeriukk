<?php
include 'includes/config.php';  // Sertakan koneksi database

// Dapatkan ID gambar dari URL
$id = $_GET['id'];

// Ambil data gambar berdasarkan ID
$gambar = mysqli_query($conn, "SELECT * FROM tb_image WHERE image_id = '$id'");
if (mysqli_num_rows($gambar) == 0) {
    echo '<script>alert("Data tidak ditemukan."); window.location="profil.php";</script>';
    exit;
}
$p = mysqli_fetch_object($gambar);

// Ambil kategori dari database
$kategori_query = mysqli_query($conn, "SELECT * FROM tb_category");
$categories = [];
while ($row = mysqli_fetch_assoc($kategori_query)) {
    $categories[] = $row;
}

// Jika form disubmit
if (isset($_POST['submit'])) {
    $nama      = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $status    = $_POST['status'];
    $kategori  = $_POST['kategori']; // Menyimpan kategori baru
    $foto      = $_POST['foto']; // Gambar lama

    // Gambar baru
    $filename = $_FILES['gambar']['name'];
    $tmp_name = $_FILES['gambar']['tmp_name'];

    // Jika admin mengganti gambar
    if ($filename != '') {
        $type1 = explode('.', $filename);
        $type2 = strtolower(end($type1));  // Mengubah ekstensi ke huruf kecil
        $newname = 'foto' . time() . '.' . $type2;

        // Format file yang diizinkan
        $tipe_diizinkan = array('jpg', 'jpeg', 'png', 'gif');
        if (!in_array($type2, $tipe_diizinkan)) {
            echo '<script>alert("Format file tidak diizinkan")</script>';
        } else {
            // Hapus gambar lama
            if (file_exists('./foto/' . $foto)) {
                unlink('./foto/' . $foto);
            }
            // Pindahkan gambar baru
            move_uploaded_file($tmp_name, './foto/' . $newname);
            $namagambar = $newname;
        }
    } else {
        // Jika admin tidak mengganti gambar
        $namagambar = $foto;
    }

    // Update data
    $update = mysqli_query($conn, "UPDATE tb_image SET
                                    image_name = '$nama',
                                    image_description = '$deskripsi',
                                    image = '$namagambar',
                                    image_status = '$status',
                                    category_id = '$kategori' 
                                    WHERE image_id = '$id'");

    if ($update) {
        echo '<script>alert("Ubah data berhasil")</script>';
        echo '<script>window.location="profil.php"</script>';
    } else {
        echo 'Gagal: ' . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Foto</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h3 {
            text-align: center;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

        .input-control {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .btn {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #218838;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: none;
            color: #0056b3;
        }

        .info-text {
            text-align: center;
            margin: 10px 0;
            color: #555;
        }

        a {
            text-decoration: none;
            /* Remove underline from links */
            color: #007bff;
            /* Optional: change color for better visibility */
            transition: color 0.3s ease;
            /* Smooth color transition */
        }
    </style>
</head>

<body>
    <div class="container">
        <h3>Edit Foto</h3>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="nama">Nama Foto</label>
            <input type="text" name="nama" id="nama" class="input-control" placeholder="Nama Foto" value="<?php echo $p->image_name ?>" required>

            <img src="./foto/<?php echo $p->image ?>" width="100px" style="display: block; margin: 0 auto; margin-bottom: 15px;">

            <input type="hidden" name="foto" value="<?php echo $p->image ?>">
            <input type="file" name="gambar" class="input-control">

            <label for="deskripsi">Deskripsi</label>
            <textarea class="input-control" name="deskripsi" id="deskripsi" placeholder="Deskripsi"><?php echo $p->image_description ?></textarea>

            <label for="kategori">Kategori</label>
            <select class="input-control" name="kategori" id="kategori" required>
                <option value="">--Pilih Kategori--</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['category_id']; ?>" <?php echo ($category['category_id'] == $p->category_id) ? 'selected' : ''; ?>>
                        <?php echo $category['category_name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="status">Status</label>
            <select class="input-control" name="status" id="status">
                <option value="">--Pilih--</option>
                <option value="1" <?php echo ($p->image_status == 1) ? 'selected' : ''; ?>>Aktif</option>
                <option value="0" <?php echo ($p->image_status == 0) ? 'selected' : ''; ?>>Tidak Aktif</option>
            </select>

            <input type="submit" name="submit" value="Simpan Perubahan" class="btn">
        </form>
        <p class="info-text">Atau Klik <a href="profil.php">Kembali</a></p>
    </div>
</body>

</html>