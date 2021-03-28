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
//        var_dump(array_values($response->getDecodedBody())[0]['data']);

        $followers_count = array_values($response->getDecodedBody())[0];

        $data = array_values($response->getDecodedBody())[1]['data'];

///////////////////// some debugging stuffs for pagination /////////////////////
//$paging = array_values($response->getDecodedBody())[1];
//$edge = $response->getGraphEdge();
//var_dump($paging);
//var_dump($data);
//var_dump($response->getGraphEdge());
///////////////////// some debugging stuffs for pagination /////////////////////


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
                $query = "UPDATE posts SET followers_count = ?, engagement = ?, old_engagement = ?, updated_at = ? WHERE post_id = ?";
                $stmt = $con->prepare( $query );

                //  calculate necessary variables
                $old_engagement = $old_data['engagement'];
                $engagement = $shares + $comments + $likes;
                $now = date('Y-m-d H:i:s');

                // bind the parameters to a variable
                $stmt->bindParam(1, $followers_count);
                $stmt->bindParam(2, $engagement);
                $stmt->bindParam(3, $old_engagement);
                $stmt->bindParam(4, $now);
                $stmt->bindParam(5, $post_id);
            } else {
                // POST IS NOT IN DATABASE, SO ADD IT
                echo "Added post to database\n";

                // prepare insert query
                $query = "INSERT INTO posts (post_id, category, platform, data_source, caption, post_url, image_url, is_trending, followers_count, engagement, old_engagement, writer_id, posted_at,created_at, updated_at)
            VALUES (?, ?, 'facebook', ?, ?, ?, ?, false, ?, ?, ?, null, ?, ?, ?)";
                $stmt = $con->prepare( $query );

                //  calculate necessary variables
                $data_source = $post['from']['name'];
                $message = $post['message'];
                $picture_url = $post['picture'];
                $post_url = $post['permalink_url'];
                $posted_at = $post['created_time'];
                $posted_at = str_replace('T', ' ', $post['created_time']);
                $posted_at = str_replace('+0000', '', $post['created_time']);
                $engagement = $shares + $comments + $likes;
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
