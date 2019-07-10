
<?php
function hour_to_second($in){
    $str_time = $in;
    $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $str_time);
    sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
    return( $hours * 3600 + $minutes * 60 + $seconds);
}
function second_to_hour($sec)
{
    return gmdate("H:i:s", $sec);
}
$string = file_get_contents("test2.json");
$json_a = json_decode($string, true);
foreach ($json_a as $PDKSKODU => $person) {
	$giris=$person['Giris'];
	if(!strcmp($person['Giris'],"")){$giris="08:30:00";}else{$giris=$person['Giris'];}
	if(!strcmp($person['Cikis'],"")){$cikis="18:30:00";}else{$cikis=$person['Cikis'];}
	echo "INSERT INTO `pdks` ( `pdks_kodu`, `pdks_tarih`, `pdks_giris`, `pdks_cikis`, `pdks_toplam`, `pdks_aktif`) 
	VALUES ( ";
    echo "'".$person['PDKSKODU']."', ";
	$tarih=explode(".",$person['Tarih']);
	$len=3;
	foreach($tarih as $key){
	$yeni[$len-1]=$key;
    $len=$len-1;	
	}
	//$x=implode(".",$yeni);
	$yenitarih=$yeni[0]."-".$yeni[1]."-".$yeni[2];
    echo "'".$yenitarih."', ";
	echo "'".$giris."', ";
	echo "'".$cikis."', ";
	$ilksaatstr=strtotime($giris);
    $sonsaatstr=strtotime($cikis);//aynı şekilde saatleride strtotime liyoırum
    $pdks_toplam_saniye=$sonsaatstr-$ilksaatstr;//sondan ilki çıkarıyom direk bize saniyeyi verecek
	
	
	$net_is="09:00:00";
	$net_yemek="01:00:00";
    $net_is_saniye=hour_to_second($net_is);
    $net_yemek_saniye=hour_to_second($net_yemek);


if($pdks_toplam_saniye>($net_is_saniye+$net_yemek_saniye)){
    $new_mesai=second_to_hour($pdks_toplam_saniye-$net_yemek_saniye);
    $new_pdks_toplam=second_to_hour($pdks_toplam_saniye-$net_yemek_saniye);
}elseif ($net_is_saniye<$pdks_toplam_saniye and $pdks_toplam_saniye<($net_is_saniye+$net_yemek_saniye)){
    $new_mesai=second_to_hour($net_is_saniye);
    $new_pdks_toplam=second_to_hour($net_is_saniye);
}elseif ($pdks_toplam_saniye<=$net_is_saniye){
    $new_mesai=second_to_hour($net_is_saniye);
    $new_pdks_toplam=second_to_hour($pdks_toplam_saniye);
}

    echo "'".$new_pdks_toplam."','1'),";
	//echo "'".second_to_hour($pdks_toplam_saniye)."','1'),"; //kontrol için ilk dosyadaki cıkış-giriş saati 
	echo "<br>";
}
//rename('test2.json', 'C:\wamp64\www\test2.json');  //dosya taşıma taşırken siliyor
?>
