<?php
/*
function to get rows count of table
take on var table name
*/
if(! function_exists('get_rows_count')){
    function get_rows_count($tblname){
        global $con;
        $stmt = $con->prepare("SELECT * FROM $tblname");
        $stmt->execute();
        $rows = $stmt->rowCount();
        return $rows;
    }
}