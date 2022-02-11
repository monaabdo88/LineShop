<?php 
include "init.php"; 
include $tpl."header.php";
$user_id = $_SESSION['user_id'];
if(isset($user_id)){
?>

	<!-- Breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="bread-inner">
						<ul class="bread-list">
							<li><a href="index.php">Home<i class="ti-arrow-right"></i></a></li>
							<li class="active"><a href="#"><?=get_item('username','users','id',$user_id)?> Profile</a></li>
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
							
								<div class="title">
									<h4>Get in touch</h4>
									<h3>Write us a message</h3>
								</div>
								
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
    include "subscribe.php";
    include $tpl."footer.php";
}else{
    redirectPage('index.php',1);
}
?>