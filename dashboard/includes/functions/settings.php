<?php 
/*
function to update site settings
*/
if(! function_exists('update_settings')){
    function update_settings(){
        global $con;
        $logo = get_item('site_logo','settings',1);
        $msg = '';
        // Site logo check and upload start
        if($_FILES['site_logo']['size'] != 0){
            unlink($logo);
            //upload Site logo
            $target_dir = "../assets/uploads/settings/";
            $file_name = resize_image($target_dir,$_FILES['site_logo']['tmp_name'],$_FILES['site_logo']['type']);
            $target_file = $target_dir.$file_name;
        }else{
            $target_file = $logo;
        }// end site logo upload

        //prepare data to update
        $site_name = $_POST['site_name'];
        $site_email = $_POST['site_email'];
        $site_phone = $_POST['site_phone'];
        $site_desc = $_POST['site_desc'];
        $site_tags = $_POST['site_tags'];
        $site_status = $_POST['site_status'];
        $site_text_close = $_POST['site_text_close'];
        $site_copyrights = $_POST['site_copyrights'];
        $userid = $_SESSION['admin_id'];
        $stmt = $con->prepare("UPDATE settings SET 
        site_name       = ?,
        site_email      = ?,
        site_phone      = ?,
        site_desc       = ?,
        site_tags       = ?,
        site_status     = ?,
        site_text_close = ?,
        site_copyrights = ?,
        site_logo       = ?,
        userid          =? 
        ");
        $upData = $stmt->execute(array($site_name,$site_email,$site_phone,$site_desc,$site_tags,$site_status,$site_text_close,$site_copyrights,$target_file,$userid));
        if($upData){
            $msg =show_msg('success','Settings Updated Successfully');
        }//end of check update
        echo $msg;
        redirectPage('back');
    }// end of function
}
