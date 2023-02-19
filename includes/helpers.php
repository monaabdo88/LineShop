<?php
include "../dashboard/config.php";
include "functions/functions.php";
//add to favourit list
if(isset($_GET) && $_GET['action'] == 'add_to_fav'):
$product_id = isset($_GET['p_id']) ? $_GET['p_id']: null;
$method = isset($_GET['method'])? $_GET['method'] : null;
$user_id = isset($_GET['user_id'])? $_GET['user_id']: null;
        add_to_fav($method,$user_id,$product_id);
endif;
//add to cart
