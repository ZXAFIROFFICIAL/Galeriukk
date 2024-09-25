<?php
session_start();
if ($_SESSION['status_login'] != true) {
    echo '<script>window.location="login.php"</script>';
}

// Ensure db.php is included
include 'includes/config.php';

$query = mysqli_query($conn, "SELECT * FROM tb_admin WHERE admin_id ='" . $_SESSION['id'] . "'");
$d = mysqli_fetch_object($query);

if (isset($_GET['id'])) {
    $imageId = $_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM tb_image WHERE image_id = '$imageId'");
    $imageData = mysqli_fetch_assoc($result);
    echo json_encode($imageData);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Galeri Foto</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Free HTML5 Website Template by ProBootstrap.com" />
    <meta name="keywords" content="free bootstrap 4, free bootstrap 4 template, free website templates, free html5, free template, free website template, html5, css3, mobile first, responsive" />
    <meta name="author" content="ProBootstrap.com" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- <link href="https://fonts.googleapis.com/css?family=Work+Sans" rel="stylesheet"> -->

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">

    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">

    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Container and Background Styling */
        .section {
            padding: 40px 0;
        }

        .container {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 600px;
            margin: auto;
        }

        /* Profile Header */
        .profile-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .profile-image {
            margin-bottom: 10px;
        }

        .profile-img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e3e3e3;
        }

        .username {
            font-size: 24px;
            font-weight: bold;
            margin: 10px 0;
        }

        /* User Info Display */
        .profile-info {
            text-align: left;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .profile-info p {
            margin: 5px 0;
        }

        /* Profile Actions */
        .profile-actions {
            display: flex;
            justify-content: space-between;
        }

        .btn {
            padding: 10px 15px;
            background-color: #1FAD9F;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }

        .btn-primary {
            background-color: #1FAD9F;
        }

        .btn-secondary {
            background-color: #fd1d1d;
        }

        .btn:hover {
            background-color: #007bff;
        }

        /* Upload Photo Section */
        h3 {
            font-size: 22px;
            margin-top: 30px;
            margin-bottom: 15px;
        }

        /* Form Styles */
        .input-control {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        .input-control:focus {
            border-color: #1FAD9F;
            outline: none;
        }

        /* Uploaded Images Section */
        .uploaded-images {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 20px;
        }

        .image-card {
            margin: 10px;
            text-align: center;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s;
        }

        .image-card:hover {
            transform: scale(1.05);
        }

        .image-thumbnail {
            width: 150px;
            height: 150px;
            object-fit: cover;
        }

        .image-card p {
            margin: 5px;
            font-size: 14px;
            color: #333;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            border-radius: 10px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .edit-button,
        .delete-button {
            background-color: #1FAD9F;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 5px;
            padding: 5px 10px;
        }

        /* Style untuk hasil foto unggah*/

        /* General Styling */
        .gallery-title {
            text-align: center;
            font-family: 'Arial', sans-serif;
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        .uploaded-images-wrapper {
            position: relative;
            overflow: hidden;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .uploaded-images {
            display: flex;
            transition: transform 0.7s ease-in-out;
            will-change: transform;
        }

        .image-row {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        .image-card {
            flex: 0 0 23%;
            /* 4 images per row on desktop (23% per card to allow spacing) */
            margin: 5px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease-in-out;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .image-thumbnail {
            width: 100%;
            border-radius: 10px;
            object-fit: cover;
            transition: transform 0.3s ease, opacity 0.3s ease;
        }

        .image-card:hover .image-thumbnail {
            transform: scale(1.1);
            opacity: 0.8;
        }

        .image-title {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            text-align: center;
            background: rgba(0, 0, 0, 0.6);
            color: #fff;
            padding: 5px 0;
            font-size: 16px;
            font-weight: bold;
        }

        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            opacity: 0;
            transition: opacity 0.5s ease;
        }

        .image-card:hover .image-overlay {
            opacity: 1;
        }

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            .image-card {
                flex: 0 0 48%;
                /* 2 images per row for tablet */
            }
        }

        @media screen and (max-width: 480px) {
            .image-card {
                flex: 0 0 22%;
                /* 3 images per row for mobile */
            }

            .image-title {
                font-size: 9px;
            }
        }
    </style>
</head>

<body>

    <aside class="probootstrap-aside js-probootstrap-aside">
        <a href="#" class="probootstrap-close-menu js-probootstrap-close-menu d-md-none"><span class="oi oi-arrow-left"></span> Close</a>
        <div class="probootstrap-site-logo probootstrap-animate" data-animate-effect="fadeInLeft">
            <a href="#" class="mb-2 d-block probootstrap-logo">GALERI FOTO</a>
            <p class="mb-0">Website Galeri Foto </p>
        </div>
        <div class="probootstrap-overflow">
            <nav class="probootstrap-nav">
                <ul>
                    <li class="probootstrap-animate" data-animate-effect="fadeInLeft"><a href="dashboard.php">Beranda</a></li>
                    <li class="probootstrap-animate" data-animate-effect="fadeInLeft"><a href="galeri1.php">Galeri</a></li>
                    <li class="probootstrap-animate active" data-animate-effect="fadeInLeft"><a href="profil.php">Profil</a></li>
                    <li class="probootstrap-animate" data-animate-effect="fadeInLeft"><a href="keluar.php">Keluar</a></li>
                </ul>
            </nav>
            <footer class="probootstrap-aside-footer probootstrap-animate" data-animate-effect="fadeInLeft">
                <p>&copy; 2024 <a href="#">Zaxkyy</a><br> All Rights Reserved.</p>
            </footer>
        </div>
    </aside>


    <main role="main" class="probootstrap-main js-probootstrap-main">
        <div class="probootstrap-bar">
            <a href="#" class="probootstrap-toggle js-probootstrap-toggle"><span class="oi oi-menu"></span></a>
            <div class="probootstrap-main-site-logo"><a href="profil.php">PROFILE</a></a></div>
        </div>
        <!-- content -->
        <div class="section">
            <div class="container">
                <div class="box">
                    <!-- Profile Image -->
                    <div class="profile-header">
                        <div class="profile-image">
                            <img src="./images/icons/logo.jpg" alt="Profile Image" class="rounded-circle profile-img">
                        </div>
                        <h4 class="username"><?php echo $d->username; ?></h4>
                    </div>

                    <!-- User Info Display -->
                    <div class="profile-info">
                        <p><strong>Nama Lengkap: </strong> <?php echo $d->admin_name; ?></p>
                        <p><strong>No Hp: </strong> <?php echo $d->admin_telp; ?></p>
                        <p><strong>Email: </strong> <?php echo $d->admin_email; ?></p>
                        <p><strong>Alamat: </strong> <?php echo $d->admin_address; ?></p>
                    </div>

                    <!-- Buttons for editing profile and password -->
                    <div class="profile-actions">
                        <a href="edit_profile.php" class="btn btn-primary">Edit Profil</a>
                        <a href="ubah_password.php" class="btn btn-secondary">Ubah Password</a>
                    </div>
                </div>

                <!-- Tambah Foto Button -->
                <h3>Tambah Foto</h3>
                <button class="btn" onclick="openModal('addImageModal')">Tambah Foto</button>

                <!-- Tambah Foto Popup -->
                <div id="addImageModal" class="modal">
                    <div class="modal-content">
                        <span class="close" onclick="closeModal('addImageModal')">&times;</span>
                        <h3>Tambah Foto</h3>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <?php
                            $result = mysqli_query($conn, "SELECT * FROM tb_category");
                            $jsArray = "var prdName = new Array();\n";
                            echo '<select class="input-control" name="kategori" onchange="document.getElementById(\'prd_name\').value = prdName[this.value]" required>';
                            echo '<option>-Pilih Kategori Foto-</option>';
                            while ($row = mysqli_fetch_array($result)) {
                                echo '<option value="' . $row['category_id'] . '">' . $row['category_name'] . '</option>';
                                $jsArray .= "prdName['" . $row['category_id'] . "'] = '" . addslashes($row['category_name']) . "';\n";
                            }
                            echo '</select>'; ?>
                            <input type="hidden" name="nama_kategori" id="prd_name">
                            <input type="hidden" name="adminid" value="<?php echo $_SESSION['a_global']->admin_id ?>">
                            <input type="text" name="namaadmin" class="input-control" value="<?php echo $_SESSION['a_global']->admin_name ?>" readonly>
                            <input type="text" name="nama" class="input-control" placeholder="Nama Foto" required>
                            <textarea class="input-control" name="deskripsi" placeholder="Deskripsi"></textarea><br />
                            <input type="file" name="gambar" class="input-control" required>
                            <select class="input-control" name="status">
                                <option value="">--Pilih--</option>
                                <option value="1">Semua</option>
                                <option value="0">Pribadi</option>
                            </select>
                            <input type="submit" name="submit" value="Kirim" class="btn">
                        </form>
                        <?php
                        if (isset($_POST['submit'])) {
                            $kategori  = $_POST['kategori'];
                            $nama_ka   = $_POST['nama_kategori'];
                            $ida       = $_POST['adminid'];
                            $user      = $_POST['namaadmin'];
                            $nama      = $_POST['nama'];
                            $deskripsi = $_POST['deskripsi'];
                            $status    = $_POST['status'];

                            $filename = $_FILES['gambar']['name'];
                            $tmp_name = $_FILES['gambar']['tmp_name'];
                            $type1 = explode('.', $filename);
                            $type2 = end($type1);
                            $newname = 'foto' . time() . '.' . $type2;

                            $tipe_diizinkan = array('jpg', 'jpeg', 'png', 'gif');
                            if (!in_array($type2, $tipe_diizinkan)) {
                                echo '<script>alert("Format file tidak diizinkan")</script>';
                            } else {
                                move_uploaded_file($tmp_name, './foto/' . $newname);
                                $insert = mysqli_query($conn, "INSERT INTO tb_image VALUES (null, '$kategori', '$nama_ka', '$ida', '$user', '$nama', '$deskripsi', '$newname', '$status', null)");
                                if ($insert) {
                                    echo '<script>alert("Tambah Foto berhasil")</script>';
                                    echo '<script>window.location="profil.php"</script>';
                                } else {
                                    echo 'Gagal: ' . mysqli_error($conn);
                                }
                            }
                        }
                        ?>
                    </div>
                </div>

                <!-- Hasil Foto -->
                <h3 class="gallery-title">Foto yang Diunggah</h3>
                <div class="uploaded-images-wrapper">
                    <div class="uploaded-images">
                        <?php
                        $images = mysqli_query($conn, "SELECT * FROM tb_image WHERE admin_id = '{$_SESSION['a_global']->admin_id}' ORDER BY date_created DESC");
                        $total_images = mysqli_num_rows($images); // Hitung total gambar
                        $images_per_slide_desktop = 8; // 8 gambar per slide untuk desktop (4 di atas, 4 di bawah)
                        $images_per_slide_mobile = 3; // 3 gambar per slide untuk mobile
                        $current_image = 0;

                        if ($total_images > 0) {
                            while ($img = mysqli_fetch_array($images)) {
                                // Pisahkan gambar ke dalam slide
                                if ($current_image % $images_per_slide_desktop == 0) {
                                    echo '<div class="slide">'; // Start slide
                                    echo '<div class="image-row">'; // Start upper row
                                }

                                // Tampilkan gambar
                                echo '<div class="image-card">';
                                echo '<img src="./foto/' . $img['image'] . '" alt="' . $img['image_name'] . '" class="image-thumbnail">';
                                echo '<div class="image-title">' . $img['image_name'] . '</div>';
                                echo '<div class="image-overlay">';
                                echo '<a href="edit_image.php?id=' . $img['image_id'] . '" class="btn btn-primary"><i class="fas fa-edit"></i></a>';
                                echo '<button class="delete-button" data-id="' . $img['image_id'] . '"><i class="fas fa-trash"></i></button>';
                                echo '</div>';
                                echo '</div>';

                                $current_image++;

                                // Pisahkan menjadi dua baris di slide desktop
                                if ($current_image % 4 == 0 && $current_image % $images_per_slide_desktop != 0) {
                                    echo '</div><div class="image-row">'; // Close upper row, start bottom row
                                }

                                // Tutup slide jika sudah penuh dengan gambar
                                if ($current_image % $images_per_slide_desktop == 0 || $current_image == $total_images) {
                                    echo '</div></div>'; // End row and slide
                                }
                            }
                        } else {
                            echo '<p class="no-images">Tidak ada foto yang diunggah.</p>';
                        }
                        ?>
                    </div>
                </div>

                <!-- Form to Create Album -->
                <?php
                if (isset($_POST['create_album'])) {
                    $album_name = mysqli_real_escape_string($conn, $_POST['album_name']);
                    $admin_id = $_SESSION['a_global']->admin_id;

                    $query = "INSERT INTO tb_album (album_name, admin_id) VALUES ('$album_name', '$admin_id')";
                    if (mysqli_query($conn, $query)) {
                        echo '<script>alert("Album created successfully!");</script>';
                    } else {
                        echo '<script>alert("Failed to create album.");</script>';
                    }
                }
                ?>
                <br>
                <!-- Display Albums -->
                <div class="albums">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createAlbumModal">Tambah Album</button>
                    <h3>Album Saya</h3>
                    <?php
                    $albums = mysqli_query($conn, "SELECT * FROM tb_album WHERE admin_id = '{$_SESSION['a_global']->admin_id}'");
                    if (mysqli_num_rows($albums) > 0) {
                        while ($album = mysqli_fetch_array($albums)) {
                            echo '<div class="album" style="margin-bottom: 20px;">'; // Margin between albums
                            echo '<h4>' . $album['album_name'] . '</h4>';

                            // Create a container for buttons
                            echo '<div class="album-buttons" style="display: flex; justify-content: flex-start; gap: 10px; margin-bottom: 10px;">';

                            // Edit button
                            echo '<button class="btn btn-secondary" data-toggle="modal" data-target="#editAlbumModal" data-id="' . $album['album_id'] . '" data-name="' . $album['album_name'] . '" style="padding: 5px 10px;">
                <i class="fas fa-edit"></i>
              </button>';

                            // Delete button
                            echo '<form method="POST" style="display:inline;">
                <input type="hidden" name="album_id" value="' . $album['album_id'] . '">
                <button type="submit" name="delete_album" class="btn btn-danger" onclick="return confirm(\'Are you sure you want to delete this album?\');" style="padding: 5px 10px;">
                    <i class="fas fa-trash"></i>
                </button>
              </form>';

                            echo '</div>'; // End album-buttons

                            // Display photos in the album
                            $album_id = $album['album_id'];
                            $photos = mysqli_query($conn, "SELECT * FROM tb_image 
                                        INNER JOIN tb_image_album ON tb_image.image_id = tb_image_album.image_id 
                                        WHERE tb_image_album.album_id = '$album_id'");

                            // Add Photo button
                            echo '<button type="button" class="btn btn-primary add-photo-button" data-toggle="modal" data-target="#addPhotoToAlbumModal" data-albumid="' . $album_id . '" style="margin-top: 10px;">
                <i class="fas fa-plus"></i> Tambah Foto
              </button>';

                            while ($photo = mysqli_fetch_array($photos)) {
                                echo '<div class="photo" style="display: inline-block; margin: 5px;">';
                                echo '<img src="./foto/' . $photo['image'] . '" alt="' . $photo['image_name'] . '" class="image-thumbnail" style="width: 100px; height: auto; border-radius: 5px;">'; // Set width and auto height
                                echo '</div>';
                            }

                            echo '</div>'; // End album
                        }
                    } else {
                        echo '<p class="no-albums">Belum ada album.</p>';
                    }
                    ?>
                </div>

                <!-- Create Album Modal -->
                <div class="modal fade" id="createAlbumModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form method="POST">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tambah Album</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <input type="text" name="album_name" required placeholder="Nama Album" class="form-control">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" name="create_album" class="btn btn-primary">Buat Album</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Edit Album Modal -->
                <div class="modal fade" id="editAlbumModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form method="POST">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Album</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="album_id" id="editAlbumId">
                                    <input type="text" name="album_name" id="editAlbumName" required class="form-control">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" name="edit_album" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Add Photo to Album Modal -->
                <div class="modal fade" id="addPhotoToAlbumModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form method="POST">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tambah Foto ke Album</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="album_id" id="albumIdForPhoto">
                                    <select name="image_id" required class="form-control mt-2">
                                        <?php
                                        $images = mysqli_query($conn, "SELECT * FROM tb_image WHERE admin_id = '{$_SESSION['a_global']->admin_id}'");
                                        while ($img = mysqli_fetch_array($images)) {
                                            echo '<option value="' . $img['image_id'] . '">' . $img['image_name'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" name="add_photo_to_album" class="btn btn-primary">Add Photo</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Include jQuery and Bootstrap JavaScript -->
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

                <!-- Custom CSS to remove backdrop shadows -->
                <style>
                    .modal-backdrop {
                        display: none;
                    }
                </style>

                <script>
                    $('#editAlbumModal').on('show.bs.modal', function(event) {
                        var button = $(event.relatedTarget); // Button that triggered the modal
                        var albumId = button.data('id'); // Extract info from data-* attributes
                        var albumName = button.data('name');

                        var modal = $(this);
                        modal.find('#editAlbumId').val(albumId);
                        modal.find('#editAlbumName').val(albumName);
                    });

                    $('#addPhotoToAlbumModal').on('show.bs.modal', function(event) {
                        var button = $(event.relatedTarget); // Button that triggered the modal
                        var albumId = button.data('albumid'); // Extract info from data-* attributes

                        var modal = $(this);
                        modal.find('#albumIdForPhoto').val(albumId);
                    });
                </script>

                <?php
                // Handle Delete Album
                if (isset($_POST['delete_album'])) {
                    $album_id = $_POST['album_id'];
                    $delete_query = "DELETE FROM tb_album WHERE album_id = '$album_id'";

                    if (mysqli_query($conn, $delete_query)) {
                        echo '<script>alert("Album deleted successfully!");</script>';
                    } else {
                        echo '<script>alert("Failed to delete album.");</script>';
                    }
                }

                // Handle Edit Album
                if (isset($_POST['edit_album'])) {
                    $album_id = $_POST['album_id'];
                    $album_name = mysqli_real_escape_string($conn, $_POST['album_name']);

                    $update_query = "UPDATE tb_album SET album_name = '$album_name' WHERE album_id = '$album_id'";

                    if (mysqli_query($conn, $update_query)) {
                        echo '<script>alert("Album updated successfully!");</script>';
                    } else {
                        echo '<script>alert("Failed to update album.");</script>';
                    }
                }

                // Handle Add Photo to Album
                if (isset($_POST['add_photo_to_album'])) {
                    $album_id = $_POST['album_id'];
                    $image_id = $_POST['image_id'];

                    $insert_query = "INSERT INTO tb_image_album (album_id, image_id) VALUES ('$album_id', '$image_id')";

                    if (mysqli_query($conn, $insert_query)) {
                        echo '<script>alert("Photo added to album successfully!");</script>';
                    } else {
                        echo '<script>alert("Failed to add photo to album.");</script>';
                    }
                }
                ?>

            </div>

            <!-- Edit Foto Popup -->
            <div id="editImageModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal('editImageModal')">&times;</span>
                </div>
            </div>

            <!-- JavaScript untuk Menampilkan dan Menutup Modal -->
            <script>
                function openModal(modalId) {
                    document.getElementById(modalId).style.display = "block";
                }

                function closeModal(modalId) {
                    document.getElementById(modalId).style.display = "none";
                }

                // Event listener untuk tombol edit dan hapus di foto yang diunggah
                document.addEventListener('DOMContentLoaded', function() {
                    document.querySelectorAll('.delete-button').forEach(button => {
                        button.addEventListener('click', function() {
                            const confirmDelete = confirm("Apakah Anda yakin ingin menghapus foto ini?");
                            if (confirmDelete) {
                                window.location.href = `hapus.php?idp=${this.dataset.id}`;
                            }
                        });
                    });
                });
            </script>
            <br>
            <div class="container-fluid d-md-none">
                <div class="row">
                    <div class="col-md-12">
                        <p>&copy; 2024 <a href="#">Zaxkyy</a><br> All Rights Reserved.</p>
                    </div>
                </div>
            </div>

    </main>



    <script src="js/jquery-3.2.1.slim.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.waypoints.min.js"></script>
    <script src="js/imagesloaded.pkgd.min.js"></script>
    <script src="js/imagesloaded.pkgd.min.js"></script>

    <script src="js/main.js"></script>


</body>

</html>