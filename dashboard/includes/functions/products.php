<?php
/*
function to add new product
*/
if(! function_exists('add_product')){
    function add_product(){
        global $con;
        $msg = '';
        //check if method is post
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //prepare values from add form
            $title              = $_POST['title'];
            $userId             = $_POST['user_id'];
            $status             = $_POST['status'];
            $category_id        = $_POST['category_id'];
            $details            = $_POST['details'];
            $price              = $_POST['price'];
            $quantity           = $_POST['quantity'];
            $discount           = $_POST['discount'];
            //check if product is already exists
            if(checkItem('title','products',$title) == 1){
                $msg = show_msg('Error','This product is already exists');
            }else{
                //check Upload Image
                if(isset($_FILES['main_img']) && $_FILES['main_img']['size'] != 0){
                    // Upload Variables
                    $imageTmp	    = $_FILES['main_img']['tmp_name'];
                    $imageType      = $_FILES['main_img']['type'];
                    //upload product Image
                    $image = resize_image('../assets/uploads/products/',$imageTmp,$imageType);
                }else{
                    $image = '';
                }
                //add new product to database
                $stmt = $con->prepare("INSERT INTO 
                    products(title, details, category_id, user_id, main_img,status,price,quantity,discount)
                    VALUES(:ztitle, :zdesc, :zparent, :zuser, :zimage, :zstatus,:zprice,:zquantity,:zdiscount)");
                $stmt->execute(array(
                    'ztitle' 	=> $title,
                    'zdesc' 	=> $details,
                    'zparent' 	=> $category_id,
                    'zuser' 	=> $userId,
                    'zimage' 	=> $image,
                    'zstatus'   => $status,
                    'zprice'    => $price,
                    'zdiscount' => $discount,
                    'zquantity' => $quantity
                ));
                //get row id
                $last_id = $con->lastInsertId();
                product_tags($_POST['tag'],$last_id);
                //upload_product_images($last_id);
                // Echo Success Message
                $msg = show_msg('success', $stmt->rowCount() . ' Record Inserted');
                
            }
            echo $msg;
            //redirectPage('products.php');
            
        }
    }
}
/*
function to update product
*/
if(! function_exists('update_product')){
    function update_product(){
        global $con;
        $msg = '';
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //Prepare Values from edit form
            $id         = $_POST['catID'];
            $user_id    = $_POST['user_id'];
            $title       = $_POST['title'];
            $desc       = $_POST['details'];
            $parent     = $_POST['category_id'];
            $status     = $_POST['status'];
            //check if the new product title is exists in another product
            if(checkItemUp('title','products',$title,$id) > 0){
                $msg = show_msg('Error','This product title is Already exists');
            }
            else
            {
                //upload New Image if there file request
                if(isset($_FILES['main_img']) && $_FILES['main_img']['size'] != 0){
                    $dirImg =  "../assets/uploads/products/";
                    //delete the prev product image
                    if(isset($_POST['oldImg']) && $_POST['oldImg'] != '')
                        unlink($dirImg.$_POST['oldImg']);
                        // Upload Variables
                        $imageTmp	    = $_FILES['main_img']['tmp_title'];
                        $imageType      = $_FILES['main_img']['type'];
                        //upload product Image
                        $image = resize_image('../assets/uploads/products/',$imageTmp,$imageType);
                
                    }else{
                    $image = $_POST['oldImg'];
                }// end upload code
                //start update code
                $stmt = $con->prepare("UPDATE 
                                        products 
                                        SET 
                                        title = ?,
                                        details = ?,
                                        status = ?,
                                        image = ?,
                                        user_id = ?,
                                        category_id = ?
                                        WHERE
                                        id = ?
                                        ");
                $upData =$stmt->execute(array($title,$desc,$status,$image,$user_id,$parent,$id));
                //Update Message
                if($upData){
                    $msg = show_msg('success','product Updated Successfully');
                    
                }
        
            }
            echo $msg;
            redirectPage('back');
        }
    }
}
/*
function to delete product
*/
if(! function_exists('delete_product')){
    function delete_product(){
            global $con;
            $smg = '';
            //check if product ID from get request
            $catId = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
            // Select All Data Depend On This ID
            $check = checkItem('id', 'products', $catId);
            // If There's Such ID Show The Form
            if ($check > 0) {
              //delete product image
              $catImg = get_item('main_img','products',$catId);
              if(isset($catImg) && $catImg != '')
                unlink("../assets/uploads/products/".$catImg);
              //prepare to delete product
                $stmt = $con->prepare("DELETE FROM products WHERE id = :zid");
                $stmt->bindParam(":zid", $catId);
                $stmt->execute();
                $msg = show_msg('success','product Deleted Successfully');
            } else {
                $msg = show_msg('Error','This product is Not Found');
            }
            echo $msg;
            redirectPage('products.php');
    }
}
/*
function to insert product tags
get tags & product ID
*/
if(!function_exists('product_tags')){
    function product_tags($tags, $product_id){
        global $con;
        foreach($tags as $tag){
            $stmt = $con->prepare("INSERT INTO product_Tags (product_id,tag_id) VALUES (:zproduct_id,:ztag_id)");
            $stmt->execute(array(
                'zproduct_id'   => $product_id,
                'ztag_id'       => $tag
            ));

        }
    }
}
/*
function to upload product images
take product ID
*/
if(! function_exists('upload_product_images')){
    function upload_product_images(){
        if(isset($_FILES['file']['name'])){
            $name = $_FILES['file']['name'];
            $tmp_file = $_FILES['file']['tmp_name'];
            $filesCount = count($_FILES['file']['name']);
            for($i = 0; $i < $filesCount; $i++) { 
            move_uploaded_file($tmp_file[$i], '../assets/uploads/products/'.$name[$i]);
            $upload_image[] = $name[$i];
            }
            return $upload_image;
        }
    
    }
}