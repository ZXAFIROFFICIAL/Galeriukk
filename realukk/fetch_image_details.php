<?php
session_start(); // Start the session
include 'includes/config.php'; // Include your database connection

if (isset($_GET['id'])) {
    $image_id = $_GET['id'];

    // Fetch the image details with category name
    $query = "SELECT i.*, c.category_name FROM tb_image i 
              JOIN tb_category c ON i.category_id = c.category_id 
              WHERE i.image_id = '$image_id'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $p = mysqli_fetch_assoc($result);

        // Display image and details
        echo "<h3>{$p['image_name']}<br />Kategori: {$p['category_name']}</h3>
              <img src='foto/{$p['image']}' alt='{$p['image_name']}' style='width: 100%; height: auto; object-fit: cover;' />
              <h4>Nama User: {$p['admin_name']}<br />
                  Upload Pada Tanggal: {$p['date_created']}</h4>
              <p>Deskripsi:<br />{$p['image_description']}</p>";

        // Like display
        if (isset($_SESSION['admin_id'])) {
            // Check like status from tb_likes
            $query_like = "SELECT * FROM tb_likes WHERE admin_id = '" . $_SESSION['admin_id'] . "' AND image_id = '$image_id'";
            $result_like = mysqli_query($conn, $query_like);
            $like_status = mysqli_fetch_assoc($result_like);

            // Count total likes for the image
            $query_count_likes = "SELECT COUNT(*) as total_likes FROM tb_likes WHERE image_id = '$image_id' AND liked = 1";
            $result_count_likes = mysqli_query($conn, $query_count_likes);
            $total_likes = mysqli_fetch_assoc($result_count_likes)['total_likes'];

            // Change heart icon color based on like status
            $like_color = ($like_status && $like_status['liked'] == 1) ? 'color:red' : 'color:black';

            // Output like display
            echo "<span class='love-icon' style='{$like_color};' onclick='likePost({$image_id})'>
                    <i class='fas fa-heart'></i> {$total_likes} Like(s)
                  </span>";
        } else {
            // If not logged in, show like count only
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

        echo "</div>"; // Close comments section

    } else {
        echo "Image details not found.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Foto</title>
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
