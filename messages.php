<?php 
include_once "init.php"; 
include_once $tpl."header.php";
$user_id = $_SESSION['user_id'];
$do = isset($_GET['do']) ? $_GET['do'] : '';
if(isset($user_id)){
?>

<?php 
    
    include_once $tpl."footer.php";
}else{
    redirectPage('index.php',1);
}
?>