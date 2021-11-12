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
    /*function redirectPage($url= NULL, $seconds = 5){
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
    }*/
    //updated function
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
        exit();
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
if(! function_exists('get_settings')){
    function get_settings($column){
        global $con;
        $stmt = $con->prepare("SELECT $column FROM settings WHERE id = ?");
        $stmt->execute(array('1'));
        $row = $stmt->fetch();
        if($stmt->rowCount() > 0){
            return $row[$column];
        }
    }
}
