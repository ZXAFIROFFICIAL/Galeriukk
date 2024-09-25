<?php
include 'includes/config.php';

if (isset($_GET['idp'])) {
    $image_id = $_GET['idp'];

    // Cek apakah gambar ada
    $foto = mysqli_query($conn, "SELECT image FROM tb_image WHERE image_id = '$image_id'");
    $p = mysqli_fetch_object($foto);

    if ($p) {
        // Hapus file gambar jika ada
        $file_path = './foto/' . $p->image;
        if (file_exists($file_path)) {
            unlink($file_path); // Menghapus file
        } 

        // Hapus komentar terkait gambar
        mysqli_query($conn, "DELETE FROM tb_comments WHERE image_id = '$image_id'");

        // Hapus likes terkait gambar
        mysqli_query($conn, "DELETE FROM tb_likes WHERE image_id = '$image_id'");

        // Hapus gambar dari tb_image
        $delete = mysqli_query($conn, "DELETE FROM tb_image WHERE image_id = '$image_id'");

        if ($delete) {
            echo '<script>alert("Foto berhasil dihapus."); window.location="profil.php";</script>';
        } else {
            echo '<script>alert("Gagal menghapus foto."); window.location="profil.php";</script>';
        }
    } else {
        echo '<script>alert("Foto tidak ditemukan."); window.location="profil.php";</script>';
    }
}
?>
