<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Carbon\Carbon;

require 'vendor/autoload.php';

function mailTrending($post, $con, $account) {

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
    <div class="container" id="postsCard">
        <p style="color: #0b057a" class="p-2 font-weight-bold text-uppercase">This post just became <span class="text-danger">VIRAL!</span> You can see it using the Viral View in the platform, or search for it there!</p>
        <div class="card shadow-sm m-1 mb-5">
            <div class="card-header d-flex justify-content-between">
                <div class="d-inline-flex">
                    <svg role="img" xmlns="http://www.w3.org/2000/svg" style="margin: 5px" width="32px" height="32px" viewBox="0 0 24 24"><title>Facebook icon</title><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    <span style="color:#0b057a" class="font-weight-bold pt-2 pl-2">'.$account[0]['data_source'].'</span>
                </div>
                <div class="pt-2"><small class="text-muted">'. Carbon::parse($post['posted_at'])->diffForHumans() .'</small></div>
            </div>
            <div class="card-body container">
                <div class = "d-flex justify-content-center">
                    <img style="width:250px; height:250px;" class="pb-4" src="'.$post['image_url'].'">
                </div>
                <div class="card-body mb-2 d-flex justify-content-center">
                    <small class="card-text"><span class="font-weight-bold pr-2">'.$account[0]['data_source'].'</span>'.$post['caption'].'</small>
                </div>
                <div class="card-body d-block">
                    <div class="d-flex justify-content-center">
                        <small class="text-danger font-weight-bold">Engagement: '.$post['engagement'].'</small>
                    </div>
                    <div class="d-flex justify-content-center">
                        <small class="text-muted">'.$account[0]['category'].'</small>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-center">
                    <form style="display: inline-flex; align-items: center" action="#" method="POST" id="form">
                        <input type="hidden" name="id" value="12">
                        <button style="margin-right: 10px" type="submit" class="btn btn-sm btn-outline-primary font-weight-bold">Add</button>
                        <a href="'.$post['post_url'].'" type="button" class="btn btn-sm btn-outline-primary font-weight-bold">Source</ahref></a>
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

        $accQuery = $con->prepare('SELECT data_source, category FROM accounts WHERE id = '.$post['account_id']);
        $accQuery->execute();
        $account = $accQuery->fetchAll();

        var_dump($account);

        mailTrending($post, $con, $account);

        // bind the parameters to a variable
        $stmt->bindParam(1, $post_id);

        $stmt->execute();
    }
}