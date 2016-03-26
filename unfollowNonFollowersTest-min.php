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
  $followed = $client->getFollowedBlogs();
  file_put_contents("followed.json",json_encode($followed));
  $followers = $client->getBlogFollowers('squirescreen.tumblr.com');
  file_put_contents("followers.json",json_encode($followers));
$i=0;
increaseListAmount($i,$followed->blogs,$followers->users,$client);

function increaseListAmount ($i,$blogs,$users,$client){

  $followedTemp = $client->getFollowedBlogs(array('offset' => 20*$i));
  if($followedTemp !==null){
    array_merge($blogs,$followedTemp->blogs);
      file_put_contents("followed".$i.".json",json_encode($blogs));
  };
  $followersTemp = $client->getBlogFollowers('squirescreen.tumblr.com', array('offset' => 20*$i));
  if ($followersTemp !==null){
    array_merge($users, $followersTemp->users);
    file_put_contents("followers".$i.".json",json_encode($users));
  };
  if ($followedTemp == null){
    //checkForMatches();
    echo 'hello';
  } else {
    $i++;
    increaseListAmount($i,$blogs,$users,$client);
  }
  print_r($blogs);
  echo '          ';
  print_r($users);
};

function checkForMatches (){
  foreach ($followed as $key => $following) {
      // Make the request

      $checkFollowedName = $following->name;
      $checkFollowedURL = $following->url;

      $match=null;

      foreach ($followers as $key => $follower) {
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

//$data = $client->getBlogFollowers('squirescreen.tumblr.com');

?>
