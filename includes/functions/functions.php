<?php
/*
Function To Print Page title
Return Pae title
*/
if(!function_exists('get_title_cp')){
    function get_title_cp($pageTitle = NULL){
        //global $pageTitle;
        if(isset($pageTitle)){
            echo $pageTitle;
        }else{
            echo "Dashboard";
        }
    }
}
/*
Function To Redirect to the prev page
take two vars the prev page  Link and Time to redirect
*/
if(! function_exists('redirectPage')){
    function redirectPage($url= NULL, $seconds = 5){
        if($url === NULL)
        {
            $url = "index.php";
            $link = "HomePage";
        }
        else{
            if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {
                $url = $_SERVER['HTTP_REFERER'];
                $link = "Previous Page";
            }else{
                $url = "index.php";
                $link = "HomePage";
            }
        }
        header("refresh:$seconds,url=$url");
        exit();
    }
}
