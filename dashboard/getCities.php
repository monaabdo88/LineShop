<?php
include "../init.php";
$state_id = intval($_POST['state_id']);
$rows = get_related_data('cities','state_id',$state_id);
foreach($rows as $row){
    echo '<option value='.$row['id'].'>'.$row['name'].'</option>';
}
