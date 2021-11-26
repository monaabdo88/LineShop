<?php
/*
function to add new Category
*/
if(! function_exists('add_category')){
    function add_category(){
        global $con;
        $msg = '';
        //check if method is post
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //prepare values from add form
            $name           = $_POST['name'];
            $userId         = $_POST['user_id'];
            $status         = $_POST['status'];
            $parent_id      = $_POST['parent_id'];
            $description    = $_POST['description'];
            // Upload Variables
            $imageTmp	    = $_FILES['image']['tmp_name'];
            $imageType      = $_FILES['image']['type'];
            //check if category is already exists
            if(checkItem('name','categories',$name) == 1){
                $msg = show_msg('Error','This Category is already exists');
            }else{
                //upload category Image
                $image = resize_image('../assets/uploads/categories/',$imageTmp,$imageType);
                //add new category to database
                $stmt = $con->prepare("INSERT INTO 
                    categories(name, description, parent_id, user_id, image,status)
                    VALUES(:zname, :zdesc, :zparent, :zuser, :zimage, :zstatus)");
                $stmt->execute(array(
                    'zname' 	=> $name,
                    'zdesc' 	=> $description,
                    'zparent' 	=> $parent_id,
                    'zuser' 	=> $userId,
                    'zimage' 	=> $image,
                    'zstatus'   => $status
                ));
                // Echo Success Message
                $msg = show_msg('success', $stmt->rowCount() . ' Record Inserted');
                
            }
            echo $msg;
            redirectPage('categories.php');
            
        }
    }
}
/*
function to update Category
*/
if(! function_exists('update_category')){
    function update_category(){
        global $con;
        $msg = '';
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //Prepare Values from edit form
            $id         = $_POST['catID'];
            $user_id    = $_POST['user_id'];
            $name       = $_POST['name'];
            $desc       = $_POST['description'];
            $parent     = $_POST['parent_id'];
            $status     = $_POST['status'];
            //check if the new category name is exists in another category
            if(checkItemUp('name','categories',$name,$id) > 0){
                $msg = show_msg('Error','This Category Name is Already exists');
            }
            else
            {
                //upload New Image if there file request
                if(isset($_FILES['image']) && $_FILES['image']['size'] != 0){
                    $dirImg =  "../assets/uploads/categories/";
                    //delete the prev category image
                    if(isset($_POST['oldImg']) && $_POST['oldImg'] != '')
                        unlink($dirImg.$_POST['oldImg']);
                        // Upload Variables
                        $imageTmp	    = $_FILES['image']['tmp_name'];
                        $imageType      = $_FILES['image']['type'];
                        //upload category Image
                        $image = resize_image('../assets/uploads/categories/',$imageTmp,$imageType);
                
                    }else{
                    $image = $_POST['oldImg'];
                }// end upload code
                //start update code
                $stmt = $con->prepare("UPDATE 
                                        categories 
                                        SET 
                                        name = ?,
                                        description = ?,
                                        status = ?,
                                        image = ?,
                                        user_id = ?,
                                        parent_id = ?
                                        WHERE
                                        id = ?
                                        ");
                $upData =$stmt->execute(array($name,$desc,$status,$image,$user_id,$parent,$id));
                //Update Message
                if($upData){
                    $msg = show_msg('success','Category Updated Successfully');
                    
                }
        
            }
            echo $msg;
            redirectPage('back');
        }
    }
}
/*
function to delete Category
*/
if(! function_exists('delete_category')){
    function delete_category(){
            global $con;
            $smg = '';
            //check if category ID from get request
            $catId = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
            // Select All Data Depend On This ID
            $check = checkItem('id', 'categories', $catId);
            // If There's Such ID Show The Form
            if ($check > 0) {
              //delete category image
              $catImg = get_item('image','categories',$catId);
              if(isset($catImg) && $catImg != '')
                unlink("../assets/uploads/categories/".$catImg);
              //prepare to delete category
                $stmt = $con->prepare("DELETE FROM categories WHERE id = :zid");
                $stmt->bindParam(":zid", $catId);
                $stmt->execute();
                $msg = show_msg('success','Category Deleted Successfully');
            } else {
                $msg = show_msg('Error','This Category is Not Found');
            }
            echo $msg;
            redirectPage('categories.php');
    }
}