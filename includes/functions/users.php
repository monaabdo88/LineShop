<?php
/*
function to add new user
*/
if(! function_exists('add_user')){
    function add_user(){
        global $con;
        $errors = array();
        //check if method is post
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //prepare values from add form
            $user_name         = $_POST['username'];
            $email             = $_POST['email'];
            $password          = sha1($_POST['password']);
            $country_id        = $_POST['country_id'];
            $city_id           = $_POST['city_id'];
            $state_id          = $_POST['state_id'];
            $phone             = $_POST['phone'];
            //validation
            if($user_name == ''){
                $errors['error']= 'Username is Required';
            }
            elseif($_POST['password'] != $_POST['confirm_password']){
                $errors['error'] = 'Password Confirmation is wrong Please Try Again Later';
            }
            elseif($email == ''){
                $errors['error'] = 'User Email is Required';
            }
            elseif($phone == ''){
                $errors['error'] = 'User Phone is Required';
            }
            elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['error'] = 'Not Valid Email';    
            }
            //check if user is already exists
            elseif(checkItem('username','users',$user_name) == 1){
                $errors['error'] = 'This UserName is already exists';
            }
            elseif(checkItem('email','users',$email) == 1){
                $errors['error'] = 'This User Email is already exists';
            }
            elseif(checkItem('phone','users',$phone) == 1){
                $errors['error'] = 'This User Phone is already exists';
            }
            elseif(!$errors){
                 //check Upload Image
                 if(isset($_FILES['avatar']) && $_FILES['avatar']['size'] != 0){
                    // Upload Variables
                    $imageTmp	    = $_FILES['avatar']['tmp_name'];
                    $imageType      = $_FILES['avatar']['type'];
                    //upload category Image
                    $image = resize_image('assets/uploads/users/',$imageTmp,$imageType);
                }else{
                    $image = 'no-image.png';
                }
                //add new user to database
                $stmt = $con->prepare("INSERT INTO 
                    users(username, email, password,avatar,phone,country_id,state_id,city_id)
                    VALUES(:zusername, :zemail, :zpassword, 
                    :zavatar,:zphone,
                    :zcountry_id,:zstate_id,:zcity_id
                    )");
                $stmt->execute(array(
                    'zusername' 	=> $user_name,
                    'zemail' 	    => $email,
                    'zpassword' 	=> $password,
                    'zavatar'       => $image,
                    'zcountry_id'   => $country_id,
                    'zcity_id'      => $city_id,
                    'zstate_id'     => $state_id,
                    'zphone'        => $phone
                ));
                // Echo Success Message
                $errors['success'] = "Registration Done Successfully";
                $last_id = $con->lastInsertId();
                $_SESSION['user_id'] = $last_id;                
            }

            return $errors;
        }
    }
}
/*
function to login
*/
if(! function_exists('login_user')){
    function login_user(){
        global $con;
        $errors = array();

        $email    = $_POST['email'];
        $password = $_POST['password'];
        //Hash The Password to protect admin info
        $hashedPass = sha1($password);
        //check if email is valid email
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['error'] = 'Not a valid email';
        }else{
            // Check If The User Exist In Database
            $stmt = $con->prepare
                    ("SELECT 
                    *
                    FROM 
                    users 
                    WHERE 
                    email = ? 
                    AND 
                    password = ? 
                    ");
            $stmt->execute(array($email,$hashedPass));
            $row = $stmt->fetch();
		    $count = $stmt->rowCount();
            if($count > 0 ){
                $errors['success']  = 'Welcome Back '.$row['username'];
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
            }else{
                $errors['error'] = 'Wrong Email Or Password Please Try Again';
            }
        }
        return $errors;
    }
}
/*
function to edit user data
take user id
*/
if(! function_exists('edit_user')){
    function edit_user($id){
        global $con;
        $errors = array();
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //Prepare Values from edit form
            $user_name         = $_POST['username'];
            $email             = $_POST['email'];
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
                $errors['error'] = 'This user Name is Already exists';
            }
            else
            {
                $oldAvatar = get_item('avatar','users','id',$id);
                    
                //upload New Image if there file request
                if(isset($_FILES['avatar']) && $_FILES['avatar']['size'] != 0){
                    $dirImg =  "assets/uploads/users/";
                    //delete the prev category image
                    if($oldAvatar != 'no-image.png'){
                        unlink($dirImg.$oldAvatar);
                    }
                        // Upload Variables
                        $imageTmp	    = $_FILES['avatar']['tmp_name'];
                        $imageType      = $_FILES['avatar']['type'];
                        //upload category Image
                        $image = resize_image('assets/uploads/users/',$imageTmp,$imageType);
                
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
                                        avatar  = ?,
                                        country_id = ?,
                                        city_id = ?,
                                        state_id = ?,
                                        phone=?
                                        WHERE
                                        id = ?
                                        ");
                $upData =$stmt->execute(array($user_name,$email,$password,$image,$country_id,$city_id,$state_id,$phone,$id));
                //Update Message
                if($upData){
                    $errors['success'] = 'Your Information had Updated Successfully';
                    
                }
        
            }
            return $errors;
        }
    }
}
/*
function to restore user password
*/
if(! function_exists('restore_pass')){
    function restore_pass(){
        global $con;
        $errors = array();
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $email = $_POST['email'];
            //validation
            if(empty($email)){
                $errors['error'] = 'Please Write Your email';
            }
            //check if email exist
            if(checkItem('email','users',$email) == 0){
                $errors['error'] = 'This user Email is Not exists in database';
            }else{

            }
        }
        return $errors;
    }
}