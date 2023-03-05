<?php
include "../dashboard/config.php";
include "functions/functions.php";
//main vars
        $product_id = isset($_GET['p_id']) ? $_GET['p_id']: null;
        $method = isset($_GET['method'])? $_GET['method'] : null;
        $user_id = isset($_GET['user_id'])? $_GET['user_id']: null;
        $price = isset($_GET['price'])? $_GET['price']: null;    
        $cart_total = isset($_GET['cart_total'])? $_GET['cart_total']: null; 
//add to favourit list
if(isset($_GET) && $_GET['action'] == 'add_to_fav'):
        add_to_fav($method,$user_id,$product_id);
endif;
//add to cart
if(isset($_GET) && $_GET['action'] == 'add_to_cart'):
        add_to_cart($method,$user_id,$product_id,$price,$cart_total);
endif;