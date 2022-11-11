<?php 
include "init.php"; 
include $tpl."header.php";
include "includes/functions/mail.php"; 
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['do_send']) && $_POST['do_send'] == 'send_email'){
	$errors = send_email();
}																	
?>

	<!-- Breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="bread-inner">
						<ul class="bread-list">
							<li><a href="index.php">Home<i class="ti-arrow-right"></i></a></li>
							<li class="active"><a href="contact.php">Contact</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Breadcrumbs -->
  
	<!-- Start Contact -->
	<section id="contact-us" class="contact-us section" style="padding-bottom:0">
		<div class="container">
				<div class="contact-head">
					<div class="row">
						<div class="col-lg-8 col-12">
							<div class="form-main">
							<?php 
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
											if($type == 'success') header('refresh:5;url='.$_SERVER['HTTP_REFERER']);
									}
												
								}
							?>
								<div class="title">
									<h4>Get in touch</h4>
									<h3>Write us a message</h3>
								</div>
								<form class="form"  action="<?=$_SERVER['PHP_SELF']?>" method="POST">
									<div class="row">
										<div class="col-lg-6 col-12">
											<div class="form-group">
												<label>Your Name<span>*</span></label>
												<input name="name" type="text" placeholder="">
											</div>
										</div>
										<div class="col-lg-6 col-12">
											<div class="form-group">
												<label>Your Subjects<span>*</span></label>
												<input name="subject" type="text" placeholder="">
											</div>
										</div>
										<div class="col-lg-6 col-12">
											<div class="form-group">
												<label>Your Email<span>*</span></label>
												<input name="email" type="email" placeholder="">
											</div>	
										</div>
										<div class="col-lg-6 col-12">
											<div class="form-group">
												<label>Your Phone<span>*</span></label>
												<input name="phone" type="text" placeholder="">
											</div>	
										</div>
										<div class="col-12">
											<div class="form-group message">
												<label>your message<span>*</span></label>
												<textarea name="message" placeholder=""></textarea>
											</div>
										</div>
										<div class="col-12">
											<div class="form-group button">
												<button type="submit" class="btn " name="do_send" value="send_email">Send Message</button>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
						<div class="col-lg-4 col-12">
							<div class="single-head">
								<div class="single-info">
									<i class="fa fa-phone"></i>
									<h4 class="title">Call us Now:</h4>
									<ul>
										<li><?=get_item('site_phone','settings','id',1);?></li>
									</ul>
								</div>
								<div class="single-info">
									<i class="fa fa-envelope-open"></i>
									<h4 class="title">Email:</h4>
									<ul>
										<li><a href="mailto:<?=get_item('site_email','settings','id',1);?>"><?=get_item('site_email','settings','id',1);?></a></li>
									</ul>
								</div>
								<div class="single-info">
									<i class="fa fa-location-arrow"></i>
									<h4 class="title">Our Address:</h4>
									<ul>
										<li><?=get_item('site_address','settings','id',1);?></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	</section>
	<!--/ End Contact -->
	
<?php 
include $tpl."footer.php"; 
?>