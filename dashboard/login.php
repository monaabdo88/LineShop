<?php 
session_start();
//check if admin is already logged in or not
if(isset($_SESSION['admin_email'])){
  header("Location: index.php");
}
include "../init.php"; 
//Main Function to Admin Login
include "includes/functions/AdminLogin.php";
$msg = '';
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?=$fonts_loign;?>icomoon/style.css">

    <link rel="stylesheet" href="<?=$css_login;?>owl.carousel.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?=$css_login?>bootstrap.min.css">
    
    <!-- Style -->
    <link rel="stylesheet" href="<?=$css_login?>style.css">

    <title>Login</title>
  </head>
  <body>
  
  <!-------------------------------Login Code Start------------------------------------->
  <?php 
  	// Check If User Coming From HTTP Post Request
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
      $msg = admin_login();
    }
  
  ?>
  <!----------------------------------Login Code End---------------------------------->
  <div class="half">
    <div class="bg order-1 order-md-2" style="background-image: url('assets/login_assets/images/bg_1.jpg');"></div>
    <div class="contents order-2 order-md-1">

      <div class="container">
        <div class="row align-items-center justify-content-center">
          <div class="col-md-6">
            <div class="form-block">
              <div class="text-center mb-5">
              <?php 
              //show error message
              if(isset($msg) && $msg != ''){
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <strong class="text-center">'.$msg.'</strong>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                      </div>';
              }
              ?>
              <h3>Login to <strong>Dashboard</strong></h3>
              <!-- <p class="mb-4">Lorem ipsum dolor sit amet elit. Sapiente sit aut eos consectetur adipisicing.</p> -->
              </div>
              <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
                <div class="form-group first">
                  <label for="Email">Email</label>
                  <input type="email" class="form-control" name="email" placeholder="Write E-mail" id="Email">
                </div>
                <div class="form-group last mb-3">
                  <label for="password">Password</label>
                  <input type="password" class="form-control" name="password" placeholder="Your Password" id="password">
                </div>
                
                <div class="d-sm-flex mb-5 align-items-center">
                  <label class="control control--checkbox mb-3 mb-sm-0"><span class="caption">Remember me</span>
                    <input type="checkbox" checked="checked"/>
                    <div class="control__indicator"></div>
                  </label>
                  <!--<span class="ml-auto"><a href="#" class="forgot-pass">Forgot Password</a></span>--> 
                </div>

                <input type="submit" value="Log In" class="btn btn-block btn-primary">

              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    
  </div>
    
    

    <script src="<?=$js_login?>jquery-3.3.1.min.js"></script>
    <script src="<?=$js_login?>popper.min.js"></script>
    <script src="<?=$js_login?>bootstrap.min.js"></script>
    <script src="<?=$js_login?>main.js"></script>
  </body>
</html>