<?php
//header('Content-Type: text/csv');
//header('Content-Disposition: attachment; filename="sample.csv"');
//$baslik=array('MAIL LISTESI');
/* gets the data from a URL */


function get_data($url) {
 $ch = curl_init();
  curl_setopt($ch, CURLOPT_TIMEOUT, 1);
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  if(FALSE === ($retval = curl_exec($ch))) {
    error_log(curl_error($ch));
  } else {
    return $retval;
  }
}
$mails=array();
//$string = file_get_contents("https://www.iletisim.gov.tr/turkce/iletisim");
$string = get_data("https://www.iletisim.gov.tr/turkce/iletisim");
$matches = array();
$pattern = '/[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}/i';
//preg_match_all("/[a-z0-9]+[_a-z0-9\.-]*[a-z0-9]+@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})/i", $string, $matches);
preg_match_all($pattern, $string, $matches);
$mails = (array_values(array_unique($matches[0])));
//$len=count($mails);

echo "MAIL LİSTESİ"."<br>";
foreach($mails as $mail){
echo $mail."<br>";	
}

//$fp = fopen('php://output', 'w');
//fputcsv($fp,$baslik);
//fputcsv($fp,$mails,"\n");

//fclose($fp);

?>