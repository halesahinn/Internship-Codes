<?php

 try {
	  
$user='newuser';
$pass='newpass';

$conn = new PDO('mysql:host=localhost:3306;dbname=mydb', 'root', '');
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 /*  $conn->exec("CREATE DATABASE `$db`;
                CREATE USER '$user'@'localhost' IDENTIFIED BY '$pass';
                GRANT ALL ON `$db`.* TO '$user'@'localhost';
                FLUSH PRIVILEGES;") 
        or die(print_r($conn->errorInfo(), true));
*/

if( $conn->query('TRUNCATE TABLE mydb.Emails;')==TRUE){
    echo "Table employees created successfully";
} else {
    echo "Error deleting table: " . $conn->error;
}


$sqltable = "CREATE TABLE IF NOT EXISTS Emails(
        id INT(2)  PRIMARY KEY, 
        email VARCHAR(30) NOT NULL )";

if ($conn->query($sqltable) === TRUE) {
    echo "Table employees created successfully";
}


$mails=array();
$string = file_get_contents("https://aiesec.org.tr/iletisim/");
$matches = array();
$pattern = '/[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}/i';
preg_match_all($pattern, $string, $matches);
$mails = (array_values(array_unique($matches[0])));
$len=count($mails);

$i=0;
foreach ($mails as $mail){

  $statement = $conn->prepare('INSERT INTO mydb.Emails (id,email) VALUES (:var1,:var2)');
  $statement->bindParam(':var1',$i);
  $statement->bindParam(':var2',$mail);

 $result= $statement->execute();

	$i++;
};
	  $query = $conn->prepare("select id,email FROM mydb.Emails");
      $query->execute();
      
      for($i=0; $row = $query->fetch(); $i++){
		echo " - ".$row['id']."<br/>".$row['email']."\n";
      }

      unset($query);

 } catch (PDOException $e) {
        die( $e->getMessage());
    }
	

?>