<?php
/*
function to add new user
*/
if(! function_exists('add_user')){
    function add_user(){
        global $con;
        $msg = '';
        //check if method is post
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //prepare values from add form
            $user_name         = $_POST['user_name'];
            $email             = $_POST['email'];
            $status            = $_POST['status'];
            $password          = sha1($_POST['password']);
            $trust_user        = $_POST['trust_user'];
            $role_id           = $_POST['role_id'];
            $country_id        = @$_POST['country_id'];
            $city_id           = @$_POST['city_id'];
            $state_id          = @$_POST['state_id'];
            $phone             = @$_POST['phone'];
            //check if user is already exists
            if(checkItem('username','users',$user_name) == 1){
                $msg = show_msg('Error','This UserName is already exists');
            }
            elseif(checkItem('email','users',$email) == 1){
                $msg = show_msg('Error','This User Email is already exists');
            }
            else{
                 //check Upload Image
                 if(isset($_FILES['avatar']) && $_FILES['avatar']['size'] != 0){
                    // Upload Variables
                    $imageTmp	    = $_FILES['avatar']['tmp_name'];
                    $imageType      = $_FILES['avatar']['type'];
                    //upload category Image
                    $image = resize_image('../assets/uploads/users/',$imageTmp,$imageType);
                }else{
                    $image = 'no-image.png';
                }
                //add new user to database
                $stmt = $con->prepare("INSERT INTO 
                    users(username, email, password, role_id,status,trust_user,avatar)
                    VALUES(:zusername, :zemail, :zpassword, 
                    :zrole_id, :zstatus,:ztrust_user,:zavatar,
                    :zcountry_id,:zcity_id,:zstate_id,:zphone
                    )");
                $stmt->execute(array(
                    'zusername' 	=> $user_name,
                    'zemail' 	    => $email,
                    'zpassword' 	=> $password,
                    'zrole_id' 	    => $role_id,
                    'zstatus'       => $status,
                    'ztrust_user'   => $trust_user,
                    'zavatar'       => $image,
                    'zcountry_id'   => $country_id,
                    'zcity_id'      => $city_id,
                    'zstate_id'     => $state_id,
                    'zphone'        => $phone
                ));
                // Echo Success Message
                $msg = show_msg('success',"Record Inserted Successsfully");
                
            }
            echo $msg;
            redirectPage('users.php');
            
        }
    }
}
/*
function to update user
*/
if(! function_exists('update_user')){
    function update_user(){
        global $con;
        $msg = '';
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //Prepare Values from edit form
            $id                = $_POST['user_id'];
            $user_name         = $_POST['user_name'];
            $email             = $_POST['email'];
            $status            = $_POST['status'];
            $trust_user        = $_POST['trust_user'];
            $role_id           = $_POST['role_id'];
            $country_id        = @$_POST['country_id'];
            $city_id           = @$_POST['city_id'];
            $state_id          = @$_POST['state_id'];
            $phone             = @$_POST['phone'];
            if(isset($_POST['password']) && $_POST['password'] != '')
                $password  = sha1($_POST['password']);
            else
                $password = get_item('password','users','id',$id);
                
            //check if the new user title is exists in another user
            if(checkItemUp('username','users',$user_name,$id) > 0){
                $msg = show_msg('Error','This user Name is Already exists');
            }
            else
            {
                $oldAvatar = get_item('avatar','users','id',$id);
                    
                //upload New Image if there file request
                if(isset($_FILES['avatar']) && $_FILES['avatar']['size'] != 0){
                    $dirImg =  "../assets/uploads/users/";
                    //delete the prev category image
                    if($oldAvatar != 'no-image.png'){
                        unlink($dirImg.$oldAvatar);
                    }
                        // Upload Variables
                        $imageTmp	    = $_FILES['avatar']['tmp_name'];
                        $imageType      = $_FILES['avatar']['type'];
                        //upload category Image
                        $image = resize_image('../assets/uploads/users/',$imageTmp,$imageType);
                
                    }else{
                        $image = $oldAvatar;
                    }// end upload code
                //start update code
                $stmt = $con->prepare("UPDATE 
                                        users 
                                        SET 
                                        username = ?,
                                        email = ?,
                                        password = ?,
                                        trust_user = ?,
                                        status = ?,
                                        role_id = ?,
                                        avatar  = ?,
                                        country_id = ?,
                                        city_id = ?,
                                        state_id = ?,
                                        phone=?
                                        WHERE
                                        id = ?
                                        ");
                $upData =$stmt->execute(array($user_name,$email,$password,$trust_user,$status,$role_id,$image,$country_id,$city_id,$state_id,$phone,$id));
                //Update Message
                if($upData){
                    $msg = show_msg('success','user Updated Successfully');
                    
                }
        
            }
            echo $msg;
            redirectPage('users.php');
        }
    }
}
/*
function to delete user
*/
if(! function_exists('delete_user')){
    function delete_user(){
            global $con;
            $msg = '';
            //check if user ID from get request
            $user_id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
            // Select All Data Depend On This ID
            $check = checkItem('id', 'users', $user_id);
            // If There's Such ID Show The Form
            if ($check > 0) {
                //delete user image
                $userImg = get_item('avatar','users','id',$user_id);
                if(isset($userImg) && $userImg != 'no-image.png')
                  unlink("../assets/uploads/users/".$userImg);

                $stmt = $con->prepare("DELETE FROM users WHERE id = :zid");
                $stmt->bindParam(":zid", $user_id);
                $stmt->execute();
                
                $msg = show_msg('success','user Deleted Successfully');
            } else {
                $msg = show_msg('Error','This user is Not Found');
            }
            echo $msg;
            redirectPage('users.php');
    }
}
