<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$webpage = file_get_contents('http://webcache.googleusercontent.com/search?q=cache:https://www.tumblr.com/explore/video&num=1&strip=0&vwsrc=1');

  $keywordListPosition = strpos($webpage, 'discover-search-terms');
  $webpageCode = substr($webpage, $keywordListPosition);


  $keywordListPosition = strpos($webpageCode, '/ol');

  $length = strlen($webpageCode);
  $difference = $keywordListPosition-$length;
  $webpageCode = substr($webpageCode, 0, $difference);

  $terms = substr_count($webpageCode, 'search-term-name');
  $keywords;
  $characterPos;

  for ($i = 0; $i <= $terms; $i++) {
      if ($i > 0) {
          $keywordListPosition = strpos($webpageCode, 'search-term-name', (234*$i));
      } else {
          $keywordListPosition = strpos($webpageCode, 'search-term-name');
      };
      $tempWebpage = substr($webpageCode, ($keywordListPosition+26));
      $end = strpos($tempWebpage, '/span');
      $length = strlen($tempWebpage);
      $difference = $end-$length;
      $tempWebpage = substr($tempWebpage, 0, $difference-4);
      $keywords[$i]=$tempWebpage;
  };
  
//   $videoLink= str_replace("\/","/", $videoLink);
//
// discover-tags
//
// search-term-name

// echo "<html>
// <body>
// <textarea>".$webpageCode ."</textarea>
// </body>
// </html>
// ";
?>
