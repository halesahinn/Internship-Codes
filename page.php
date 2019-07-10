<?php


$string = file_get_contents("https://profaj.com/profaj/ekibimiz/");

 $matches = array();
  $pattern = '/[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}/i';
preg_match_all($pattern, $string, $matches);

$neaterArray = (array_values(array_unique($matches[0])));



var_dump($neaterArray);
 $count = count($neaterArray);
 $emailsAsString = implode(", ", $neaterArray);
echo "<h3>$count email addresses in total:</h3> $emailsAsString";

?>