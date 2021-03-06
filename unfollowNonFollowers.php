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
$i=0;
$followed = $client->getFollowedBlogs();
$followers = $client->getBlogFollowers('squirescreen.tumblr.com');
increaseListAmount();

function increaseListAmount (){
  $i++;
  $followedTemp = $client->getFollowedBlogs(array('offset' => 20*$i));
  $followed = ($followedTemp !==null) ? $followed + $followedTemp: $followed;
  $followersTemp = $client->getBlogFollowers('squirescreen.tumblr.com', array('offset' => 20*$i));
  $followers = ($followersTemp !==null) ? $followers + $followersTemp: $followers;
  if ($followedTemp == null){
    checkForMatches();
  };
};

function checkForMatches (){
  foreach ($followed->blogs as $key => $following) {
      // Make the request

      $checkFollowedName = $following->name;
      $checkFollowedURL = $following->url;

      $match=null;

      foreach ($followers->users as $key => $follower) {
          if ($checkFollowedName == $follower->name) {
              $match=1;
          }
      };
      if ($match ==1) {
          $client->unfollow($checkFollowedURL);
          //echo 'true ';
          //echo $checkFollowedURL;
      } else {
          //echo 'false ';
      }
  };
  updateList($i);
};


echo ' success ';
//$data = $client->getBlogFollowers('squirescreen.tumblr.com');

?>
