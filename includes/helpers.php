<?php
include "../dashboard/config.php";
include "functions/functions.php";
//main vars
        $product_id = isset($_GET['p_id']) ? $_GET['p_id']: null;
        $method = isset($_GET['method'])? $_GET['method'] : null;
        $user_id = isset($_GET['user_id'])? $_GET['user_id']: null;
        $price = isset($_GET['price'])? $_GET['price']: null;    
        $cart_total = isset($_GET['cart_total'])? $_GET['cart_total']: null;
        //send message vars
        /*$sender_name = isset($_GET['sender_name'])? $_GET['sender_name']: null; 
        $sender_email = isset($_GET['sender_email'])? $_GET['sender_email']: null;*/
        $replay_id = isset($_GET['r_id'])? $_GET['r_id']: null;
        $sender_msg = isset($_GET['sender_msg'])? $_GET['sender_msg']: null;
        $p_author = isset($_GET['p_author'])? $_GET['p_author']: null;
        $msg_sub = isset($_GET['subject'])? $_GET['subject']: null;
        $comment = isset($_GET['comment'])? $_GET['comment']: null;
        $action = isset($_GET) ? $_GET['action'] : '';

//add to favourit list
if($action == 'add_to_fav'):
        add_to_fav($method,$user_id,$product_id);
endif;
//add to cart
if($action == 'add_to_cart'):
        add_to_cart($method,$user_id,$product_id,$price,$cart_total);
endif;
//send message in product page
if($action == 'send_product_msg')
{
        send_product_msg($p_author,$product_id,$sender_msg,$user_id,$sender_msg,$msg_sub,$replay_id);
}
//submit new comment
if($action == 'add_comment')
{
        add_new_comment($user_id,$product_id,$comment);
}