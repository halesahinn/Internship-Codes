
<?php

/* gets the data from a URL */
function get_data($url) {
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}

function extract_email_addresses($str){
    $emails = array();
    $str = strip_tags( $str );
    $str = preg_replace('/\s+/', ' ', $str); 
    $str = preg_replace("/[\n\r]/", "", $str); 
    $remove_chars = array (',', "<", ">", ";", "'", ". ");
    $str = str_replace( $remove_chars, ' ', $str );
    $parts = explode(' ', $str);
    if(count($parts) > 0){
        foreach($parts as $part){
            $part = trim($part);
            if( $part != '' ) {
                if( filter_var($part, FILTER_VALIDATE_EMAIL) !== false){
                    $emails[] = $part;
                }                
            }
        }
    }
    if(count($emails) > 0){
        return $emails;
    }
    else{
        return null;
    }
}
$string =  get_data('https://www.linkedin.com/feed/hashtag/computing');

$matches = extract_email_addresses( $string );
print_r($matches);

?>