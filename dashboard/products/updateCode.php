<?php
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
        echo '
        <script type="text/javascript">
            $(document).ready(function(){
                errorFn("This Category Name is Already exists","warning");

            });
            
        </script>
        ';
        redirectPage('back');
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
            $imageName      = $_FILES['image']['name'];
            $imageSize      = $_FILES['image']['size'];
            $imageTmp	    = $_FILES['image']['tmp_name'];
            $imageType      = $_FILES['image']['type'];
            // List Of Allowed File Typed To Upload
            $imageAllowedExtension = array("jpeg", "jpg", "png", "gif");
            // Get image Extension
            //$imageExtension = strtolower(end(explode('.', $imageName)));
            $tmp = explode('.',$imageName);
            $imageExtension = strtolower(end($tmp));
            //upload category Image
            $image = rand(0, 10000000000) . '_' . $imageName;
            move_uploaded_file($imageTmp,$dirImg. $image);
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
    
            echo '
            <script type="text/javascript">
                $(document).ready(function(){
                    successFn("Category Updated Successfully","success");
        
                });
                
            </script>
            ';
            redirectPage('back');
        }

    }
}