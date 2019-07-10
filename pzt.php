<?php
//Örnek Veri Tabanı Bağlantısı
$kullanici = 'root';
$sifre = ''; 
try {
    $db = new PDO('mysql:host=localhost:3306;dbname=mydb;charset=utf8',$kullanici,$sifre);
} catch (PDOException $e) {
    print "Hata!: " . $e->getMessage() . "<br/>";
    die();
}
//Bilgileri Veri Tabanından Alma İşlemi
$sorgu = "SELECT * FROM Emails LIMIT 12";
$data = $db->prepare($sorgu);
$data->execute();
$bilgi = $data->fetchAll(PDO::FETCH_ASSOC);

//Veri Tabanından Alınan Bilgiler İle RSS oluşturma
//Veri Tabanında baslik, icerik, link, tarih isimli sütunların olduğunu varsayıyorum.
//Temel Kısımlar
header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="utf-8"?>';
echo '<rss version="2.0">';
echo '<channel>';
echo '<title>My First - RSS</title>';
echo '<link>http://localhost/ser/mails2.php</link>';
echo '<description>Bilim, gezi, teknoloji, web-tasarım alanlarında güncel bilgi kaynağınız.</description>';
//Sayfaları, RSS Bloğuna Ekleme
//Döngü sayesinde sayfalar için RSS yapıları otomatik oluşturulur.
foreach ($bilgi as $deger) {
echo'<item>';
/*	echo '<title>'.$deger['baslik'].'</title>';
	echo '<link>http://www.siteadi.com/'.$deger['link'].'</link>';*/
	echo '<description>'.$deger['id'].'</description>';
	echo '<description>'.$deger['email'].'</description>';
	echo '<author>yazar@mailadresi.com (Yazar)</author>';
	//echo '<pubDate>'.date('D, d M Y H:i:s T',strtotime($deger['tarih'])).'</pubDate>';
	//echo '<guid isPermaLink="true">http://www.siteadi.com/'.$deger['link'].'</guid>';
echo '</item>';
}
//Temel Düğümleri Kapatma
echo '</channel>';
echo '</rss> ';
?>