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
                role_id =?");
        $stmt->execute(array($email,$hashedPass,1));
        $row = $stmt->fetch();
		    $count = $stmt->rowCount();

        //check if user already exists if row count > 0 
        if($count > 0 ){
          $_SESSION['admin_email']  = $email;
          $_SESSION['admin_id']     = $row['id'];
          $_SESSION['admin_name']   = $row['first_name'].' '.$row['last_name'];
          $_SESSION['admin_img']    = $row['avatar'];
          header("Location: index.php");
          exit();
        }else{
          return 'Wrong Email Or Password Please Try Again';
        }
      }
      
    }
}