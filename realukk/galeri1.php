<?php
session_start();
error_reporting(0);

if ($_SESSION['status_login'] != true) {
    echo '<script>window.location="login.php"</script>';
}
include 'includes/config.php';

$kontak = mysqli_query($conn, "SELECT admin_telp, admin_email, admin_address FROM tb_admin WHERE admin_id = 2");
$a = mysqli_fetch_object($kontak);

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
    <!-- <link href="https://fonts.googleapis.com/css?family=Work+Sans" rel="stylesheet"> -->

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">

    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">

    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Styling for the form */
        .search-form {
            position: relative;
        }

        /* Styling for the input field */
        .search-form input[type="text"] {
            width: 100%;
            padding: 12px 40px;
            /* Adjusted padding for the icon */
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 20px;
            font-size: 16px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        /* Focus effect on the input field */
        .search-form input[type="text"]:focus {
            border-color: #3498db;
            box-shadow: 0 0 8px rgba(52, 152, 219, 0.5);
            outline: none;
        }

        /* Styling for the search button */
        .search-form input[type="submit"] {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            padding: 12px 20px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 20px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        /* Hover effect on the search button */
        .search-form input[type="submit"]:hover {
            background-color: #2980b9;
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
        }

        /* Icon styling */
        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
            transition: color 0.3s ease;
        }

        /* Change icon color on input focus */
        .search-form input[type="text"]:focus+.search-icon {
            color: #3498db;
        }

        .hidden-submit {
            display: none;
            /* Menyembunyikan tombol */
        }

        .comment-icon {
            color: #555;
            /* Lighter shade of black */
        }

        /* Responsive design */
        @media (max-width: 600px) {

            .search-form input[type="text"],
            .search-form input[type="submit"] {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <aside class="probootstrap-aside js-probootstrap-aside">
        <a href="#" class="probootstrap-close-menu js-probootstrap-close-menu d-md-none"><span class="oi oi-arrow-left"></span> Close</a>
        <div class="probootstrap-site-logo probootstrap-animate" data-animate-effect="fadeInLeft">

            <a href="index.html" class="mb-2 d-block probootstrap-logo">GALERI FOTO</a>
            <p class="mb-0">Website Galeri Foto </p>
        </div>
        <div class="probootstrap-overflow">
            <nav class="probootstrap-nav">
                <ul>
                    <li class="probootstrap-animate" data-animate-effect="fadeInLeft"><a href="dashboard.php">Beranda</a></li>
                    <li class="probootstrap-animate active" data-animate-effect="fadeInLeft"><a href="galeri1.php">Galeri</a></li>
                    <li class="probootstrap-animate" data-animate-effect="fadeInLeft"><a href="profil.php">Profil</a></li>
                    <li class="probootstrap-animate" data-animate-effect="fadeInLeft"><a href="keluar.php">Keluar</a></li>
                </ul>
            </nav>
            <footer class="probootstrap-aside-footer probootstrap-animate" data-animate-effect="fadeInLeft">
                <p>&copy; 2024 <a href="#">Zaxkyy</a>. <br> All Rights Reserved.</p>
            </footer>
        </div>
    </aside>


    <main role="main" class="probootstrap-main js-probootstrap-main">
        <div class="probootstrap-bar">
            <a href="#" class="probootstrap-toggle js-probootstrap-toggle"><span class="oi oi-menu"></span></a>
            <div class="probootstrap-main-site-logo"><a href="galeri1.php">GALERI</a></a></div>
        </div><br><br>
        <div class="container">
            <form class="search-form" action="galeri1.php">
                <input type="text" name="search" placeholder="Cari Foto ...." value="<?php echo $_GET['search'] ?>" required />
                <input type="hidden" name="kat" value="<?php echo $_GET['kat'] ?>" />
                <i class="fas fa-search search-icon"></i>
                <input type="submit" name="cari" class="hidden-submit" value="" />
            </form>
        </div>
        <br>
        <div class="box card-columns">
            <div class="section">
                <div class="container">
                    <div class="photo-grid">
                        <?php
                        // Jika ada parameter pencarian atau kategori yang dipilih, tambahkan kondisi ke query
                        $where = '';
                        if (!empty($_GET['search']) || !empty($_GET['kat'])) {
                            $where = "AND image_name LIKE '%" . $_GET['search'] . "%' AND category_id LIKE '%" . $_GET['kat'] . "%' ";
                        }
                        // Ambil semua foto dari database yang sesuai dengan kondisi
                        $foto = mysqli_query($conn, "SELECT * FROM tb_image WHERE image_status = 1 $where ORDER BY image_id DESC");
                        // Jika ada foto yang ditemukan, tampilkan dalam bentuk grid
                        if (mysqli_num_rows($foto) > 0) {
                            while ($p = mysqli_fetch_array($foto)) {
                        ?>
                                <div class="card photo-card">
                                    <a href="#" onclick="showImageDetails(<?php echo $p['image_id']; ?>)">
                                        <img class="card-img-top probootstrap-animate" src="foto/<?php echo $p['image'] ?>" alt="<?php echo $p['image_name'] ?>" data-animate-effect="fadeIn">
                                    </a>
                                    <div class="card-body">
                                        <p class="nama"><?php echo substr($p['image_name'], 0, 30) ?></p>
                                        <!-- Like display -->
                                        <?php
                                        // Cek status like dari tb_likes
                                        $query_like = "SELECT * FROM tb_likes WHERE admin_id = '" . $_SESSION['admin_id'] . "' AND image_id = '" . $p['image_id'] . "'";
                                        $result_like = mysqli_query($conn, $query_like);
                                        $like_status = mysqli_fetch_assoc($result_like);

                                        // Hitung jumlah like untuk gambar ini
                                        $query_count_likes = "SELECT COUNT(*) as total_likes FROM tb_likes WHERE image_id = '" . $p['image_id'] . "' AND liked = 1";
                                        $result_count_likes = mysqli_query($conn, $query_count_likes);
                                        $total_likes = mysqli_fetch_assoc($result_count_likes)['total_likes'];

                                        // Ubah warna icon love jika sudah di-like
                                        $like_color = ($like_status && $like_status['liked'] == 1) ? 'color:black' : 'color:red';
                                        ?>
                                        <!-- Tampilkan tombol like dengan ikon love -->
                                        <a href="like_comment.php?image_id=<?php echo $p['image_id']; ?>" style="text-decoration:none;">
                                            <i class="fas fa-heart" style="<?php echo $like_color; ?>"></i>
                                            <span><?php echo $total_likes; ?> Like(s)</span>
                                        </a>

                                        <!-- Comment display -->
                                        <?php
                                        // Hitung jumlah komentar untuk gambar ini
                                        $query_count_comments = "SELECT COUNT(*) as total_comments FROM tb_comments WHERE image_id = '" . $p['image_id'] . "'";
                                        $result_count_comments = mysqli_query($conn, $query_count_comments);
                                        $total_comments = mysqli_fetch_assoc($result_count_comments)['total_comments'];
                                        ?>
                                        <span class="comment-icon">
                                            <i class="fas fa-comment"></i> <?php echo $total_comments; ?> Comment(s)
                                        </span>
                                    </div>
                                </div>
                                <!-- Modal for image details -->
                                <div class="modal fade" id="imageDetailsModal" tabindex="-1" role="dialog" aria-labelledby="imageDetailsModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="imageDetailsModalLabel">Detail Foto</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body" id="modal-body-content">
                                                <!-- Content will be loaded here -->
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    function showImageDetails(imageId) {
                                        // Make an AJAX call to fetch image details
                                        const xhr = new XMLHttpRequest();
                                        xhr.open('GET', 'fetch_image_details1.php?id=' + imageId, true);
                                        xhr.onload = function() {
                                            if (this.status === 200) {
                                                document.getElementById('modal-body-content').innerHTML = this.responseText;
                                                $('#imageDetailsModal').modal('show'); // Show the modal
                                            }
                                        };
                                        xhr.send();
                                    }
                                </script>
                            <?php }
                        } else { ?>
                            <p>Foto tidak ada</p>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="container-fluid d-md-none">
                <div class="row">
                    <div class="col-md-12">
                        <p>&copy; 2024 <a href="#">Zaxkyy</a><br> All Rights Reserved.</p>
                    </div>
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