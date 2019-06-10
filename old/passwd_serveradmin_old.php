#! /usr/bin/php

<?php

$host='localhost';
$db = 'ts3db';
$username = 'root';
$password = 'fredrik';
$dsn = "mysql:host=$host;dbname=$db";

try{
 // create a PDO connection with the configuration data
 $conn = new PDO($dsn, $username, $password);

 // display a message if connected to database successfully
 if($conn){
 echo "Connected to the database successfully!";
 }
}catch (PDOException $e){
 // report error message
 echo $e->getMessage();
}

$pass=base64_encode(sha1($argv[1], true));
// file_put_contents('secret.txt', "$pass\n", FILE_APPEND);
$stmt = $conn->prepare("UPDATE clients SET client_login_password = :password WHERE client_unique_id = 'serveradmin';");
$stmt->bindParam(':password', $pass, PDO::PARAM_STR);
$stmt->execute();
echo "\nUpdated password in database!\n";
echo "\n";
