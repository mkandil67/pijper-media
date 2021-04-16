<?php
// 1. database credentials
use InstagramScraper\Exception\InstagramNotFoundException;

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
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();}

require_once __DIR__ . '/vendor/autoload.php'; // change path as needed

// Initializing an array of categories
$categories = array(
    'News',
    'Showbizz/Entertainment',
//    'Royals',
    'Food/Recipes',
//    'Lifehacks',
//    'Fashion',
//    'Beauty',
//    'Health',
//    'Family',
//    'House and Garden',
//    'Cleaning',
//    'Lifestyle',
    'Cars',
//    'Crime',
);
// Initializing an array of souces inside categories
$sources = array(
    'News' => array(
        'nos',
////        'rtlnieuws',
////        'AD.NL',
////        'nu.nl',
////        'Metro',
////        'telegraaf',
////        'Trouw.nl',
////        'MetroUK',
////        'hln.be',
////        'cnninternational',
    ),
    'Showbizz/Entertainment' => array(
        'lindanieuws',
    ),
//    'Royals',
    'Food/Recipes' => array(
        'tasty',
////        'delish',
////        'EatThisNotThat',
////        'thekitchn',
////        'favorflav',
////        'nvwa.nl',
////        'voedingscentrum',
////        'CulyNL',
////        'Freshhhmag',
////        'JungleTwisted',
////        'yummly',
////        'realsimple',
////        'sterkindekeuken',
////        'WomensHealthNL',
////        '24kitchen',
////        'thespruceeats',
////        'TheHealthy',
////        'BBCGoodFood',
////        'ELLEeten',
////        'bonappetitmag',
////        'RecipeGirl',
    ),
//    'Lifehacks',
//    'Fashion',
//    'Beauty' => array(
////        'hello',
////        'GlamourNL',
////        'VorstenNL',
////        'Royaltynl',
////        'libelleNL',
////        'margrietNL',
////        'Tatlermagazine',
////        'VogueNL',
////        'enews',
////        'ModekoninginMaxima',
//    ),
//    'Health',
//    'Family',
//    'House and Garden',
//    'Cleaning',
//    'Lifestyle',
    'Cars' => array(
        'topgearnl',
////        'automotorundsport',
////        'AutoWeek',
////        'autobild',
////        'RoadandTrack',
////        'autocarofficial',
////        'caranddriver',
////        'jalopnik',
////        'Formula1',
////        'AUTOSPORT',
////        'wearetherace',
////        'autocarofficial',
////        'racingnews365',
////        'dailysportscar',
////        'gptoday.nl',
////        'motorsportcom.nederland',
    ),
//    'Crime',
);

$api_base = 'https://api.twitter.com/';

//Set our bearer token. Now issued, this won't ever* change unless it's invalidated by a call to /oauth2/invalidate_token.
$bearer_token = 'AAAAAAAAAAAAAAAAAAAAACZcOgEAAAAA0zIvzdBz2NLoJFbV6jk%2BFh4XUCE%3DBsw4gI88BSW8NvVY2GS9CrsoKiAKVlLJI4wlrE3rmccMeqHV82';

foreach ($categories as $category) {
    foreach ($sources[$category] as $source) {

        //Try a twitter API request now.
        $opts = array(
            'http' => array(
                'method' => 'GET',
                'header' => 'Authorization: Bearer ' . $bearer_token
            )
        );

        $context = stream_context_create($opts);
        $json = file_get_contents($api_base . '1.1/statuses/user_timeline.json?count=25&screen_name=' . $source, false, $context);

        $data = json_decode($json, true);

        var_dump($data);

        // Looping over all posts to extract data and filter out posts already in database
        foreach ($data as $post) {

            // GATHER THE DATA FROM THE POST
            $post_id = $post['id'];
            $likes = $post['favorite_count'] ?? 0;
            $retweets = $post['retweet_count'] ?? 0;

            // QUERY THE DATABASE FOR A POST WITH THE GIVEN post_id
            $statement = $con->prepare("SELECT * FROM posts WHERE post_id = ?");
            $statement->execute([$post_id]);
            $old_data = $statement->fetch();
            if (is_array($old_data)) {
                // POST IS IN DATABASE, SO UPDATE THE DATA
                echo "Updated post data\n";

                // prepare update query
                $query = "UPDATE posts SET engagement = ?, old_engagement = ?, updated_at = ? WHERE post_id = ?";
                $stmt = $con->prepare( $query );

                //  calculate necessary variables
                $old_engagement = $old_data['engagement'];
                $engagement = $retweets + $likes;
                $now = date('Y-m-d H:i:s');

                // bind the parameters to a variable
                $stmt->bindParam(1, $engagement);
                $stmt->bindParam(2, $old_engagement);
                $stmt->bindParam(3, $now);
                $stmt->bindParam(4, $post_id);
            } else {
                // POST IS NOT IN DATABASE, SO ADD IT
                echo "Added post to database\n";

                // prepare insert query
                $query = "INSERT INTO posts (post_id, category, platform, data_source, caption, post_url, image_url, is_trending, followers_count, engagement, old_engagement, writer_id, posted_at,created_at, updated_at)
            VALUES (?, ?, 'twitter', ?, ?, ?, ?, false, ?, ?, ?, null, ?, ?, ?)";
                $stmt = $con->prepare( $query );

                //  calculate necessary variables
                $engagement = $retweets + $likes;
                $followers_count = $post['user']['followers_count'];
                $data_source = $post['user']['screen_name'];
                $message = $post['text'];
                if (array_key_exists("media", $post)) {
                    $picture_url = $post['media']['media_url'];
                }
                else {
                    $picture_url = $post['user']['profile_image_url'];
                }

                $post_url = "https://twitter.com/".$post['user']['screen_name'].'/status/'.$post['id'];
                $posted_at = date_format(date_create_from_format("D M d H:i:s O Y", $post['created_at']), "Y-m-d H:i:s");
                $now = date("Y-m-d H:i:s");

                // bind the parameters to a variable
                $stmt->bindParam(1, $post_id);
                $stmt->bindParam(2, $category);
                $stmt->bindParam(3, $data_source);
                $stmt->bindParam(4, $message);
                $stmt->bindParam(5, $post_url);
                $stmt->bindParam(6, $picture_url);
                $stmt->bindParam(7, $followers_count);
                $stmt->bindParam(8, $engagement);
                $stmt->bindParam(9, $engagement);
                $stmt->bindParam(10, $posted_at);
                $stmt->bindParam(11, $now);
                $stmt->bindParam(12, $now);
            }
            // execute our query
            $stmt->execute();
        }

    }
}