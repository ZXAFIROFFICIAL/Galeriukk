<?php
session_start();
include 'includes/config.php';

// Cek apakah session 'id' sudah ada
if (!isset($_SESSION['id'])) {
    echo '<script>alert("Anda harus login terlebih dahulu!");</script>';
    echo '<script>window.location="login.php";</script>';
    exit;
}

// Ambil data admin dari session
$admin_id = $_SESSION['id'];

// Query untuk mengambil data admin dari database
$query = mysqli_query($conn, "SELECT * FROM tb_admin WHERE admin_id = '$admin_id'");
$d = mysqli_fetch_object($query);

// Jika data tidak ditemukan
if (!$d) {
    echo '<script>alert("Data admin tidak ditemukan!");</script>';
    echo '<script>window.location="profil.php";</script>';
    exit;
}

if (isset($_POST['submit'])) {
    // Ambil data dari form
    $nama   = $_POST['nama'];
    $user   = $_POST['user'];
    $hp     = $_POST['hp'];
    $email  = $_POST['email'];
    $alamat = $_POST['alamat'];

    // Update data admin
    $update = mysqli_query($conn, "UPDATE tb_admin SET 
              admin_name = '$nama',
              username = '$user',
              admin_telp = '$hp',
              admin_email = '$email',
              admin_address = '$alamat'
              WHERE admin_id = '$admin_id'");

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
    <title>Edit Profil</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Style untuk container */
        .container {
            max-width: 500px;
            margin: 50px auto;
            background-color: #f9f9f9;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        /* Judul h3 */
        h3 {
            font-family: 'Arial', sans-serif;
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        /* Style untuk input fields */
        .input-control {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #fff;
            font-size: 16px;
            color: #333;
            transition: all 0.3s ease;
        }

        /* Hover effect untuk input fields */
        .input-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
            outline: none;
        }

        /* Style untuk tombol */
        .btn-primary {
            background-color: #3498db;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 20px;
            width: 100%;
        }

        /* Hover effect untuk tombol */
        .btn-primary:hover {
            background-color: #2980b9;
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
        }

        a {
            text-decoration: none;
            /* Remove underline from links */
            color: #007bff;
            /* Optional: change color for better visibility */
            transition: color 0.3s ease;
            /* Smooth color transition */
        }

        /* Style responsif */
        @media (max-width: 600px) {
            .container {
                width: 90%;
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h3>Edit Profil</h3>
        <form action="" method="POST">
            <input type="text" name="nama" placeholder="Nama Lengkap" class="input-control" value="<?php echo $d->admin_name; ?>" required>
            <input type="text" name="user" placeholder="Username" class="input-control" value="<?php echo $d->username; ?>" required>
            <input type="text" name="hp" placeholder="No Hp" class="input-control" value="<?php echo $d->admin_telp; ?>" required>
            <input type="email" name="email" placeholder="Email" class="input-control" value="<?php echo $d->admin_email; ?>" required>
            <input type="text" name="alamat" placeholder="Alamat" class="input-control" value="<?php echo $d->admin_address; ?>" required>
            <input type="submit" name="submit" value="Simpan Perubahan" class="btn btn-primary">
            <p>Atau Klik <a href="profil.php">Kembali</a></p>
        </form>
    </div>
</body>

</html>