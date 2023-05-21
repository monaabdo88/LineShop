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
            $url = "index";
        }
        elseif(isset($url) && $url != NULL)
        {
            $url;
        }
        else
        {
            if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {
                $url = $_SERVER['HTTP_REFERER'];
            }
            
        }
        header("refresh:$seconds,url=$url");
        exit;
    }
}
/*
Function to display active class to the current page
take on parametar page name
*/
if(! function_exists('isActive')){
    function isActive($pageName,$page = 2){
        $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri_segments = explode('/', $uri_path);
        if($uri_segments[$page] == $pageName)
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
if(! function_exists('get_rows_count')){
    function get_rows_count($tblname){
        global $con;
        $stmt = $con->prepare("SELECT * FROM $tblname");
        $stmt->execute();
        $rows = $stmt->rowCount();
        return $rows;
        
    }
}
/*
function to get count of childs of column
take tblname,column name and id
*/
if(! function_exists('get_data_column_count')){
    function get_data_column_count($tbl,$col_name,$id){
        global $con;
        $stmt = $con->prepare("SELECT * FROM $tbl WHERE $col_name = ?");
        $stmt->execute(array($id));
        $rows = $stmt->rowCount();
        return $rows;
    }
}
/*
function to get rows of table
take on var table name
*/
if(! function_exists('get_rows')){
    function get_rows($tblname,$limit = '',$rand = ''){
        global $con;
        if($limit != '')
            if($rand != '')
                $stmt = $con->prepare("SELECT * FROM $tblname ORDER BY rand() LIMIT $limit");
            else
                $stmt = $con->prepare("SELECT * FROM $tblname WHERE `status` = 1 ORDER BY id DESC LIMIT $limit");
        else
            $stmt = $con->prepare("SELECT * FROM $tblname ORDER BY id DESC");
        
        $stmt->execute();
        $rows = $stmt->fetchAll();
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
        if (!is_array($user_tree_array)) {
            $user_tree_array = array();
        }
            $stmt = $con->prepare("SELECT * FROM `categories` WHERE 1 AND `parent_id` = ? ORDER BY `id` ASC");
            $stmt->execute(array($parent));
            $rows = $stmt->fetchAll();
        if ($stmt->rowCount() > 0) {
          foreach ($rows as $row) {
                $user_tree_array[] = array("id" => $row['id'], "name" => $spacing . $row['name'],"parent"=> $row['parent_id']);
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
    function get_row_data($tbl,$id,$col_name ="id"){
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
function to fetch all data from tabel
take tblname , column name and the id
*/
if(! function_exists('get_all_rows_data')){
    function get_all_rows_data($tbl,$col,$id,$limit = ''){
        global $con;
        if($limit == ''){
            $stmt = $con->prepare("SELECT * FROM $tbl WHERE $col = ? ORDER BY id DESC");
            $stmt->execute(array($id));  
        }else{
            $stmt = $con->prepare("SELECT * FROM $tbl WHERE $col = ? ORDER BY id DESC LIMIT $limit");
            $stmt->execute(array($id));  
                
        }  
        $rows = $stmt->fetchAll();
        return $rows;
    }
}
/*
function to get rows related to another column
get tbl name, column name and column value
*/
if(! function_exists('get_related_data')){
    function get_related_data($tbl,$col_name,$col_val, $limit = '',$orderBy = 'id'){
        global $con;
        if($limit == '')
            $stmt = $con->prepare("SELECT * FROM $tbl WHERE $col_name = ? ORDER BY $orderBy DESC");
        else
            $stmt = $con->prepare("SELECT * FROM $tbl WHERE $col_name = ? ORDER BY $orderBy DESC LIMIT $limit");
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
        $stmt = $con->prepare("SELECT $column FROM $tbl WHERE $col_name = ? ORDER BY id DESC");
        $stmt->execute(array($id));
        $row = $stmt->fetch();
        if($stmt->rowCount() > 0){
            return $row[$column];
        }
    }
}
/*if(! function_exists('get_parent_name')){
    function get_parent_name($id){
        global $con;
        $stmt = $con->prepare("SELECT name FROM categories WHERE parent_id = ?");
        $stmt->execute(array($id));
        $row = $stmt->fetch();
        if($stmt->rowCount() > 0){
            return $row['name'];
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
    function resize_image($path,$tmp_name,$tmp_type,$nwidth=null,$nheight=null) {
        $file=$tmp_name;
        list($width,$height)=getimagesize($file);
        if(!$nwidth)
            $nwidth= (int) ($width/4);
        
        if(!$nheight)
            $nheight = (int) ($height/4);
    
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
            elseif($tblname == 'users'){
                $img = get_item('avatar','users','id',$id);
                if($img != 'no-image.png'){
                    unlink('../assets/uploads/users/'.$img);
                }
            }
            elseif($tblname == 'products'){
                //delete product tags
                delete_product_tags($id);
                //delete product images
                delete_product_images($id);
            }
            elseif($tblname == 'roles'){
                //delete roles permissions
                delete_role_permissions($id);
            }
            $stmt = $con->prepare("DELETE FROM $tblname WHERE id = :zid");
            $stmt->bindParam(":zid", $id);
            $stmt->execute();
            $msg = show_msg('success','Selected Records Deleted Successfully');
        
        }

        echo $msg;
        //redirectPage('');
    }
}
/*
function to get user permission in dashboard
get user id , permissions name
*/
if(! function_exists('get_user_permission')){
    function get_user_permission($role_id,$per_name){
        global $con;
        $permission_names = array();
        $stmt = $con->prepare("SELECT * FROM roles_permissions WHERE role_id = ?");
        $stmt->execute(array($role_id));
        $rows =$stmt->fetchAll();
        foreach($rows as $row){
            $permission_name = get_item('per_name','permissions','id',$row['permssion_id']);
            $permission_names[]= $permission_name;
        }
        if(in_array($per_name,$permission_names)){
            return true;
        }
        else{
            return false;
        }
    }
}

/*
function to search in products
*/
if(! function_exists('search_products')){
    function search_products($search_keyword , $cat_id = null){
        global $con;
        
        $stmt = $con->prepare("SELECT * FROM products WHERE title LIKE '%$search_keyword%' AND category_id LIKE '%$cat_id%' AND status = 1");
        $stmt->execute();
        $rows = $stmt->fetchAll();
        return $rows;
    }
}
/*
function to get page num in pagination
*/
if(! function_exists('records_total')){
    function records_total($tblname,$colName,$colVal,$limit){
        global $con;
        // Calculate Total pages
        $stmt = $con->query("SELECT count(*) FROM $tblname WHERE $colName = $colVal");
        $total_results = $stmt->fetchColumn();
        $total_pages = ceil($total_results / $limit);
        return $total_pages;
    }
}
/*
function to paginate records
take tablename & limit
*/
if(! function_exists('paginate_records')){
    function paginate_records($tblname,$colname,$colVal,$limit){
        global $con;
        $perPage = $limit;
        // Current page
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $starting_limit = ($page - 1) * $perPage;
        // Query to fetch data
        $query = "SELECT * FROM $tblname  WHERE $colname = $colVal ORDER BY id DESC LIMIT $starting_limit,$perPage";
        // Fetch all data for current page
        $data = $con->query($query)->fetchAll();
        return $data;
    }
}
/*
function to get category parents
get parent_id
*/
if(! function_exists('get_cat_parent')){
    function get_cat_parent($id){
        $row = get_row_data('categories',$id);
        $name = '';
        if(isset($row['parent_id']) && $row['parent_id'] != 0){
            $name.= get_cat_parent($row['parent_id']);
            $name .= '<li>
                        <a href="category.php?category_id='.$row['id'].'"><i class="ti-arrow-right"></i>'.$row['name'].'</a>
                    </li>';
            
        }
        else{
            if(isset($row['name']))
                $name = '<li><a href="category.php?category_id='.$row['id'].'"><i class="ti-arrow-right"></i>'.$row['name'].'</a></li>';
        }
  
        return $name;
    }
}
/*
check fav
*/
if(! function_exists('check_product')){
    function check_product($user_id , $product_id,$tbl){
        global $con;
        $stmt = $con->prepare("SELECT * FROM $tbl WHERE user_id = ? AND product_id = ?");
        $stmt->execute(array($user_id , $product_id));
        $row = $stmt->fetch();
        return $stmt->rowCount();
    }
}
/*
check if product in user favourite list
*/
if(! function_exists('check_fav')){
    function check_fav($product_id , $user_id,$price,$quantity)
    {
        if(check_product($user_id,$product_id,'favs') == 0)
        {
            echo '<button class="btn btn-info button_fav" data-product-id="'.$product_id.'" data-user-id="'.$user_id.'" data-method="Like">
                        <i class="ti-heart"></i> Add To Favourit
                    </button>';
                    
        }
        else{
            echo '<button class="btn btn-info button_fav" data-product-id="'.$product_id.'" data-user-id="'.$user_id.'" data-method="Unlike">
                        <i class="ti-heart"></i> Remove From Favourit
                    </button>
                    ';
        }
    }
}
/*
check if the product is in user cart
*/
if(! function_exists('check_cart'))
{
    function check_cart($product_id , $user_id,$price,$quantity)
    {
        $get_discount = get_row_data('products',$product_id,'id');
        if($get_discount['discount'] != 0)
            $price_after_discount = price_after_discount($price, $get_discount['discount']);
        else
        $price_after_discount = $price;

        if(check_product($user_id,$product_id,'orders') == 0 && $quantity != 0)
        {
            echo '<button class="btn btn-info button_cart" id="btn-'.$product_id.'"  data-product-id="'.$product_id.'" data-user-id="'.$user_id.'" data-price="'.$price_after_discount.'" data-quantity="'.$quantity.'" data-method="addCart">
                            <i class="ti-bag"></i> Add To Cart
                        </button>';
        }
        else{
            echo '<button class="btn btn-info button_cart" id="btn-'.$product_id.'" data-product-id="'.$product_id.'" data-user-id="'.$user_id.'" data-price="'.$price_after_discount.'" data-quantity="'.$quantity.'" data-method="delCart">
                        <i class="ti-bag"></i> Remove Cart
                    </button>';
        }
    }
}
/*
add new product to user favs list
*/
if(! function_exists('add_to_fav'))
{
    function add_to_fav($method,$user_id,$director_id)
    {
        global $con;
            switch ($method) {
                case "Like" :
                    $query = 'INSERT INTO favs (user_id, product_id) VALUES (:mID, :pID)';
                    break;
                case "Unlike" :
                    $query = 'DELETE FROM favs WHERE user_id=:mID and product_id=:pID';
                    break;
                
            }
            $feedback = 'Fail'; // start with pessimistic feedback
            if (isset($query)) {
                $stmt = $con->prepare($query);
                $stmt->bindParam(':mID', $user_id, PDO::PARAM_INT, 12);
                $stmt->bindParam(':pID', $director_id, PDO::PARAM_INT, 12);
                if ($stmt->execute()) {
                    $feedback = $method;
                } // feedback becomes method on success
            }
            
            echo json_encode(['id' => $director_id,
                'feedback' => $feedback]);
    }
}
/*
add to cart function
*/
if(! function_exists('add_to_cart'))
{
    function add_to_cart($method,$user_id,$director_id,$price,$cart_total)
    {
        global $con;
            $total = $cart_total;
            $prev_quantity = get_row_data('products',$director_id);
            
            switch ($method) {
                case "addCart" :
                    $query = 'INSERT INTO orders (user_id, product_id,price) VALUES (:mID, :pID, :pb)';
                    $new_quantity = $prev_quantity['quantity'] - 1;
                break;
                case "delCart" :
                    $query = 'DELETE FROM orders WHERE user_id=:mID and product_id=:pID';
                    $new_quantity = $prev_quantity['quantity'] + 1;
                break;
                
            }
            $product = '';
            $feedback = 'Fail'; // start with pessimistic feedback
            //get the product details to add to cart list in header
            if($method == 'addCart')
            {
                //get product details
                $img_name = get_item('file_name','files','product_id',$director_id);
                $img_dir = get_item('file_dir','files','product_id',$director_id);
                $product_title = get_item('title','products','id',$director_id);
                //add product to cart in header
                $product = '<li id="'.$director_id.'">
                            <a href="#" class="remove_cart" title="Remove this item" data-product-id="'.$director_id.'" data-user-id="'.$user_id.'" data-price="'.$price.'" data-method="delCart">
                                <i class="fa fa-remove"></i>
                            </a>
                            <a class="cart-img" href="product?product_id='.$director_id.'">
                                <img src="'.$img_dir.'/'.$img_name.'" alt="#">
                            </a>
                            <h4>
                                <a href="product?product_id='.$director_id.'">
                                '.$product_title.'</a>
                            </h4>
                            <p class="quantity">1x - <span class="amount">$'.$price.'</span></p></li>';
            }
            if (isset($query)) {
                $stmt = $con->prepare($query);
                $stmt->bindParam(':mID', $user_id, PDO::PARAM_INT, 12);
                $stmt->bindParam(':pID', $director_id, PDO::PARAM_INT, 12);
                if($method == 'addCart')
                    $stmt->bindParam(':pb', $price);
                    
                if ($stmt->execute()) {
                    $feedback = $method;
                    $total = get_orders_total($user_id);
                    up_quantity($director_id,$new_quantity);
                    $quantity = get_row_data('products',$director_id);
                } // feedback becomes method on success
            }
            $items_count = get_data_column_count('orders','user_id',$user_id);
            echo json_encode([
                'id'            => $director_id,
                'feedback'      => $feedback,
                'items_count'   => $items_count,
                'product_data'  => $product,
                'total'         => $total,
                'quantity'      => $quantity['quantity']
            ]);
    }
}
/*
function to clean all input data
*/
if(! function_exists('clean_input'))
{
    function clean_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}
/*
function to get total for user orders
*/
if(! function_exists('get_orders_total'))
{
    function get_orders_total($user_id)
    {
        $orders = get_all_rows_data('orders','user_id',$user_id);
        $total = 0;
        foreach($orders as $order)
        {
            $total += $order['price'];
        }
        return $total;
    }
}
/*
function to get price after discount
*/
if(! function_exists('price_after_discount'))
{
    function price_after_discount($price,$discount)
    {
        if($discount !=0)
        {
            $new_price = ($price * $discount) / 100;
            $new_price = $price - $new_price;
            return $new_price;
        }
    }
}
/*
function to update product quantity
*/
if(! function_exists('up_quantity')){
    function up_quantity($product_id,$quantity)
    {
        global $con;
        $stmt = $con->prepare("UPDATE products SET quantity = ? WHERE id = ?");
        $upData =$stmt->execute(array($quantity,$product_id));
        //get updated quantity
        $new_quantity = get_row_data('products',$product_id);
        return $new_quantity['quantity'];          
    }
}
/*
function to send message between users
*/
if(! function_exists('send_product_msg'))
{
    function send_product_msg($author,$product_id,$sender_msg,$user_id,$msg,$subject,$replay_id)
    {
        global $con;
        $sender_name = get_row_data('users',$user_id);
        $stmt = $con->prepare('INSERT INTO messages (user_id, product_id,title,sender_name,message,sender_id,replay_id) VALUES 
                                      (:muserID, :mPro_id, :mtitle,:msenderName,:mMsg,:msenderID,:mReplay_id)');
            $stmt->execute(array(
                'muserID' 	    => $author,
                'mPro_id' 	    => $product_id,
                'mtitle' 	    => $subject,
                'msenderName' 	=> $sender_name['username'],
                'mMsg'          => $sender_msg,
                'msenderID'     => $user_id,
                'mReplay_id'    => $replay_id
            ));
            if($stmt)
                $msg =  'Message Send Successfully';
            else
                $msg =  'Error in sending Message Please Try Again';
            echo json_encode([
                    'callback_msg'   => $msg   
            ]);
    }
}
/**
 * function to update views
 * 
 */
if(! function_exists('up_views'))
{
    function up_views($product_id)
    {
        global $con;
        $pro = get_row_data('products',$product_id);
        $views = $pro['views'] + 1;
        $stmt = $con->prepare("UPDATE products SET views = ? WHERE id = ?");
        $upData =$stmt->execute(array($views,$product_id));
    }
}
/*
function to add new comment
*/
if(! function_exists('add_new_comment'))
{
    function add_new_comment($user_id,$product_id,$comment)
    {
        global $con;
        $stmt = $con->prepare('INSERT INTO comments (user_id, product_id,comment) VALUES 
                                      (:muserID, :mPro_id, :mcomment)');
            $stmt->execute(array(
                'muserID' 	    => $user_id,
                'mPro_id' 	    => $product_id,
                'mcomment' 	    => $comment
                
            ));
            if($stmt){
                $msg =  'Your Comment Added Successfully';
                $comments_count = get_data_column_count('comments','product_id',$product_id);

            }else{
                $msg =  'Error in adding new comment Please Try Again';
            
            }
            echo json_encode([
                    'callback_msg'   => $msg ,
                    'comments_count'    => $comments_count
            ]);

    }
}