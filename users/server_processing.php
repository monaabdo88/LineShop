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
//$table = 'favs';
$user_id = intval($_GET['user_id']);
//$table = '(SELECT * FROM favs WHERE user_id = '.$user_id.') tbl';
$table = '(SELECT f.*, p.title, p.price , p.quantity FROM favs f INNER JOIN products p ON f.product_id = p.id WHERE f.user_id='.$user_id.') tbl';

// Table's primary key
$primaryKey = 'id';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes

$columns = array(
    array('db'  => 'id', 'dt'   => 0,
            'formatter' => function($d){
                return "<input type='checkbox'  onchange='toggleCheckbox()' name='checkProduct[]' value='$d'/>";
            }
        ),
    array( 'db' => 'id', 'dt' => 1 ),
    array( 'db' => 'title','dt' => 2),
    array('db'  => 'price',     'dt'    => 3),
    array('db'  => 'quantity',     'dt'    => 4),
    array(
        'db'        => 'id',
        'dt'        => 5,
        'formatter' => function ($d){
            return "
            <a onclick='confirmation(event)' href='?do=delProduct&id=$d' class='btn btn-sm btn-danger btn-non'> <i class='fa fa-trash'></i></a>";
        }
    ),
    array(
        'db'        => 'product_id',
        'dt'        => 6,
        'formatter' => function ($d){
            return "
           <a href='product?product_id=$d' class='btn btn-sm btn-warning btn-non'><i class='fa fa-eye'></i></a>";
        }
    )
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