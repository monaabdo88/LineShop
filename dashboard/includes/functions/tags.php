<?php
/*
function to add new tag
*/
if(! function_exists('add_tag')){
    function add_tag(){
        global $con;
        $msg = '';
        //check if method is post
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //prepare values from add form
            $title          = $_POST['title'];
            $userId         = $_POST['user_id'];
            //check if tag is already exists
            if(checkItem('title','tags',$title) == 1){
                $msg = show_msg('Error','This tag is already exists');
            }else{
                //add new tag to database
                $stmt = $con->prepare("INSERT INTO 
                    tags(title, user_id)
                    VALUES(:ztitle, :zuser)");
                $stmt->execute(array(
                    'ztitle' 	=> $title,
                    'zuser' 	=> $userId
                ));
                // Echo Success Message
                $msg = show_msg('success', $stmt->rowCount() . ' Record Inserted');
                
            }
            echo $msg;
            redirectPage('tags.php');
            
        }
    }
}
/*
function to update tag
*/
if(! function_exists('update_tag')){
    function update_tag(){
        global $con;
        $msg = '';
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //Prepare Values from edit form
            $id         = $_POST['tagID'];
            $user_id    = $_POST['user_id'];
            $title       = $_POST['title'];
           
            //check if the new tag title is exists in another tag
            if(checkItemUp('title','tags',$title,$id) > 0){
                $msg = show_msg('Error','This tag title is Already exists');
            }
            else
            {
                //start update code
                $stmt = $con->prepare("UPDATE 
                                        tags 
                                        SET 
                                        title = ?,
                                        user_id = ?
                                        WHERE
                                        id = ?
                                        ");
                $upData =$stmt->execute(array($title,$user_id,$id));
                //Update Message
                if($upData){
                    $msg = show_msg('success','tag Updated Successfully');
                    
                }
        
            }
            echo $msg;
            redirectPage('back');
        }
    }
}
/*
function to delete tag
*/
if(! function_exists('delete_tag')){
    function delete_tag(){
            global $con;
            $smg = '';
            //check if tag ID from get request
            $tagID = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
            // Select All Data Depend On This ID
            $check = checkItem('id', 'tags', $tagID);
            // If There's Such ID Show The Form
            if ($check > 0) {
              
              //prepare to delete tag
                $stmt = $con->prepare("DELETE FROM tags WHERE id = :zid");
                $stmt->bindParam(":zid", $tagID);
                $stmt->execute();
                $msg = show_msg('success','tag Deleted Successfully');
            } else {
                $msg = show_msg('Error','This tag is Not Found');
            }
            echo $msg;
            redirectPage('tags.php');
    }
}