<?php
session_start();
include 'includes/config.php'; // Koneksi ke database

$image_id = $_GET['id'];

// Fetch image details with category name
$query = "SELECT i.*, c.category_name FROM tb_image i 
          JOIN tb_category c ON i.category_id = c.category_id 
          WHERE i.image_id = '$image_id'";
$result = mysqli_query($conn, $query);
$p = mysqli_fetch_assoc($result);

// Display image and details
echo "<h3>{$p['image_name']}<br />Kategori: {$p['category_name']}</h3>";
echo "<img src='foto/{$p['image']}' alt='{$p['image_name']}' style='width: 100%; height: auto; object-fit: cover;' />";
echo "<h4>Nama User: {$p['admin_name']}<br />Upload Pada Tanggal: {$p['date_created']}</h4>";
echo "<p>Deskripsi:<br />{$p['image_description']}</p>";

// Like display
$total_likes = 0;

if (isset($_SESSION['admin_id'])) {
    $admin_id = $_SESSION['admin_id'];

    // Check like status
    $query_like = "SELECT * FROM tb_likes WHERE admin_id = '$admin_id' AND image_id = '$image_id'";
    $result_like = mysqli_query($conn, $query_like);
    $like_status = mysqli_fetch_assoc($result_like);

    // Count total likes
    $query_count_likes = "SELECT COUNT(*) as total_likes FROM tb_likes WHERE image_id = '$image_id' AND liked = 1";
    $result_count_likes = mysqli_query($conn, $query_count_likes);
    $total_likes = mysqli_fetch_assoc($result_count_likes)['total_likes'];

    $like_color = ($like_status && $like_status['liked'] == 1) ? 'color:red' : 'color:black';

    // Output like display
    echo "<span class='love-icon' style='{$like_color};' onclick='likePost({$image_id})'>
            <i class='fas fa-heart'></i> {$total_likes} Like(s)
          </span>";
} else {
    // If not logged in, count total likes only
    $query_count_likes = "SELECT COUNT(*) as total_likes FROM tb_likes WHERE image_id = '$image_id' AND liked = 1";
    $result_count_likes = mysqli_query($conn, $query_count_likes);
    $total_likes = mysqli_fetch_assoc($result_count_likes)['total_likes'];

    echo "<span class='love-icon' style='color:red;'>
            <i class='fas fa-heart'></i> {$total_likes} Like(s)
          </span>";
}

// Display Comments
echo "<h4>Komentar:</h4>";

// Wrap comments in a div for styling
echo "<div class='comments-section'>";

// Fetch comments
$query_comments = "SELECT c.comment, c.date_created, a.admin_name 
                   FROM tb_comments c 
                   JOIN tb_admin a ON c.admin_id = a.admin_id 
                   WHERE c.image_id = '$image_id'";

$result_comments = mysqli_query($conn, $query_comments);
while ($comment = mysqli_fetch_assoc($result_comments)) {
    echo "<p><strong>{$comment['admin_name']}:</strong> {$comment['comment']} 
          <span style='font-size:10px; color:grey;'>(" . date('d M Y, H:i', strtotime($comment['date_created'])) . ")</span></p>";
}

echo "</div>";

// Comment form
echo "<form method='POST' action='like_comment.php' style='margin-top: 20px;'>
        <textarea name='comment' required placeholder='Tulis Komentar ....' style='width: 100%; height: 100px; border: 1px solid #ccc; border-radius: 5px; padding: 10px; font-size: 14px; resize: none;'></textarea>
        <input type='hidden' name='image_id' value='{$image_id}'>
        <input type='submit' value='Kirim Komentar' style='background-color: #007BFF; color: white; border: none; border-radius: 5px; padding: 10px 15px; cursor: pointer; font-size: 16px; margin-top: 10px;'>
      </form>";
?>

<script>
    function likePost(imageId) {
        // Buat XMLHttpRequest
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'like_comment.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        // Set handler untuk menampilkan hasil dari server
        xhr.onload = function() {
            if (this.status === 200) {
                // Update tampilan jumlah like di halaman tanpa refresh
                document.getElementById('like-count-' + imageId).innerHTML = this.responseText;
            }
        };

        // Kirim request dengan data admin_id dan image_id
        xhr.send('image_id=' + imageId);
    }
</script>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail foto</title>
</head>

<body>
    <style>
        .comments-section {
            max-height: 200px;
            /* Adjust the height as needed */
            overflow-y: auto;
            /* Enable vertical scrolling */
            border: 1px solid #ddd;
            /* Optional: Add a border */
            padding: 10px;
            /* Optional: Add some padding */
            background-color: #f9f9f9;
            /* Optional: Light background color */
            border-radius: 5px;
            /* Optional: Rounded corners */
        }
    </style>
</body>

</html>