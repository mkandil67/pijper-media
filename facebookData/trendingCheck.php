<?php
// 1. database credentials
$host = "127.0.0.1";
$db_name = "users-pijper";
$username = "root";
$password = "";

// 2. connect to database
try {
    $con = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    // set the PDO error mode to exception
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully\n";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}


// QUERY THE DATABASE FOR ALL POSTS FROM FACEBOOK
$statement = $con->prepare("SELECT * FROM posts");
$statement->execute();
$posts = $statement->fetchAll();

foreach ($posts as $post) {
    $new_engagement = $post['engagement'];
    $old_engagement = $post['old_engagement'];
    $followers_count = $post['followers_count'];
    $post_id = $post['post_id'];
    $time_difference = 5;
    $engagement_difference = $new_engagement - $old_engagement;

    echo "postID: " . $post['post_id'] . "          new engagement: " . $post['engagement'] . "       old engagement: " . $post['old_engagement'] . "\n";
    echo "Algorithm calculation: " . ($engagement_difference / $followers_count) / $time_difference * 1000000 . "\n";

    $is_trending = false;
    if ((($engagement_difference / $followers_count) / $time_difference)* 1000000 > 3) {
        $is_trending = true;
    }

    if ($is_trending) {
        // prepare update query
        $query = "UPDATE posts SET is_trending = true WHERE post_id = ?";
        $stmt = $con->prepare( $query );

        // bind the parameters to a variable
        $stmt->bindParam(1, $post_id);

        $stmt->execute();
    }
}