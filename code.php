
<?php
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="excel1.csv"');

$xml = simplexml_load_file("part1.xml");
$i=0;
$line=array();

foreach($xml->row as $row){
$sender = str_replace("undefined", "", $xml->row[$i]->sender_address);
if (\strpos($xml->row[$i]->recipient_status, 'undefined') !== false) {
$reciever = str_replace("undefined", ";", $xml->row[$i]->recipient_status);
$data = str_getcsv($reciever, ";"); 
$len=count($data);
foreach($data as &$row){ $row = str_getcsv($row, "##");}
$data=array_slice($data,0,$len-1);
}else{
$data = str_getcsv($xml->row[$i]->recipient_status, ";"); 
foreach($data as &$row){ $row = str_getcsv($row, "##");}
}


unset($reciever);
$reciever=array();
foreach($data as $r){
array_push($reciever,$r[0]);}
unset($line);
$line=array();
array_push($line,$sender);

foreach($reciever as $rec){
array_push($line,$rec);}
$fp = fopen('php://output', 'wb');
fputcsv($fp,$line,"\n");
fclose($fp);
$i=$i+1;
}

?>