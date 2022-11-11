<?php
$dsn        = "mysql:host=localhost;dbname=u482489328_lineshop";
$user       = "u482489328_lineshop";
$pass       = "@Jskdl2012";
$options    = array(
    PDO::MYSQL_ATTR_INIT_COMMAND    => 'SET NAMES utf8',
);
try{
    $con = new PDO($dsn,$user,$pass,$options);
    $con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $exc){
    echo "Failed Connecting ".$exc->getMessage();
}