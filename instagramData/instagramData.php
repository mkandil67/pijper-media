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

foreach ($categories as $category) {
    foreach ($sources[$category] as $source) {

        $instagram = new \InstagramScraper\Instagram(new \GuzzleHttp\Client());
        try {
            $data = $instagram->getMedias($source);
        } catch (\InstagramScraper\Exception\InstagramException | InstagramNotFoundException $e) {
            echo $e->getMessage();
        }

        // Looping over all posts to extract data and filter out posts already in database
        foreach ($data as $post) {

            // GATHER THE DATA FROM THE POST
            $post_id = $post['id'];
            $likes = $post['likesCount'] ?? 0;
            $comments = $post['commentsCount'] ?? 0;

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
                $engagement = $comments + $likes;
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
            VALUES (?, ?, 'instagram', ?, ?, ?, ?, false, ?, ?, ?, null, ?, ?, ?)";
                $stmt = $con->prepare( $query );

                //  calculate necessary variables
                $followers_count = $post['owner']['followedByCount'];
                $data_source = $post['owner']['username'];
                $message = $post['caption'];
                $picture_url = $post['imageThumbnailUrl'];
                $post_url = $post['link'];
                $posted_at = date("Y-m-d H:i:s", $post['createdTime']);
                $engagement = $comments + $likes;
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