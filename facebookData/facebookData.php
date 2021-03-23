<?php
// 1. database credentials
$host = "localhost";
$db_name = "users-pijper";
$username = "root";
$password = "";

// 2. connect to database
$con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);

require_once __DIR__ . '/vendor/autoload.php'; // change path as needed

$fb = new \Facebook\Facebook([
    'app_id' => '254044855470656',
    'app_secret' => 'a3aad452f3160b6402895a8d25b5fd0a',
    'default_graph_version' => 'v2.10',
    'default_access_token' => '254044855470656|a3aad452f3160b6402895a8d25b5fd0a'
]);

//////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////// THIS IS NOT YET IN USE //////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////
//$categories = array(
//    'News',
////    'Showbizz/Entertainment',
////    'Royals',
//    'Food/Recipes',
////    'Lifehacks',
////    'Fashion',
////    'Beauty',
////    'Health',
////    'Family',
////    'House and Garden',
////    'Cleaning',
////    'Lifestyle',
////    'Cars',
////    'Crime',
//);
//
//$sources = array(
//    'News' => array(
//        'nos.nl',
//        'rtlnieuws.nl',
//        'ad.nl',
//        'nu.nl',
//        'metronieuws.nl',
//        'telegraaf.nl',
//        'trouw.nl',
//        'metro.co.uk',
//        'hln.be',
//        'edition.cnn.com',
//    ),
////    'Showbizz/Entertainment',
////    'Royals',
//    'Food/Recipes' => array(
//        'tasty.co',
//        'delish.com',
//        'eatthis.com',
//        'thekitchn.com',
//        'flavorflav.com',
//        'nvwa.nl',
//        'voedingscentrum.nl',
//        'culy.nl',
//        'freshhh.nl',
//        'twistedfood.co.uk',
//        'yummly.com',
//        'realsimple.com',
//        'sterindekeuken.nl',
//        'womenshealthmag.com',
//        '24kitchen.nl',
//        'thespruceeats.com',
//        'thehealthy.com',
//        'bbcgoodfood.com',
//        'elleeten.nl',
//        'bonappetit.com',
//        'recipegirl.com',
//    ),
////    'Lifehacks',
////    'Fashion',
////    'Beauty',
////    'Health',
////    'Family',
////    'House and Garden',
////    'Cleaning',
////    'Lifestyle',
////    'Cars',
////    'Crime',
//);
//
//foreach ($categories as $category) {
//    echo $category;
//    foreach ($sources[$category] as $source) {
//        echo $source;
//    }
//}
//////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////// THIS IS NOT YET IN USE //////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////

try {
    // Get the \Facebook\GraphNodes\GraphUser object for the current user.
    // If you provided a 'default_access_token', the '{access-token}' is optional.
    $response = $fb->get('/linda.nl/posts?fields=permalink_url,shares,message,picture,is_popular,reactions.limit(0).summary(total_count),comments.limit(0).summary(total_count)',
        $fb->getDefaultAccessToken());
} catch(\Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch(\Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}

$data = array_values($response->getDecodedBody())[0];

/////// some debugging stuffs///////
//$paging = array_values($response->getDecodedBody())[1];
//$edge = $response->getGraphEdge();
//var_dump($paging);
//var_dump($data);
//var_dump($response->getGraphEdge());


foreach ($data as $post) {
    // get the post data
    $post_url = $post['permalink_url'];
    $shares = $post['shares']['count'];
    $message = $post['message'];
    $picture_url = $post['picture'];
    $likes = $post['reactions']['summary']['total_count'];
    $comments = $post['comments']['summary']['total_count'];
    $id = $post['id'];

    // 3. prepare select query
    $query = "INSERT INTO posts (category, platform, caption, post_url, image_url, engagement, old_engagement, writer_id, created_at, updated_at)
            VALUES ('Cars', 'facebook', ?, ?, ?, ?, 0, null, ?, ?)";
    $stmt = $con->prepare( $query );

    //  4. sample product ID
    $engagement = $shares + $comments + $likes;
    $now = date("Y-m-d H:i:s");

    // 5. this is the first question mark in the query
    $stmt->bindParam(1, $message);
    $stmt->bindParam(2, $post_url);
    $stmt->bindParam(3, $picture_url);
    $stmt->bindParam(4, $engagement);
    $stmt->bindParam(5, $now);
    $stmt->bindParam(6, $now);

    // 6. execute our query
    $stmt->execute();
}