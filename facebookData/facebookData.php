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
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}

require_once __DIR__ . '/vendor/autoload.php'; // change path as needed

$fb = new \Facebook\Facebook([
    'app_id' => '254044855470656',
    'app_secret' => 'a3aad452f3160b6402895a8d25b5fd0a',
    'default_graph_version' => 'v2.10',
    'default_access_token' => '254044855470656|a3aad452f3160b6402895a8d25b5fd0a'
]);

//////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////// THIS IS NOT YET FINISHED ////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////
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
        'linda.nl'
    ),
//    'Royals',
    'Food/Recipes' => array(
        'buzzfeedtasty',
////        'delish',
////        'EatThisNotThat',
////        'thekitchn',
////        'favorflav',
//        'nvwa.nl',
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
    'Beauty' => array(
        'hello',
////        'GlamourNL',
////        'VorstenNL',
////        'Royaltynl',
////        'libelleNL',
////        'margrietNL',
////        'Tatlermagazine',
////        'VogueNL',
////        'enews',
////        'ModekoninginMaxima',
    ),
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
//////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////// THIS IS NOT YET FINISHED ////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////
// Looping over each source inside each category to retrieve recent post data
foreach ($categories as $category) {
    foreach ($sources[$category] as $source) {
        try {
            // Get the \Facebook\GraphNodes\GraphUser object for the current user.
            // If you provided a 'default_access_token', the '{access-token}' is optional.
//            $response = $fb->get('/'. $source .'/posts?fields=permalink_url,shares,message,picture,reactions.limit(0).summary(total_count),comments.limit(0).summary(total_count),created_time,from');
            $response = $fb->get('/' . $source . '?fields=followers_count,posts{permalink_url,shares,message,picture,reactions.limit(0).summary(total_count),comments.limit(0).summary(total_count),created_time,from}');
        } catch(\Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(\Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        // get the followers count, posts and the source name of the account
        $followers_count = array_values($response->getDecodedBody())[0];
        $data = array_values($response->getDecodedBody())[1]['data'];
        $data_source = $data[0]["from"]["name"];
        // get the current time
        $now = date("Y-m-d H:i:s");

        // query for checking if this account is in the database already
        $statement = $con->prepare("SELECT * FROM accounts WHERE data_source = ? AND platform = 'facebook'");
        $statement->execute([$data_source]);
        $account = $statement->fetch();

        if (is_array($account)) {
            // account is in the database
            $query = "UPDATE accounts SET followers_count = ?, updated_at = ? WHERE data_source = ? AND platform = 'facebook'";
            $stmt = $con->prepare( $query );

            // bind the parameters to a variable
            $stmt->bindParam(1, $followers_count);
            $stmt->bindParam(2, $now);
            $stmt->bindParam(3, $data_source);
        } else {
            // account is not in the database
            $query = "INSERT INTO accounts (category, platform, data_source, followers_count, created_at, updated_at)
            VALUES (?,'facebook', ?, ?, ?, ?)";
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

// Looping over all posts to extract data and filter out posts already in database
        foreach ($data as $post) {
            // IF IT IS AN ENGAGEMENT POST SKIP IT
            if (!array_key_exists('message', $post)) {
                echo "skipped a post, no message: $post_id\n";
                continue;
            }
            if (!array_key_exists('picture', $post)) {
                echo "skipped a post, no picture: $post_id\n";
                continue;
            }

            // GATHER THE DATA FROM THE POST
            $post_id = $post['id'];
            $shares = $post['shares']['count'] ?? 0;
            $likes = $post['reactions']['summary']['total_count'] ?? 0;
            $comments = $post['comments']['summary']['total_count'] ?? 0;

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
                $engagement = $shares + $comments + $likes;

                // bind the parameters to a variable
                $stmt->bindParam(1, $engagement);
                $stmt->bindParam(2, $old_engagement);
                $stmt->bindParam(3, $now);
                $stmt->bindParam(4, $post_id);
            } else {
                // POST IS NOT IN DATABASE, SO ADD IT
                echo "Added post to database\n";

                // get the account id corresponding to the post
                $statement = $con->prepare("SELECT id FROM accounts WHERE platform = 'facebook' AND data_source = ?");
                $statement->execute([$data_source]);
                $account_id = $statement->fetch()['id'];

                // prepare insert query
                $query = "INSERT INTO posts (post_id, caption, post_url, image_url, is_trending, engagement, old_engagement, writer_id, posted_at, account_id, created_at, updated_at)
            VALUES (?, ?, ?, ?, false, ?, ?, null, ?, ?, ?, ?)";
                $stmt = $con->prepare( $query );

                //  calculate necessary variables
                $message = $post['message'];
                $picture_url = $post['picture'];
                $post_url = $post['permalink_url'];
                $posted_at = $post['created_time'];
                $posted_at = str_replace('T', ' ', $post['created_time']);
                $posted_at = str_replace('+0000', '', $post['created_time']);
                $engagement = $shares + $comments + $likes;

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
