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

        // get the followers count, posts and the source name of the account
        $data = json_decode($json, true);
        $data_source = $data[0]['user']['screen_name'];
        $followers_count = $data[0]['user']['followers_count'];
        // get the current time
        $now = date("Y-m-d H:i:s");

        // query for checking if this account is in the database already
        $statement = $con->prepare("SELECT * FROM accounts WHERE data_source = ? AND platform = 'twitter'");
        $statement->execute([$data_source]);
        $account = $statement->fetch();
        //debugging: var_dump($data);
        if (is_array($account)) {
            // account is in the database
            $query = "UPDATE accounts SET followers_count = ?, updated_at = ? WHERE data_source = ? AND platform = 'twitter'";
            $stmt = $con->prepare( $query );

            // bind the parameters to a variable
            $stmt->bindParam(1, $followers_count);
            $stmt->bindParam(2, $now);
            $stmt->bindParam(3, $data_source);
        } else {
            // account is not in the database
            $query = "INSERT INTO accounts (category, platform, data_source, followers_count, created_at, updated_at)
            VALUES (?,'twitter', ?, ?, ?, ?)";
            $stmt = $con->prepare( $query );

            // bind the parameters to a variable
            $stmt->bindParam(1, $category);
            $stmt->bindParam(2, $data_source);
            $stmt->bindParam(3, $followers_count);
            $stmt->bindParam(4, $now);
            $stmt->bindParam(5, $now);
        }
        // execute our query
        $stmt->execute();

        // get the account id
        $statement = $con->prepare("SELECT id FROM accounts WHERE platform = 'twitter' AND data_source = ?");
        $statement->execute([$data_source]);
        $account_id = $statement->fetch()['id'];

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

                // bind the parameters to a variable
                $stmt->bindParam(1, $engagement);
                $stmt->bindParam(2, $old_engagement);
                $stmt->bindParam(3, $now);
                $stmt->bindParam(4, $post_id);
            } else {
                // POST IS NOT IN DATABASE, SO ADD IT
                echo "Added post to database\n";

                // prepare insert query
                $query = "INSERT INTO posts (post_id, caption, post_url, image_url, is_trending, is_viral, engagement, old_engagement, writer_id, posted_at, account_id, created_at, updated_at)
            VALUES (?, ?, ?, ?, false, false, ?, ?, null, ?, ?, ?, ?)";
                $stmt = $con->prepare( $query );

                //  calculate necessary variables
                $engagement = $retweets + $likes;
                $message = $post['text'];
                $picture_url = $post['entities']['media'][0]['media_url'];
                if ($picture_url == "") {
                    $picture_url = $post['user']['profile_image_url'];
                }
                $post_url = "https://twitter.com/".$post['user']['screen_name'].'/status/'.$post['id'];
                $posted_at = date_format(date_create_from_format("D M d H:i:s O Y", $post['created_at']), "Y-m-d H:i:s");

                // bind the parameters to a variable
                $stmt->bindParam(1, $post_id);
                $stmt->bindParam(2, $message);
                $stmt->bindParam(3, $post_url);
                $stmt->bindParam(4, $picture_url);
                $stmt->bindParam(5, $engagement);
                $stmt->bindParam(6, $engagement);
                $stmt->bindParam(7, $posted_at);
                $stmt->bindParam(8, $account_id);
                $stmt->bindParam(9, $now);
                $stmt->bindParam(10, $now);
            }
            // execute our query
            $stmt->execute();
        }

    }
}