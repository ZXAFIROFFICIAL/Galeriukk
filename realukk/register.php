<?php
include 'includes/config.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrasi - Galeri Foto</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        @charset "utf-8";

        * {
            padding: 0;
            margin: 0;
            font-family: 'Quicksand', sans-serif;
            box-sizing: border-box;
        }

        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .box-login {
            width: 90%;
            max-width: 400px;
            padding: 30px;
            border: 1px solid #ddd;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .box-login h2 {
            text-align: center;
            margin-bottom: 20px;
            font-weight: 600;
            color: #333;
        }

        .input-control {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .input-control:focus {
            border-color: #1FAD9F;
            outline: none;
            box-shadow: 0 0 8px rgba(52, 152, 219, 0.2);
        }

        .btn {
            width: 100%;
            padding: 12px;
            background-color: #1FAD9F;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #007bff;
        }

        .box-login p {
            margin-top: 15px;
            color: #777;
            font-size: 14px;
            text-align: center;
        }

        .box-login a {
            color: #1FAD9F;
            font-weight: 500;
        }

        .box-login a:hover {
            text-decoration: underline;
        }

        a {
            text-decoration: none;
            /* Hilangkan garis bawah */
            color: inherit;
            /* Pertahankan warna teks sesuai dengan elemen sekitarnya */
        }

        a:hover {
            color: #007BFF;
            /* Berikan warna saat di-hover, opsional */
        }

        /* Media Queries untuk Responsif */
        @media (max-width: 480px) {
            .box-login {
                padding: 20px;
            }

            .box-login h2 {
                margin-bottom: 20px;
            }

            .input-control {
                padding: 10px;
            }

            .btn {
                padding: 12px;
            }
        }
    </style>
</head>

<body>
    <div class="box-login">
        <h2>Registrasi Akun</h2>
        <form id="registerForm" method="POST" onsubmit="return validateForm()">
            <input type="text" id="nama" name="nama" placeholder="Nama User" class="input-control" required>
            <input type="text" id="user" name="user" placeholder="Username" class="input-control" required>
            <input type="password" id="pass" name="pass" placeholder="Password" class="input-control" required>
            <input type="text" id="tlp" name="tlp" placeholder="Nomor Telpon" class="input-control" required>
            <input type="email" id="email" name="email" placeholder="E-mail" class="input-control" required>
            <input type="text" id="almt" name="almt" placeholder="Alamat" class="input-control" required>
            <input type="submit" name="submit" value="Submit" class="btn">
        </form>

        <script>
            function validateForm() {
                // Ambil semua elemen input
                var inputs = document.querySelectorAll('.input-control');
                var isValid = true;

                // Periksa apakah ada input yang kosong
                inputs.forEach(function(input) {
                    if (input.value.trim() === '') {
                        isValid = false;
                        alert('Field ' + input.placeholder + ' tidak boleh kosong.');
                    }
                });

                // Mencegah submit jika ada field kosong
                return isValid;
            }
        </script>
        <?php
        if (isset($_POST['submit'])) {
            $nama = ucwords($_POST['nama']);
            $username = $_POST['user'];
            $password = password_hash($_POST['pass'], PASSWORD_DEFAULT);
            $telpon = $_POST['tlp'];
            $mail = $_POST['email'];
            $alamat = ucwords($_POST['almt']);

            $insert = mysqli_query($conn, "INSERT INTO tb_admin VALUES (
                null,
                '" . $nama . "',
                '" . $username . "',
                '" . $password . "',
                '" . $telpon . "',
                '" . $mail . "',
                '" . $alamat . "',
                NULL, 
                NULL)");

            if ($insert) {
                echo '<script>alert("Registrasi berhasil")</script>';
                echo '<script>window.location="login.php"</script>';
            } else {
                echo 'Gagal: ' . mysqli_error($conn);
            }
        }
        ?>
        <p>Sudah Punya akun? Login <a href="login.php">Disini</a></p>
        <p>Atau Klik <a href="index.php">Kembali</a></p>
    </div>
</body>

</html>