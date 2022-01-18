<?php
if(! function_exists('admin_login')){
    function admin_login(){
      global $con;
      $email    = $_POST['email'];
      $password = $_POST['password'];
      //Hash The Password to protect admin info
      $hashedPass = sha1($password);
      //check if email is valid email
      if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return 'Not a valid email';
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
                AND 
                status =?");
        $stmt->execute(array($email,$hashedPass,1));
        $row = $stmt->fetch();
		    $count = $stmt->rowCount();

        //check if user already exists if row count > 0 
        if($count > 0 ){
          $_SESSION['admin_email']  = $email;
          $_SESSION['admin_id']     = $row['id'];
          $_SESSION['admin_name']   = $row['username'];
          $_SESSION['admin_img']    = $row['avatar'];
          $_SESSION['role_id']      = $row['role_id'];
          header("Location: index.php");
          exit();
        }else{
          return 'Wrong Email Or Password Please Try Again';
        }
      }
      
    }
}