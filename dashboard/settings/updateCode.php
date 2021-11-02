<?php
$target_file = $row['site_logo'];
// Site logo check and upload start
if($_FILES['site_logo']['size'] != 0){
    unlink($row['site_logo']);
    //upload Site logo
    $target_dir = "../assets/uploads/settings/";
    $target_file = $target_dir . basename($_FILES["site_logo"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["site_logo"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo '
        <script type="text/javascript">
            $(document).ready(function(){
                errorFn("File is Not Image","warning");

            });
            
        </script>
        ';
    redirectPage('back');
        $uploadOk = 0;
    }
    
    // Check file size
    if ($_FILES["site_logo"]["size"] > 500000) {
        echo '
            <script type="text/javascript">
                $(document).ready(function(){
                    errorFn("Sorry, your file is too large.","warning");

                });
                
            </script>
            ';
        redirectPage('back');
        $uploadOk = 0;
    }
    
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo '
            <script type="text/javascript">
                $(document).ready(function(){
                    errorFn("Sorry, only JPG, JPEG, PNG & GIF files are allowed.","warning");

                });
                
            </script>
            ';
        redirectPage('back');
       
        $uploadOk = 0;
    }
    
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo '
            <script type="text/javascript">
                $(document).ready(function(){
                    errorFn("Sorry, your file was not uploaded.","warning");

                });
                
            </script>
            ';
            redirectPage('back');
        // if everything is ok, try to upload file
    } else {
        move_uploaded_file($_FILES["site_logo"]["tmp_name"], $target_file);
    }
}// end site logo upload

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
    
    echo '
    <script type="text/javascript">
        $(document).ready(function(){
            successFn("Settings Updated Successfully","success");

        });
        
    </script>
    ';
    redirectPage('back');
}