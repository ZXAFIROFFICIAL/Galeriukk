<?php
session_start();
if ($_SESSION['status_login'] != true) {
    echo '<script>window.location="login.php"</script>';
}

// Ensure db.php is included
include 'includes/config.php';

$query = mysqli_query($conn, "SELECT * FROM tb_admin WHERE admin_id ='" . $_SESSION['id'] . "'");
$d = mysqli_fetch_object($query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Password</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Styling same as before */
        .box {
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .input-control {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 10px;
            font-size: 16px;
            background-color: #fff;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .input-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
            outline: none;
        }

        .btn {
            width: 100%;
            padding: 12px;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .btn:hover {
            background-color: #2980b9;
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
        }

        body {
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
        }

        .box:focus-within {
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        a {
            text-decoration: none;
            color: #007bff;
            transition: color 0.3s ease;
        }

        @media (max-width: 600px) {
            .box {
                width: 90%;
            }
        }
    </style>
</head>

<body>
    <div class="box">
        <h3>Ubah Password</h3>
        <form action="" method="POST">
            <input type="password" name="pass1" placeholder="Password Baru" class="input-control" required>
            <input type="password" name="pass2" placeholder="Konfirmasi Password Baru" class="input-control" required>
            <input type="submit" name="ubah_password" value="Ubah Password" class="btn">
            <p>Atau Klik <a href="profil.php">Kembali</a></p>
        </form>
        <?php
        if (isset($_POST['ubah_password'])) {
            $pass1   = $_POST['pass1'];
            $pass2   = $_POST['pass2'];

            if ($pass2 != $pass1) {
                echo '<script>alert("Konfirmasi Password Baru tidak sesuai")</script>';
            } else {
                // Hash the new password using password_hash
                $password = password_hash($pass1, PASSWORD_DEFAULT);

                // Update the hashed password in the database
                $u_pass = mysqli_query($conn, "UPDATE tb_admin SET 
									  password = '" . $password . "'
									  WHERE admin_id = '" . $d->admin_id . "'");

                if ($u_pass) {
                    echo '<script>alert("Ubah data berhasil")</script>';
                    echo '<script>window.location="profil.php"</script>';
                } else {
                    echo 'gagal ' . mysqli_error($conn);
                }
            }
        }
        ?>
    </div>
</body>

</html>