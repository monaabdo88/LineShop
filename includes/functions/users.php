<?php
ini_set("display_errors", 1); 
error_reporting(E_ALL);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
//require_once "/home/u482489328/public_html/backend/LineShop/vendor/autoload.php";
require_once "vendor/autoload.php";
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
            (isset($_POST['city_id'])) ? $city_id = $_POST['city_id'] : $city_id = '';
            $state_id          = $_POST['state_id'];
            $phone             = $_POST['phone'];
            $token             = md5($email).rand(10,9999);
            $expFormat         = mktime(
            date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y"));
            $expDate           = date("Y-m-d H:i:s",$expFormat);
            
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
                    //upload user Image
                    $image = resize_image('assets/uploads/users',$imageTmp,$imageType);
                    $errors['success'] = $image;
                    //return $image;
                }else{
                    $image = 'no-image.png';
                }
                //add new user to database
                
                $stmt = $con->prepare("INSERT INTO users(
                            username, email, password,
                            avatar,phone,country_id,
                            state_id,city_id,exp_date,reset_link_token
                            )
                    VALUES(
                    :zusername, :zemail, :zpassword, 
                    :zavatar,:zphone,
                    :zcountry_id,:zstate_id,
                    :zcity_id,:zexp_date,:zreset_link_token
                    )");
                $stmt->execute(array(
                    'zusername' 	        => $user_name,
                    'zemail' 	            => $email,
                    'zpassword' 	        => $password,
                    'zavatar'               => $image,
                    'zcountry_id'           => $country_id,
                    'zcity_id'              => $city_id,
                    'zstate_id'             => $state_id,
                    'zphone'                => $phone,
                    'zexp_date'             => $expDate,
                    'zreset_link_token'     => $token
                ));
                // Echo Success Message
                $errors['success'] = "Registration Done Successfully Please Check Your Email to verification Your Account";
                $last_id = $con->lastInsertId();
                send_verify_link($last_id);
                /*$_SESSION['user_id'] = $last_id;
                $_SESSION['username'] = $user_name;*/
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
                    //delete the prev user image
                    if($oldAvatar != 'no-image.png'){
                        unlink($dirImg.$oldAvatar);
                    }
                        // Upload Variables
                        $imageTmp	    = $_FILES['avatar']['tmp_name'];
                        $imageType      = $_FILES['avatar']['type'];
                        //upload user Image
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
if(! function_exists('restore_password')){
    function restore_password(){
        global $con;
        $errors = array();
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $emailId = $_POST['email'];
            //validation
            if(empty($emailId)){
                $errors['error'] = 'Please Write Your email';
            }
            //check if email exist
            if(checkItem('email','users',$emailId) == 0){
                $errors['error'] = 'This user Email is Not exists in database';
            }else{
            //update user password    
            $token = md5($emailId).rand(10,9999);
            $expFormat = mktime(
            date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y"));
            $expDate = date("Y-m-d H:i:s",$expFormat);
            $stmt = $con->prepare("UPDATE 
                                        users 
                                        SET 
                                        exp_date = ?,
                                        reset_link_token = ?
                                        WHERE
                                        email = ?
                                        ");
            $upData =$stmt->execute(array($expDate,$token,$emailId));
            //$link = "<a href='lineshop.mona-abdo.com/updatePassword.php?key=".$emailId."&token=".$token."'>Click To Reset password</a>";
            //start send email to user    
            $mail = new PHPMailer();
            $user = get_row_data('users',$emailId,'email');
            $username = $user['username'];
          
                //Server settings
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER; 
                //Enable verbose debug output
                $message = file_get_contents(__DIR__.'/resetPasswordTemplate.php'); 
                $message = str_replace('%username%', $username, $message); 
                $message = str_replace('%token%', $token, $message);
                $message = str_replace('%email%', $emailId, $message);
                //$message = str_replace('%link%', $link, $message);
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.hostinger.com';                    //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'lineshope@mona-abdo.com';                     //SMTP username
                $mail->Password   = '@Jskdl2012';                           //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            
                //Recipients
                $mail->setFrom('lineshope@mona-abdo.com', 'LineShop');
                $mail->addAddress($emailId, $username);     //Add a recipient

                //Content
                $mail->Subject = 'Reset Your Password';
                $mail->MsgHTML($message);
                $mail->isHTML(true);
                $mail->CharSet="utf-8";//Set email format to HTML
                //$mail->Body = '<p><b> Hello '.$username.' Click On This Link to Reset Password </b></p>';
                //$mail->Body.='<a class="btn btn-primary" href="'.$link.'">Reset Password</a>'; 
                
                //$mail->AltBody = 'Update Your Password in LineShop';
            
                if($mail->send())
                    $errors['success'] =  'Message has been sent';
                else
                    $errors['error'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            
                                            
            }
             return $errors;
        }
       
        
    }
}
/*
function to check user reset password
*/
if(! function_exists('check_user_reset_password')){
    function check_user_reset_password($email , $token){
        global $con;
        $errors = array();
       
        $curDate = date("Y-m-d H:i:s");
        $stmt = $con->prepare
                    ("SELECT 
                    *
                    FROM 
                    users 
                    WHERE 
                    email = ? 
                    AND 
                    reset_link_token = ? 
                    ");
        $stmt->execute(array($email,$token));
        $row = $stmt->fetch();
		$count = $stmt->rowCount();
        if($count > 0 ){
            if($row['exp_date'] >= $curDate){
                //start update code
                $emailId = $_POST['email'];
                $token = $_POST['reset_link_token'];
                $pass = $_POST['password'];
                $password = sha1($pass);
                $confirmPass = $_POST['cpassword'];
                if($pass === $confirmPass)
                {
                    $updatePassword = $con->prepare("UPDATE 
                                            users 
                                            SET 
                                            password = ?,
                                            reset_link_token = ?,
                                            exp_date = ?
                                            WHERE
                                            email = ?
                                            ");
                    $upData =$updatePassword->execute(array($password,Null,Null,$emailId));
                    //Update Message
                    if($upData){
                        $errors['success'] = 'Your Information had Updated Successfully';
                    }
                    else
                    {
                        $errors['error'] = 'Error in Update Password Please Try Again!';
                    }
                    
                }
                else{
                    $errors['error'] = 'Passwords does not match';
                }
            }
            else{
                $errors['error'] = 'This forget password link has been expired';
            }
        }
        return $errors;
    }
}
/*
function to send verify link to user email
*/
if(! function_exists('send_verify_link')){
    function send_verify_link($id){
        global $con;
        $errors = array();
        $user = get_row_data('users',$id);
        $username = $user['username'];
        $emailId = $user['email'];
        $token = $user['reset_link_token'];
        //$link = "<a href='lineshop.mona-abdo.com/verifyUser.php?key=".$emailId."&token=".$token."'>Click To Verify Your Account</a>";
            //start send email to user    
            $mail = new PHPMailer();
           
          
                //Server settings
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER; 
                //Enable verbose debug output
                $message = file_get_contents(__DIR__.'/verifyTemplate.php'); 
                $message = str_replace('%username%', $username, $message); 
                $message = str_replace('%token%', $token, $message);
                $message = str_replace('%email%', $emailId, $message);
                //$message = str_replace('%link%', $link, $message);
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.hostinger.com';                    //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'lineshope@mona-abdo.com';                     //SMTP username
                $mail->Password   = '@Jskdl2012';                           //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            
                //Recipients
                $mail->setFrom('lineshope@mona-abdo.com', 'LineShop');
                $mail->addAddress($emailId, $username);     //Add a recipient

                //Content
                $mail->Subject = 'Verify Your Account';
                $mail->MsgHTML($message);
                $mail->isHTML(true);
                $mail->CharSet="utf-8";//Set email format to HTML
                //$mail->Body = '<p><b> Hello '.$username.' Click On This Link to Reset Password </b></p>';
                //$mail->Body.='<a class="btn btn-primary" href="'.$link.'">Reset Password</a>'; 
                
                //$mail->AltBody = 'Update Your Password in LineShop';
            
                if($mail->send())
                    $errors['success'] =  'Message has been sent';
                else
                    $errors['error'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            
             return $errors;                               
            }
             
}
/*
function to update user status after verify account
*/
if(! function_exists('verifyUser')){
    function verifyUser($emailId , $token){
        global $con;
        $errors = array();
       
        $curDate = date("Y-m-d H:i:s");
        $stmt = $con->prepare
                    ("SELECT 
                    *
                    FROM 
                    users 
                    WHERE 
                    email = ? 
                    AND 
                    reset_link_token = ? 
                    ");
        $stmt->execute(array($emailId,$token));
        $row = $stmt->fetch();
		$count = $stmt->rowCount();
        if($count > 0 ){
            if($row['exp_date'] >= $curDate){
                //start update code
               
                
                    $updatePassword = $con->prepare("UPDATE 
                                            users 
                                            SET 
                                            reset_link_token = ?,
                                            exp_date = ?,
                                            status = ?
                                            WHERE
                                            email = ?
                                            ");
                    $upData =$updatePassword->execute(array(Null,Null,1,$emailId));
                    //Update Message
                    if($upData){
                        $errors['success'] = 'Your Account had Verified Successfully';
                        $user = get_row_data('users',$emailId,'email');
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['username'] = $user['username'];
                    }
                    
                }
                
            }
            else{
                $errors['error'] = 'This verify link has been expired';
            }
        return $errors;
        
    }
        
}

