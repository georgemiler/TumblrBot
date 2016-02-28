<?php
/**
 * Tumblr

 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "tumblr.php-master/vendor/autoload.php";
include "tumblr.php-master/lib/Tumblr/API/Client.php";
include "tumblr.php-master/lib/Tumblr/API/RequestException.php";
include "tumblr.php-master/lib/Tumblr/API/RequestHandler.php";

$client = new Tumblr\API\Client(
  'MCC0eoLjJxKx211XKLwT2c9HXkeTkL5QmaKpotO34vTahXz1Ov',
  '4blwheWahpg5oQJTOeR3oG6MDHk13Vi9AhmKjv1YbTyHtA98JV',
  'tdgnL84cy51XkHLMDZsYOUCJIxqKhslQiURDoxnjyWnLIK8uEm',
  '6lppQK9CLPSBBw3Qtzeoq4VQX4U1WdmdeCljcy9BqrD6IQcG8Q'
);

// Make the request
$data = $client->getBlogFollowers('squirescreen.tumblr.com', array('limit' => 5));

foreach ($data->users as $key => $follower) {
    // Make the request

    $userdata = $client->getBlogPosts($follower->name, array('limit' => 3));
    $posts = $userdata->posts;
    if (! empty($posts)){
        foreach ($posts as $key => $post) {
            $client->like($post->id, $post->reblog_key);
        };
    };

};

echo 'success';

?>
