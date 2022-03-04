<?php 
include "includes/functions/mail.php"; 
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_subscribe']) && $_POST['add_subscribe'] == 'subscribe'){
	$errors_msg = add_mail();
}																	
?>
<!-- Start Shop Newsletter  -->
<section class="shop-newsletter section">
		<div class="container">
			<div class="inner-top">
				<div class="row">
					<div class="col-lg-8 offset-lg-2 col-12">
					  <?php 
					  //show error message
						if(isset($errors_msg) && $errors_msg != ''){
							foreach($errors_msg as $key => $value){
								($key == 'error') ? $type = 'danger': $type='success';
									echo '<div class="alert alert-'.$type.' alert-dismissible fade show" role="alert">
										<strong class="text-center">'.$value.'</strong>
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
										</div>';
									if($type == 'success') header('refresh:5;url='.$_SERVER['HTTP_REFERER']);
							}
										
						}
						?>
						<!-- Start Newsletter Inner -->
						<div class="inner">
							<h4>Newsletter</h4>
							<p> Subscribe to our newsletter and get <span>10%</span> off your first purchase</p>
							<form action="<?=$_SERVER['PHP_SELF']?>" method="POST" class="newsletter-inner">
								<input name="email" placeholder="Your email address" required="" type="email">
								<button class="btn" type="submit" name="add_subscribe" value="subscribe">Subscribe</button>
							</form>
						</div>
						<!-- End Newsletter Inner -->
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- End Shop Newsletter -->