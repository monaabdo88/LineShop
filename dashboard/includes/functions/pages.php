<?php
/*
function to add new page
*/
if(! function_exists('add_page')){
    function add_page(){
        global $con;
        $msg = '';
        //check if method is post
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //prepare values from add form
            $title              = $_POST['title'];
            $userId             = $_POST['user_id'];
            $status             = $_POST['status'];
            $content            = $_POST['content'];
            //check if page is already exists
            if(checkItem('title','pages',$title) == 1){
                $msg = show_msg('Error','This page is already exists');
            }else{
                //add new page to database
                $stmt = $con->prepare("INSERT INTO 
                    pages(title, content,user_id,status)
                    VALUES(:ztitle, :zdesc, :zuser, :zstatus)");
                $stmt->execute(array(
                    'ztitle' 	=> $title,
                    'zdesc' 	=> $content,
                    'zuser' 	=> $userId,
                    'zstatus'   => $status
                ));
                
                $msg = show_msg('success',"Record Inserted Successsfully");
                
            }
            echo $msg;
            redirectPage('pages.php');
            
        }
    }
}
/*
function to update page
*/
if(! function_exists('update_page')){
    function update_page(){
        global $con;
        $msg = '';
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //Prepare Values from edit form
            $title              = $_POST['title'];
            $userId             = $_POST['user_id'];
            $status             = $_POST['status'];
            $content            = $_POST['content'];
            $id                 = $_POST['page_id'];
            //check if the new page title is exists in another page
            if(checkItemUp('title','pages',$title,$id) > 0){
                $msg = show_msg('Error','This page title is Already exists');
            }
            else
            {
                //start update code
                $stmt = $con->prepare("UPDATE 
                                        pages 
                                        SET 
                                        title = ?,
                                        content = ?,
                                        status = ?,
                                        user_id = ?
                                        WHERE
                                        id = ?
                                        ");
                $upData =$stmt->execute(array($title,$content,$status,$userId,$id));
                //Update Message
                if($upData)
                    $msg = show_msg('success','page Updated Successfully');
            }
            echo $msg;
            redirectPage('pages.php');
        }
    }
}
/*
function to delete page
*/
if(! function_exists('delete_page')){
    function delete_page(){
            global $con;
            $msg = '';
            //check if page ID from get request
            $page_id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
            // Select All Data Depend On This ID
            $check = checkItem('id', 'pages', $page_id);
            // If There's Such ID Show The Form
            if ($check > 0) {
               
                $stmt = $con->prepare("DELETE FROM pages WHERE id = :zid");
                $stmt->bindParam(":zid", $page_id);
                $stmt->execute();
                
                $msg = show_msg('success','page Deleted Successfully');
            } else {
                $msg = show_msg('Error','This page is Not Found');
            }
            echo $msg;
            redirectPage('pages.php');
    }
}