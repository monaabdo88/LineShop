<?php 
/*
function to update site settings
*/
if(! function_exists('update_settings')){
    function update_settings(){
        global $con;
        $logo = get_item('site_logo','settings','id',1);
        $slider = get_item('slider_background','settings','id',1);
        $msg = '';
        // Site fav icon check and upload start
        if($_FILES['site_logo']['size'] != 0){
            unlink('../'.$logo);
            //upload Site logo
            $target_dir = "assets/uploads/settings/";
            $file_name = resize_image('../'.$target_dir,$_FILES['site_logo']['tmp_name'],$_FILES['site_logo']['type']);
            $target_file = $target_dir.$file_name;
        }else{
            $target_file = $logo;
        }// end site fav icon upload
        //site slider background upload
        if($_FILES['slider_background']['size'] != 0){
            unlink('../'.$slider);
            //upload Site logo
            $target_dir = "assets/uploads/settings/";
            $file_name = resize_image('../'.$target_dir,$_FILES['slider_background']['tmp_name'],$_FILES['slider_background']['type'],1900,700);
            $slider_background = $target_dir.$file_name;
        }else{
            $slider_background = $slider;
        }// end site fav icon upload
        //prepare data to update
        $site_name          = $_POST['site_name'];
        $site_email         = $_POST['site_email'];
        $site_phone         = $_POST['site_phone'];
        $site_desc          = $_POST['site_desc'];
        $site_tags          = $_POST['site_tags'];
        $site_status        = $_POST['site_status'];
        $site_text_close    = $_POST['site_text_close'];
        $site_copyrights    = $_POST['site_copyrights'];
        $site_address       = $_POST['site_address'];
        $fb_url             = $_POST['fb_url'];
        $tw_url             = $_POST['tw_url'];
        $ln_url             = $_POST['ln_url'];
        $wh_url             = $_POST['wh_url'];
        $site_summery       = $_POST['site_summery'];    
        $userid             = $_SESSION['admin_id'];
        //Validation
        if($site_name == ''){
            $msg =show_msg('error','Site Name Required');
        }
        elseif($site_email == ''){
            $msg =show_msg('error','Site Email Required');
        }
        elseif($site_phone == ''){
            $msg =show_msg('error','Site Phone Required');
        }
        elseif($site_desc == ''){
            $msg =show_msg('error','Site Description Required');
        }
        elseif($site_tags == ''){
            $msg = show_msg('error','Site Tags Required');
        }
        elseif($site_copyrights == ''){
            $msg = show_msg('error','site Copyrights Required');
        }
        else{
            //update settings code
            $stmt = $con->prepare("UPDATE settings SET 
            site_name           = ?,
            site_email          = ?,
            site_phone          = ?,
            site_desc           = ?,
            site_tags           = ?,
            site_status         = ?,
            site_text_close     = ?,
            site_copyrights     = ?,
            site_logo           = ?,
            site_summery        = ?,
            fb_url              = ?,
            tw_url              = ?,
            ln_url              = ?,
            wh_url              = ?,
            site_address        = ?,
            slider_background   = ?,
            userid              = ? 
            ");
            $upData = $stmt->execute(array(
                $site_name,$site_email,$site_phone,$site_desc,
                $site_tags,$site_status,$site_text_close,
                $site_copyrights,$target_file,$site_summery,
                $fb_url,$tw_url,$ln_url,$wh_url,$site_address,$slider_background,$userid));
            if($upData){
                $msg =show_msg('success','Settings Updated Successfully');
            }//end of check update
        }
        
        echo $msg;
        redirectPage('settings.php');
    }// end of function
}
