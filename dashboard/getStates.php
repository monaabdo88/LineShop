<?php
include "../init.php";
$country_id = intval($_POST['country_id']);
$rows = get_related_data('states','country_id',$country_id);
foreach($rows as $row){
    echo '<option value='.$row['id'].'>'.$row['name'].'</option>';
}
