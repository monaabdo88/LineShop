<?php
/*
function to upload product images
take product_id
*/
if(! function_exists('upload_product_images')){
    function upload_product_images($product_id){
        global $con;
        $msg = '';
        if(isset($product_id) && is_numeric($product_id)){
            if (! empty($_FILES) && isset($_FILES['file'])) {
                $imagePath = isset($_FILES["file"]["name"]) ? $_FILES["file"]["name"] : "Undefined";
                $targetPath = "../assets/uploads/products/";
                $imagePath = $targetPath . $imagePath;
                $tempFile = $_FILES['file']['tmp_name'];
                
                $targetFile =time().rand(0,999). $_FILES['file']['name'];
                $file_size = filesize($tempFile);
                
                if(move_uploaded_file($tempFile, $targetPath.$targetFile)){
                    $stmtImg = $con->prepare("INSERT INTO files (product_id,file_name,file_size,file_dir) VALUES (:zproduct_id,:zfile_name,:zfile_size,:zfile_dir)");
                        $stmtImg->execute(array(
                            'zproduct_id'       => $product_id,
                            'zfile_name'        => $targetFile,
                            'zfile_size'        => $file_size,
                            'zfile_dir'         => $targetPath
                        ));
                        $msg = show_msg('success',"Images Inserted Successsfully");
                    
                }       
            }
        }
        echo $msg;
        redirectPage('products.php');
        
    }
}
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
                //add new product to database
                $stmt = $con->prepare("INSERT INTO 
                    products(title, details, category_id, user_id,status,price,quantity,discount)
                    VALUES(:ztitle, :zdesc, :zparent, :zuser, :zstatus,:zprice,:zquantity,:zdiscount)");
                $stmt->execute(array(
                    'ztitle' 	=> $title,
                    'zdesc' 	=> $details,
                    'zparent' 	=> $category_id,
                    'zuser' 	=> $userId,
                    'zstatus'   => $status,
                    'zprice'    => $price,
                    'zdiscount' => $discount,
                    'zquantity' => $quantity
                ));
                //get row id
                $last_id = $con->lastInsertId();
                
                //check if tag added
                if(isset($_POST['tag']))
                    //add product tags code
                    product_tags($_POST['tag'],$last_id);
                // Echo Success Message
                $msg = show_msg('success',"Record Inserted Successsfully");
                
            }
            echo $msg;
            redirectPage('products.php?do=addMedia&product_id='.$last_id);
            
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
            $title              = $_POST['title'];
            $userId             = $_POST['user_id'];
            $status             = $_POST['status'];
            $category_id        = $_POST['category_id'];
            $details            = $_POST['details'];
            $price              = $_POST['price'];
            $quantity           = $_POST['quantity'];
            $discount           = $_POST['discount'];
            $id                 = $_POST['product_id'];
            //check if the new product title is exists in another product
            if(checkItemUp('title','products',$title,$id) > 0){
                $msg = show_msg('Error','This product title is Already exists');
            }
            else
            {
                //start update code
                $stmt = $con->prepare("UPDATE 
                                        products 
                                        SET 
                                        title = ?,
                                        details = ?,
                                        status = ?,
                                        user_id = ?,
                                        category_id = ?,
                                        discount = ?,
                                        quantity = ? ,
                                        price = ?
                                        WHERE
                                        id = ?
                                        ");
                $upData =$stmt->execute(array($title,$details,$status,$userId,$category_id,$discount,$quantity,$price,$id));
                //Update Message
                if($upData){
                    //check if tag added
                    if(isset($_POST['tag'])){
                        //delete previous product tags
                        delete_product_tags($id);
                        //add product tags code
                        product_tags($_POST['tag'],$id);
                    }
                    $msg = show_msg('success','product Updated Successfully');
                    
                }
        
            }
            echo $msg;
            redirectPage('products.php');
        }
    }
}
/*
function to delete product
*/
if(! function_exists('delete_product')){
    function delete_product(){
            global $con;
            $msg = '';
            //check if product ID from get request
            $product_id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
            // Select All Data Depend On This ID
            $check = checkItem('id', 'products', $product_id);
            // If There's Such ID Show The Form
            if ($check > 0) {
                //delete product tags
                delete_product_tags($product_id);
                //delete product images
                delete_product_images($product_id);
                //prepare to delete product
                $stmt = $con->prepare("DELETE FROM products WHERE id = :zid");
                $stmt->bindParam(":zid", $product_id);
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
function to get product images get product_id
return array of images
*/
if(! function_exists('get_product_images')){
    function get_product_images($product_id){
        $result  = array();
        $rows = get_related_data('files','product_id',$product_id);
        foreach($rows as $row){
            $obj['name'] = $row['file_name'];
            $obj['size'] = $row['file_size'];
            $result[] = $obj;
        }

        header('Content-type: text/json');  
        header('Content-type: application/json');
        echo json_encode($result);
    
    }
}
/*
function to delete Product Image
Take Image ID
*/
if(! function_exists('delImg')){
    function delImg(){
        global $con;
        $img_name = $_GET['image_name'];
        $product_id = $_GET['product_id'];
        $img_dir = get_item('file_dir','files','file_name',$img_name);
        if(isset($img_name) && isset($product_id)){
            unlink($img_dir.$img_name);
            $stmt = $con->prepare("DELETE FROM files WHERE file_name = :zimage AND product_id = :zproduct_id");
            $stmt->execute(array(
                'zimage'            => $img_name,
                'zproduct_id'       => $product_id
            ));
        }
    }
}
/*
function to check product tag in edit form
take product_id , $tag_id
*/
if(!function_exists('check_product_tag')){
    function check_product_tag($product_id,$tag_id){
        global $con;
        $stmt = $con->prepare("SELECT * FROM product_tags WHERE product_id = ? AND tag_id = ?");
        $stmt->execute(array($product_id,$tag_id));
        $count = $stmt->rowCount();
        return $count;
    }
}
/*
function to delete product tags
take product_id
*/
if(! function_exists('delete_product_tags')){
    function delete_product_tags($product_id){
        global $con;
        $stmt = $con->prepare("DELETE FROM product_tags WHERE product_id = :zproduct_id");
        $stmt->bindParam(":zproduct_id", $product_id);
        $stmt->execute();
    }
}
/*
function to delete product Images
take product_id
*/
if(! function_exists('delete_product_images')){
    function delete_product_images($product_id){
        global $con;
        //unlink images from folder
        $images = get_row_data('files','product_id',$product_id);
        foreach($images as $img){
            unlink($img['file_dir'].$img['file_name']);
        }
        //delete product images from database
        $stmt = $con->prepare("DELETE FROM files WHERE product_id = :zproduct_id");
        $stmt->bindParam(":zproduct_id", $product_id);
        $stmt->execute();
    }
}