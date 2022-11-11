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
//$table = 'users';
$table = '(SELECT u.*, r.role_name FROM users u INNER JOIN roles r ON u.role_id = r.id) tbl';

// Table's primary key
$primaryKey = 'id';
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array('db'  => 'id', 'dt'   => 0,
            'formatter' => function($d){
                return "<input type='checkbox'  onchange='toggleCheckbox()' name='checkUser[]' value='$d'/>";
            }
        ),
    array( 'db' => 'id', 'dt' => 1 ),
    array('db'  => 'avatar', 'dt' => 2,
        'formatter' => function( $d) {
            if($d != '')
                return "<img  src='../assets/uploads/users/$d' width='50' height='50' class='img-thumbnail img-responsive'/>";
            else
                return "<img  src='../assets/uploads/users/no-img.jpg' width='50' height='50' class='img-thumbnail img-responsive'/>";
            
        }    
    ),
    array('db'  => 'username', 'dt' => 3),
    array('db'  => 'email', 'dt'    => 4),
    array('db' => 'role_name','dt' => 5),
    array(
        'db'        => 'created_at',
        'dt'        => 6,
        'formatter' => function( $d, $row ) {
            return date( 'jS M y', strtotime($d));
        }
    ),
    array(
        'db'        => 'id',
        'dt'        => 7,
        'formatter' => function ($d , $row){
            return "
            <a href='?do=Edit&id=$d' class='btn btn-warning'> <i class='fa fa-pen'></i></a>
            <a onclick='confirmation(event)' href='?do=Delete&id=$d' class='btn btn-danger'> <i class='fa fa-trash'></i></a>
            ";
        }
    )
    
);
 
// SQL server connection information
$sql_details = array(
    'user' => 'u482489328_lineshop',
    'pass' => '@Jskdl2012',
    'db'   => 'u482489328_lineshop',
    'host' => 'localhost'
);
 
 
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */
 
require( '../ssp.class.php' );
 
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);