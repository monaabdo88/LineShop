<?php
//check if method is post
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //prepare values from add form
    $name           = $_POST['name'];
    $userId         = $_POST['user_id'];
    $status         = $_POST['status'];
    $parent_id      = $_POST['parent_id'];
    $description    = $_POST['description'];
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
    //check if category is already exists
    if(checkItem('name','categories',$name) == 1){
        echo '
        <script type="text/javascript">
            $(document).ready(function(){
                errorFn("This Category is already exists","error");

            });
            
        </script>';
        redirectPage('categories.php');
    }else{
        //upload category Image
        $image = rand(0, 10000000000) . '_' . $imageName;
        move_uploaded_file($imageTmp, "../assets/uploads/categories/" . $image);
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
        echo '
          <script type="text/javascript">
              $(document).ready(function(){
                  successFn("' . $stmt->rowCount() . ' Record Inserted","success");

              });
              
          </script>';
        redirectPage('categories.php');
        
    }

}