<?php

if (file_exists('./ts3db.ini')){
    $config = file('./ts3db.ini');
} else {
    echo "\nError - No such file: ./ts3db.ini\n";
    echo "\n";
    exit();
}

array_shift($config);

function split($cvar){
    $pieces = explode("=", $cvar);
    return($pieces[1]);
}

$values = array_map("split", $config);

$port = trim($values[1]);
$hostname = trim($values[0]);
$username = trim($values[2]);
$password = trim($values[3]);
$database = trim($values[4]);

$dsn = "mysql:host=$hostname;dbname=$database";
$parameter = empty($argv[1]) ? 'Passw0rd' : $argv[1];
$new_password=base64_encode(sha1($parameter, true));

echo "\n";

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

$stmt = $conn->prepare("UPDATE clients SET client_login_password = :password WHERE client_unique_id = 'serveradmin';");
$stmt->bindParam(':password', $new_password, PDO::PARAM_STR);
$stmt->execute();

echo "\nUpdated password in database!\n";
echo "\n";