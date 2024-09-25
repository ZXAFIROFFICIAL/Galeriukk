<?php
session_start();
if ($_SESSION['status_login'] != true) {
    echo '<script>window.location="login.php"</script>';
}

// Ensure db.php is included
include 'includes/config.php';
error_reporting(0);

// Fetch admin contact details
$kontak = mysqli_query($conn, "SELECT admin_telp, admin_email, admin_address FROM tb_admin WHERE admin_id = 2");
$a = mysqli_fetch_object($kontak);
$foto = mysqli_query($conn, "
    SELECT tb_image.*, tb_admin.admin_name 
    FROM tb_image 
    JOIN tb_admin ON tb_image.admin_id = tb_admin.admin_id 
    WHERE tb_image.image_status = 1 
    ORDER BY tb_image.image_id DESC 
    LIMIT 8
");


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
        .welcome-box {
            background-color: #f8f9fa;
            /* Light background */
            border-radius: 10px;
            /* Rounded corners */
            padding: 20px;
            /* Padding around text */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            /* Soft shadow for depth */
            text-align: center;
            /* Center the text */
            transition: transform 0.3s, box-shadow 0.3s;
            /* Smooth transition for hover effects */
            animation: fadeIn 1s ease;
            /* Animation for entrance */
        }

        .welcome-box h4 {
            color: #333;
            /* Dark text color */
            font-weight: 600;
            /* Bold text */
        }

        .admin-name {
            color: #1FAD9F;
            /* Accent color for admin name */
            font-weight: bold;
            /* Make admin name bold */
        }

        .welcome-box:hover {
            transform: translateY(-5px);
            /* Slight lift on hover */
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            /* Enhanced shadow on hover */
        }

        .comment-icon {
            color: #555;
            /* Lighter shade of black */
        }

        /* Animation keyframes */
        @keyframes fadeIn {
            from {
                opacity: 0;
                /* Start invisible */
                transform: translateY(-10px);
                /* Start slightly higher */
            }

            to {
                opacity: 1;
                /* End fully visible */
                transform: translateY(0);
                /* End in place */
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
                    <li class="probootstrap-animate active" data-animate-effect="fadeInLeft"><a href="dashboard.php">Beranda</a></li>
                    <li class="probootstrap-animate" data-animate-effect="fadeInLeft"><a href="galeri1.php">Galeri</a></li>
                    <li class="probootstrap-animate" data-animate-effect="fadeInLeft"><a href="profil.php">Profil</a></li>
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
            <div class="probootstrap-main-site-logo"><a href="dashboard.php">BERANDAA</a></a></div>
        </div><br><br>
        <!-- content -->
        <div class="section">
            <div class="container">
                <div class="box welcome-box">
                    <h4>Selamat Datang, <span class="admin-name"><?php echo $_SESSION['a_global']->admin_name ?></span> di Website Galeri Foto</h4>
                </div>
            </div>
        </div>

        <br><br>
        <!-- Kategori Section -->
        <div class="section">
            <div class="container">
                <h3>Kategori</h3>
                <div class="box card-columns"> <!-- Added Bootstrap's card-columns class -->
                    <?php
                    $kategori = mysqli_query($conn, "SELECT * FROM tb_category ORDER BY category_id DESC");
                    if (mysqli_num_rows($kategori) > 0) {
                        while ($k = mysqli_fetch_array($kategori)) {
                            // Assign an icon based on the category name
                            $icon = '';
                            switch ($k['category_name']) {
                                case 'Olahraga':
                                    $icon = 'fas fa-basketball-ball'; // Ikon bola basket
                                    break;
                                case 'Fashion':
                                    $icon = 'fas fa-tshirt'; // Ikon kaos
                                    break;
                                case 'Event':
                                    $icon = 'fas fa-paint-brush'; // Ikon kuas cat
                                    break;
                                case 'Dokumenter':
                                    $icon = 'fas fa-film'; // Ikon film
                                    break;
                                case 'Semua':
                                    $icon = 'fas fa-globe'; // Ikon semua
                                    break;
                                default:
                                    $icon = 'fas fa-folder'; // Ikon default
                                    break;
                            }
                    ?>
                            <a href="galeri1.php?kat=<?php echo $k['category_id'] ?>">
                                <div class="card"> <!-- Bootstrap card -->
                                    <div class="card-body text-center">
                                        <div class="icon-wrapper">
                                            <i class="<?php echo $icon; ?>" style="font-size: 30px;"></i> <!-- FontAwesome icon -->
                                        </div>
                                        <p class="card-title"><?php echo $k['category_name'] ?></p>
                                    </div>
                                </div>
                            </a>
                        <?php
                        }
                    } else {
                        ?>
                        <p>Kategori tidak ada</p>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>

        <!-- Foto Terkini Section -->
        <div class="section">
            <div class="container">
                <h3>Foto Terkini</h3>
                <div class="box card-columns"> <!-- Bootstrap's card-columns class -->
                    <?php
                    $foto = mysqli_query($conn, "SELECT * FROM tb_image WHERE image_status = 1 ORDER BY image_id DESC LIMIT 8");
                    if (mysqli_num_rows($foto) > 0) {
                        while ($p = mysqli_fetch_array($foto)) {
                    ?>
                            <a href="#" onclick="showImageDetails(<?php echo $p['image_id']; ?>)">
                                <div class="card">
                                    <img class="card-img-top" src="foto/<?php echo $p['image']; ?>" alt="<?php echo $p['image_name']; ?>" style="height: 200px; object-fit: cover;">
                                    <div class="card-body">
                                        <p class="card-title"><?php echo substr($p['image_name'], 0, 30); ?></p>
                                        <p class="card-text">Nama User: <?php echo $p['admin_name']; ?></p>
                                        <p class="card-text"><small class="text-muted"><?php echo $p['date_created']; ?></small></p>

                                        <!-- Like display -->
                                        <?php
                                        // Cek status like dari tb_likes untuk user ini dan gambar ini
                                        $query_like = "SELECT liked FROM tb_likes WHERE admin_id = '" . $_SESSION['admin_id'] . "' AND image_id = '" . $p['image_id'] . "'";
                                        $result_like = mysqli_query($conn, $query_like);
                                        $like_status = mysqli_fetch_assoc($result_like);

                                        // Hitung total likes untuk gambar ini (yang liked = 1)
                                        $query_count_likes = "SELECT COUNT(*) as total_likes FROM tb_likes WHERE image_id = '" . $p['image_id'] . "' AND liked = 1";
                                        $result_count_likes = mysqli_query($conn, $query_count_likes);
                                        $total_likes = mysqli_fetch_assoc($result_count_likes)['total_likes'];

                                        // Ubah warna icon love jika user sudah like
                                        $like_color = ($like_status && $like_status['liked'] == 1) ? 'color:black' : 'color:red'; // Merah untuk like, hitam untuk belum like
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
                            </a>

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