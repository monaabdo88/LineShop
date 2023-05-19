<?php
 
/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simple to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */
 
// DB table to use
$user_id = intval($_GET['user_id']);
$type = $_GET['type'];
($type == 'send') ? $col =  'sender_id': $col = 'user_id';
($type == 'send') ? $user_status =  'user_id': $user_status = 'sender_id';

$table = '(SELECT m.*, u.username FROM messages m INNER JOIN users u ON m.'.$user_status.' = u.id WHERE m.'.$col.' = '.$user_id.') tbl';
// Table's primary key
$primaryKey = 'id';
        
$columns = array(
    array('db'  => 'id', 'dt'   => 0,
            'formatter' => function($d){
                return "<input type='checkbox'  onchange='toggleCheckbox()' name='checkMsg[]' value='$d'/>";
            }
        ),
    array('db' => 'id', 'dt' => 1 ),
    array('db' => 'title','dt' => 2),
    array('db'  => 'username','dt'    => 3),
    array('db'  => 'message','dt'    => 4),
    array(
        'db'        => 'product_id',
        'dt'        => 5,
        'formatter' => function ($d){
            return "
           <a href='product?product_id=$d' class='btn btn-sm btn-warning btn-non'><i class='fa fa-eye'></i></a>";
        }
    ),
    array(
        'db'        => 'id',
        'dt'        => 6,
        'formatter' => function ($d){
            return "
            <a href='replay?replay_id=$d' class='btn btn-sm btn-danger btn-non'><i class='fa fa-reply'></i></a>
            <a onclick='confirmation(event)' href='?do=delMsg&id=$d' class='btn btn-sm btn-danger btn-non'> <i class='fa fa-trash'></i></a>";
        }
    ),
    
);
 
// SQL server connection information
$sql_details = array(
    'user' => 'root',
    'pass' => '',
    'db'   => 'lineshop',
    'host' => 'localhost'
);
  
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */
 
require( '../dashboard/ssp.class.php' );

echo json_encode(
   SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
    //SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns ,$where,null)
);