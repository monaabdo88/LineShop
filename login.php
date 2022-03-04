<?php 
include "init.php"; 
include "includes/templates/header.php";
include "includes/functions/users.php";
if(isset($_SESSION['user_id']))
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
							<li class="active"><a href="login.php">Login</a></li>
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
									<h4>New User</h4>
								</div>
								<?php 
									if ($_SERVER['REQUEST_METHOD'] == 'POST'){
										$errors = login_user();
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
											if($type == 'success') header('refresh:1;url='.$_SERVER['HTTP_REFERER']);
										}
										
									}
								?>
								<form class="form" action="<?=$_SERVER['PHP_SELF']?>"  method="POST" enctype="multipart/form-data">
									<div class="row">
										
										<div class="col-lg-12 col-12">
											<div class="form-group">
												<label>Email<span>*</span></label>
												<input name="email" type="email" required placeholder="Email">
											</div>
										</div>
										<div class="col-lg-12 col-12">
											<div class="form-group">
												<label>Password<span>*</span></label>
												<input name="password" type="password" required placeholder="Password">
											</div>	
										</div>
										
										<div class="col-12">
											<div class="col-md-4 float-left">
												<div class="form-group button">
													<button type="submit" class="btn ">Login</button>
												</div>
											</div>	
											<div class="col-md-4 float-right">
												<a href="forget.php" class="float-right">Forget Password</a>
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
	
	
<?php include "includes/templates/footer.php" ?>


