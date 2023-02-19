<?php 
include "init.php"; 
include $tpl."header.php";
include "includes/functions/users.php";
if(isset($_SESSION['user_id']))
	header("Location: index.php");
	
$email = $_GET['key'];
$token = $_GET['token'];
if(! isset($_GET['key']) && ! isset($_GET['token']))
    header("Location: index.php");
?>

	<!-- Breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="bread-inner">
						<ul class="bread-list">
							<li><a href="index">Home<i class="ti-arrow-right"></i></a></li>
							<li class="active"><a href="forgetPassword">Update Password</a></li>
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
									if ($_SERVER['REQUEST_METHOD'] == 'POST'){
										$errors = check_user_reset_password($email,$token);
									}
								
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
											if($type == 'success') header('refresh:5;url=login');
										}
										
									}
								?>
								<form class="form" action="<?=$_SERVER['PHP_SELF']?>?key=<?=$email?>&token=<?=$token?>"  method="POST" enctype="multipart/form-data">
									<div class="row">
										<input type="hidden" name="reset_link_token" value="<?=$token?>" />
										<input type="hidden" name="email" value="<?=$email?>" />
										<div class="col-lg-12 col-12">
											<div class="form-group">
												<label>Password<span>*</span></label>
												<input name="password" type="Password" required placeholder="New Password">
											</div>
										</div>
										<div class="col-lg-12 col-12">
											<div class="form-group">
												<label>Confirm Password<span>*</span></label>
												<input name="cpassword" type="Password" required placeholder="New Password">
											</div>
										</div>
										
										<div class="col-12">
											<div class="col-md-6 float-left">
												<div class="form-group button">
													<button type="submit" class="btn ">Save Changes</button>
												</div>
											</div>	
											
											
										</div>
									</div>
								</form>
							</div>
						</div>
						
					</div>
				</div>
			</div>
	</section>
	<!--/ End Contact -->
	
	
<?php include $tpl."footer.php" ?>


