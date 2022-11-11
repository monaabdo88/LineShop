<?php 
include "init.php"; 
include $tpl."header.php";
include "includes/functions/users.php";
if(isset($_SESSION['user_id']))
	header("Location: index.php");
	
$email = $_GET['key'];
$token = $_GET['token'];
if(! isset($email) && ! isset($token))
    header("Location: index.php");
?>

	<!-- Breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="bread-inner">
						<ul class="bread-list">
							<li><a href="index.php">Home<i class="ti-arrow-right"></i></a></li>
							<li class="active"><a href="forgetPassword.php">Verify Your Account</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Breadcrumbs -->
  
	<!-- Start Contact -->
	<section id="contact-us" class="contact-us section">
		<div class="container">
				<div class="contact-head">
					<div class="row">
						<div class="col-lg-8 offset-md-2 col-12">
							<div class="form-main">
								<div class="title">
									<h4>Restore Password</h4>
								</div>
								<?php 
									
								    if( isset($_GET['key']) &&  isset($_GET['token']))
                                        $errors = verifyUser($email,$token);
									//show error message
									if(isset($errors) && $errors != ''){
										foreach($errors as $key => $value){
											($key == 'error') ? $type = 'danger': $type='success';
											echo '<div class="alert alert-'.$type.' alert-dismissible fade show" role="alert">
											<strong class="text-center">'.$value.'</strong>
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
											</div>';
											if($type == 'success') header('refresh:5;url=index.php');  
											    
											  
									
										}
										
									}
								?>
								
							</div>
						</div>
						
					</div>
				</div>
			</div>
	</section>
	<!--/ End Contact -->
	
	
<?php include $tpl."footer.php" ?>


