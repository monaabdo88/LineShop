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
    function redirectPage($url = NULL , $seconds = 5){
        if($url === NULL)
        {
            $url = "index.php";
        }
        else{
            if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {
                $url = $_SERVER['HTTP_REFERER'];
            }
        }
        header("refresh:$seconds,url=$url");
        //exit();
    }
}
/*
Function to display active class to the current page
take on parametar page name
*/
if(! function_exists('isActive')){
    function isActive($pageName){
        $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri_segments = explode('/', $uri_path);
        if($uri_segments[3] == $pageName)
        {
            return 'active';
        }
        else
        {
            return '';
        }

    }
}
/*
function to get all categories and show them into select field
return array of categories
*/
if(! function_exists('fetchCategoryTree')){
    function fetchCategoryTree($parent = 0, $spacing = '', $user_tree_array = '') {
        global $con;
        if (!is_array($user_tree_array))
            $user_tree_array = array();
            $stmt = $con->prepare("SELECT * FROM categories WHERE 1 AND parent_id = ? ORDER BY id ASC");
            $stmt->execute(array($parent));
            $rows = $stmt->fetchAll();
        if ($stmt->rowCount() > 0) {
          foreach ($rows as $row) {
            $user_tree_array[] = array("id" => $row['id'], "name" => $spacing . $row['name']);
            $user_tree_array = fetchCategoryTree($row['id'], $spacing . '&nbsp;&nbsp;', $user_tree_array);
          }
        }
        return $user_tree_array;
      }
}
/*
function to get data from table where id = ?
return the data of row
*/
if(! function_exists('get_row_data')){
    function get_row_data($tbl,$id){
        global $con;
        $stmt = $con->prepare("SELECT * FROM $tbl WHERE id = ?");
        $stmt->execute(array($id));
        $row = $stmt->fetch();
        return $row;
    }
}
/*
function to check if item is already exists in adding new item
take three parmetares the column name , table name and the value of item
*/
if(! function_exists('checkItem')){
    function checkItem($item, $from, $value){
        global $con;
        $statement = $con->prepare("SELECT $item FROM $from WHERE $item = ?");

		$statement->execute(array($value));

		$count = $statement->rowCount();

		return $count;
    }
}
/*
function to check if item is already exists in editing item
take four parmetares the column name , table name and the value of item

*/
if(! function_exists('checkItemUp')){
    function checkItemUp($item, $from, $value,$id){
        global $con;
        $statement = $con->prepare("SELECT $item FROM $from WHERE id != ? AND $item = ?");

		$statement->execute(array($id,$value));

		$count = $statement->rowCount();

		return $count;
    }
}

/*
function to get all data from settings
take the column name
return value of column
*/
if(! function_exists('get_item')){
    function get_item($column,$tbl,$id){
        global $con;
        $stmt = $con->prepare("SELECT $column FROM $tbl WHERE id = ?");
        $stmt->execute(array($id));
        $row = $stmt->fetch();
        if($stmt->rowCount() > 0){
            return $row[$column];
        }
    }
}
/*
function to show return message
take two var
return the msg
*/
if(! function_exists('show_msg')){
    function show_msg($msg_type,$msg){
        if($msg_type == 'Error'){
            return '<script type="text/javascript">
                    $(document).ready(function(){
                        errorFn("'.$msg.'","warning");

                    });
                    
                </script>';
        }else{
            return'<script type="text/javascript">
                    $(document).ready(function(){
                        successFn("'.$msg.'","success");

                    });
                    
                    </script>';

        }
    }
}
/*
function to Resize And Upload Image
get path,tmp_name and file type
*/
if(! function_exists('resize_image')){
    function resize_image($path,$tmp_name,$tmp_type) {
        $file=$tmp_name;
        list($width,$height)=getimagesize($file);
        $nwidth=$width/4;
        $nheight=$height/4;
        $newimage=imagecreatetruecolor($nwidth,$nheight);
        $file_name = '';
        if($tmp_type=='image/jpeg'){
            $source=imagecreatefromjpeg($file);
            imagecopyresized($newimage,$source,0,0,0,0,$nwidth,$nheight,$width,$height);
            $file_name=time().'.jpg';
            imagejpeg($newimage,$path.'/'.$file_name);
        }elseif($tmp_type=='image/png'){
            $source=imagecreatefrompng($file);
            imagecopyresized($newimage,$source,0,0,0,0,$nwidth,$nheight,$width,$height);
            $file_name=time().'.png';
            imagepng($newimage,$path.'/'.$file_name);
        }elseif($tmp_type=='image/gif'){
            $source=imagecreatefromgif($file);
            imagecopyresized($newimage,$source,0,0,0,0,$nwidth,$nheight,$width,$height);
            $file_name=time().'.gif';
            imagegif($newimage,$path.'/'.$file_name);
            
        }
        return $file_name;
     }
}
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
if(! function_exists('up_category')){
    function up_category(){
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
if(! function_exists('del_cat')){
    function del_cat(){
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