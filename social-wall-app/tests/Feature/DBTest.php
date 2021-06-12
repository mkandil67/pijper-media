<?php

namespace Tests\Feature;

use App\Models\Categories;
use App\Models\User;
use PDO;
use Tests\TestCase;

class DBTest extends TestCase
{
    /** @test tests the database connection */
    public function test_database_connection() {
        $host = "127.0.0.1";
        $db_name = "users-pijper";
        $username = "root";
        $password = "";
        $connection_status = false;

        try {
            $con = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
            // set the PDO error mode to exception
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $connection_status = true;
        }
        catch(PDOException $e) {
            $connection_status = false;
            echo "Connection failed: " . $e->getMessage();
        }
        $this->assertEquals($connection_status, true);
    }

    /** @test tests inserting row in accounts and posts table */
    public function test_database_account_post_inserting() {
        $host = "127.0.0.1";
        $db_name = "users-pijper";
        $username = "root";
        $password = "";

        try {
            $con = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
            // set the PDO error mode to exception
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }

        // get the current date/time
        $now = date("Y-m-d H:i:s");


        // Test if the accounts table of the database is empty
        $this->assertDatabaseCount('accounts', 0);

        // add an account to the database
        $query = "INSERT INTO accounts (category, platform, data_source, followers_count, created_at, updated_at)
            VALUES ('Cars','facebook', 'TopGear', 12345, ?, ?)";
        $stmt = $con->prepare( $query );
        $stmt->bindParam(1, $now);
        $stmt->bindParam(2, $now);
        $stmt->execute();

        // Test if there is a new account in the database
        $this->assertDatabaseCount('accounts', 1);



        // Test if the posts table of the database is empty
        $this->assertDatabaseCount('posts', 0);

        // add a post to the table
        $query = "INSERT INTO posts (post_id, caption, post_url, image_url, is_trending, is_viral, engagement, old_engagement, writer_id, posted_at, account_id, created_at, updated_at)
            VALUES (123, 'This is a caption!', 'test.url/1234', 'test.url/12345', false, false, 10, 0, null, null, 1, ?, ?)";
        $stmt = $con->prepare( $query );
        $stmt->bindParam(1, $now);
        $stmt->bindParam(2, $now);
        $stmt->execute();

        // Test if there is a new post in the database
        $this->assertDatabaseCount('posts', 1);
    }

    /** @test tests inserting row in users and categories table */
    public function test_database_user_categories_preference_inserting()
    {
        $host = "127.0.0.1";
        $db_name = "users-pijper";
        $username = "root";
        $password = "";

        try {
            $con = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
            // set the PDO error mode to exception
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }

        // Test adding of a user
        $this->assertDatabaseCount('users', 0);
        User::factory()->create();
        $this->assertDatabaseCount('users', 1);


        // Test adding of a categories preference
        $this->assertDatabaseCount('categories', 0);
        $old_insertArray = array(
            'user_id' => 1,
            'News' => 1,
            'Showbizz/Entertainment' => 0,
            'Royals' => 0,
            'Food/Recipes' => 0,
            'Lifehacks' => 0,
            'Fashion' => 0,
            'Beauty' => 1,
            'Health' => 0,
            'Family' => 0,
            'House and garden' => 0,
            'Cleaning' => 0,
            'Lifestyle' => 0,
            'Cars' => 1,
            'Crime' => 0,
        );
        Categories::create($old_insertArray);
        $this->assertDatabaseCount('categories', 1);
        $this->assertDatabaseHas('categories', $old_insertArray);

        $new_insertArray = array(
            'user_id' => 1,
            'News' => 1,
            'Showbizz/Entertainment' => 0,
            'Royals' => 0,
            'Food/Recipes' => 0,
            'Lifehacks' => 0,
            'Fashion' => 0,
            'Beauty' => 0,
            'Health' => 1,
            'Family' => 0,
            'House and garden' => 0,
            'Cleaning' => 0,
            'Lifestyle' => 1,
            'Cars' => 0,
            'Crime' => 0,
        );
        Categories::query()->where('user_id', 1)->update($new_insertArray);
        $this->assertDatabaseCount('categories', 1);
        $this->assertDatabaseHas('categories', $new_insertArray);
    }

    /** @test tests updates to a row in accounts and posts table */
    public function test_database_accounts_posts_updating()
    {
        $host = "127.0.0.1";
        $db_name = "users-pijper";
        $username = "root";
        $password = "";

        try {
            $con = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
            // set the PDO error mode to exception
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }

        $now = date("Y-m-d H:i:s");

        $oldData = array(
            'category' => 'Cars',
            'platform' => 'facebook',
            'data_source' => 'TopGear',
            'followers_count' => 12345
        );
        $newData = array(
            'category' => 'Cars',
            'platform' => 'facebook',
            'data_source' => 'TopGear',
            'followers_count' => 2021
        );

        $this->assertDatabaseHas('accounts', $oldData);
        $query = "UPDATE accounts SET followers_count = 2021, updated_at = ? WHERE data_source = 'TopGear' AND platform = 'facebook'";
        $stmt = $con->prepare( $query );
        $stmt->bindParam(1, $now);
        $stmt->execute();
        $this->assertDatabaseHas('accounts', $newData);

        $oldPost = array(
            'post_id' => 123,
            'caption' => 'This is a caption!',
            'post_url' => 'test.url/1234',
            'image_url' => 'test.url/12345',
            'is_trending' => 0,
            'is_viral' => 0,
            'engagement' => 10,
            'old_engagement' => 0,
            'writer_id' => null,
            'posted_at' => null,
            'account_id' => 1
        );

        $newPost = array(
            'post_id' => 123,
            'caption' => 'This is a caption!',
            'post_url' => 'test.url/1234',
            'image_url' => 'test.url/12345',
            'is_trending' => 0,
            'is_viral' => 0,
            'engagement' => 20,
            'old_engagement' => 10,
            'writer_id' => null,
            'posted_at' => null,
            'account_id' => 1
        );

        $this->assertDatabaseHas('posts', $oldPost);

        $query = "UPDATE posts SET engagement = 20, old_engagement = 10, updated_at = ? WHERE post_id = 123";
        $stmt = $con->prepare( $query );
        $stmt->bindParam(1, $now);
        $stmt->execute();

        $this->assertDatabaseHas('posts', $newPost);
    }


}
