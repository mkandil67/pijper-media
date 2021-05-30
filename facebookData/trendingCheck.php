<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function mailTrending($post, $con) {

    $statement = $con->prepare("SELECT * FROM users");
    $statement->execute();
    $users = $statement->fetchAll();

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = '465';
        $mail->isHTML();
        $mail->Username = 'weblog.socialwall@gmail.com';
        $mail->Password = '@Admin123';
        $mail->setFrom('no-reply@weblog-media.com');
        $mail->Subject = 'New Viral Post';
        $emailHTML = '<html>
                        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
                        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
                        <p class="pb-3 pt-4 pl-4"> This post is now trending, you can see it in the "Trending Now" view of the platform or search for it there.</p>
                        <div class="container d-flex justify-content-between pl-5" id="postsCard">
                            <div class="card shadow-sm m-1 mb-5">
                                <div class="card-body">
                                    <div class="pl-5">
                                        <img style="width:250px; height:250px;" class="pb-4" src="https://help.twitter.com/content/dam/help-twitter/brand/logo.png">
                                    </div>
                                    <div class="card-body mb-2">
                                        <small class="card-text"><span class="font-weight-bold pr-2">Linda</span>Hi this is Med, I am here to test the email.</small>
                                    </div>
                                    <div class="d-flex flex-column ml-4">
                                        <small class="text-danger font-weight-bold">Engagement: 115</small>
                                        <small class="text-muted">Viral</small>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row d-flex justify-content-between">
                                        <form style="display: inline-flex; align-items: center" action="#" method="POST" id="form">
                                            <input type="hidden" name="id" value="5">
                                            <button style="margin-right: 10px; margin-left: 100px" type="submit" class="btn btn-sm btn-outline-primary font-weight-bold">Add</button>
                                            <a href="https://help.twitter.com/content/dam/help-twitter/brand/logo.png" type="button" class="btn btn-sm btn-outline-primary font-weight-bold">Source</a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </html>';
        $mail->Body = $emailHTML;
        foreach ($users as $user) {
            $mail->AddAddress($user['email']);
        }

        $mail->Send();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

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
    $id = $post['account_id'];
    $new_engagement = $post['engagement'];
    $old_engagement = $post['old_engagement'];

    $post_id = $post['post_id'];
    $engagement_difference = $new_engagement - $old_engagement;

    $is_trending = false;
    if ($engagement_difference > 0.01*$old_engagement && $new_engagement > 1000) {
        $is_trending = true;
    }

    if ($is_trending) {
        // prepare update query
        $query = "UPDATE posts SET is_trending = true WHERE post_id = ?";
        $stmt = $con->prepare( $query );

        mailTrending($post, $con);

        // bind the parameters to a variable
        $stmt->bindParam(1, $post_id);

        $stmt->execute();
    }
}