

<html>
<body>

 <?php
 
 $file=$_POST["csvfile"];
 $adrs= file("firma.csv");
 foreach($adrs as $webadr){
	if(strpos($webadr,'@com') !== false){
    $adr = explode("@com", $webadr);
	$webadr=$adr[0].".com";
	}
	if(!(strpos($webadr,'195'))&&!(strpos($webadr,'@'))){
	if(strpos($webadr,'.com.tr') !== false){
    $adr = explode(".com.tr", $webadr);
	//com.tr nin sonda olma durumu
	       if((strpos($adr[0],'.com') !== false)&& !(strpos($adr[0],'www.com') !== false)){
			$x=explode("/",$adr[0]);
			wrt($x[0],$file);
			$webadr=$x[1].".com.tr";
		   }else if(strpos($adr[1],'.com') !== false){
			$webadr=$adr[0].".com.tr";
			$x=explode("/",$adr[1]);
		    wrt($x[0],$file);
		   }else{
           $adr = explode(".com.tr", $webadr);
		   $webadr=$adr[0].".com.tr";		}
	}else if(strpos($webadr,'.com') !== false){
    $adr = explode(".com", $webadr);
	$webadr=$adr[0].".com";		
	}else if(strpos($webadr,'.net') !== false){
    $adr = explode(".net", $webadr);
	$webadr=$adr[0].".net";	
    }else if(strpos($webadr,'.org.tr') !== false){
    $adr = explode(".org.tr", $webadr);
	$webadr=$adr[0].".org.tr";			
	}else if(strpos($webadr,'.tech') !== false){
    $adr = explode(".tech", $webadr);
	$webadr=$adr[0].".tech";
	}else if(strpos($webadr,'.edu.tr') !== false){
    $adr = explode(".edu.tr", $webadr);
	$webadr=$adr[0].".edu.tr";
	}else if(strpos($webadr,'www@') !== false){
    $adr = explode("www@", $webadr);
	$webadr=$adr[0];
	}else if(strpos($webadr,'.es') !== false){
    $adr = explode(".es", $webadr);
	$webadr=$adr[0]."es";
	}
$adr=array();
 if((strpos($webadr, 'http:')!== false) ||(strpos($webadr,'https:') !== false)){
	if((strpos($webadr,'www.')!== false)||(strpos($webadr,'WWW.')!== false)){
        $adr = explode(".", $webadr);
        array_shift($adr);
        $link=implode(".",$adr);
	}else if(strpos($webadr,'www')!== false){
        $adr = explode("www", $webadr);
        array_shift($adr);
        $link=implode(".",$adr);
	}else if(strpos($webadr,'WWW')!== false){
		 $adr = explode("WWW", $webadr);
        array_shift($adr);
        $link=implode(".",$adr);
	}else{
		$adr = explode("://", $webadr);
		$link=$adr[1];
	}
 }else{	
    if((strpos($webadr, 'www.') !== false)||(strpos($webadr,'WWW.')!== false)){
        $adr = explode(".", $webadr);
        array_shift($adr);
        $link=implode(".",$adr);		
	}else if(strpos($webadr, 'www') !== false){
		$adr = explode("www", $webadr);
        $link=implode("",$adr);	
	}else if(strpos($webadr,'WWW')!== false){
		$adr = explode("WWW", $webadr);
        $link=implode("",$adr);	
	}else{
		$link = $webadr;
	}
	wrt($link,$file);
 }
  }}
  
  
function wrt($link,$file){
echo "<br>";
echo "WEB ADDRESS IS :  ";
echo $link; 
echo "<br>";
echo "<br>";
echo "MAILS :  ";
echo "<br>";
$data = file($file);
foreach ($data as $line){
if($line!=NULL){
$lin=$line;

list($var,$value) = array_pad(explode('@', $line),2,null);
//echo $link;
if(trim($value)==trim($link)){	
echo $lin;
echo "<br>";
}
 }}}

 ?>
</body>
 </html>