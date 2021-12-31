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
        }elseif(isset($url) && $url != NULL){
            $url;
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
function to get rows count of table
take on var table name
*/
if(! function_exists('get_rows')){
    function get_rows($tblname,$count = 0){
        global $con;
        $stmt = $con->prepare("SELECT * FROM $tblname");
        $stmt->execute();
        if($count !=0){
            $rows = $stmt->rowCount();
        }
        else{
            $rows = $stmt->fetchAll();

        }
        return $rows;
        
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
    function get_row_data($tbl,$col_name = 'id',$id){
        global $con;
        $stmt = $con->prepare("SELECT * FROM $tbl WHERE $col_name = ?");
        $stmt->execute(array($id));
        if($tbl == 'files')
            $row = $stmt->fetchAll();
        else
            $row = $stmt->fetch();
        return $row;
    }
}
/*
function to get rows related to another column
get tbl name, column name and column value
*/
if(! function_exists('get_related_data')){
    function get_related_data($tbl,$col_name,$col_val){
        global $con;
        $stmt = $con->prepare("SELECT * FROM $tbl WHERE $col_name = ?");
        $stmt->execute(array($col_val));
        $row = $stmt->fetchall();
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
    function get_item($column,$tbl,$col_name,$id){
        global $con;
        $stmt = $con->prepare("SELECT $column FROM $tbl WHERE $col_name = ?");
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
Main function to delete all records
get two vars ids,tblname
*/
if(! function_exists('delete_all_rows')){
    function delete_all_rows(){
        global $con;
        $msg = '';
        $ids = $_POST['ids'];
        $tblname = $_POST['tblname'];
        foreach($ids as $id){
            if($tblname == 'categories'){
                $img = get_item('image','categories','id',$id);
                if($img != ''){
                    unlink('../assets/uploads/categories/'.$img);
                }
            }
            elseif($tblname == 'products'){
                //delete product tags
                delete_product_tags($id);
                //delete product images
                delete_product_images($id);
            }
            $stmt = $con->prepare("DELETE FROM $tblname WHERE id = :zid");
            $stmt->bindParam(":zid", $id);
            $stmt->execute();
            $msg = show_msg('success','Selected Records Deleted Successfully');
        
        }
        echo $msg;
        redirectPage('back');
    }
}