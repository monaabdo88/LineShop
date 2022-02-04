<footer class="footer">
		<!-- Footer Top -->
		<div class="footer-top section">
			<div class="container">
				<div class="row">
					<div class="col-lg-5 col-md-6 col-12">
						<!-- Single Widget -->
						<div class="single-footer about">
							<div class="logo">
								<h4><a href="index.php" style="color:#fff;font-size:17px;font-weight:bold"><?=get_item('site_name','settings','id',1)?></a></h4>
							</div>
							<p class="text"><?=get_item('site_summery','settings','id',1);?></p>
							<p class="call">Got Question? Call us 24/7<span><a href="<?=get_item('wh_url','settings','id',1)?>"><?=get_item('site_phone','settings','id',1)?></a></span></p>
						</div>
						<!-- End Single Widget -->
					</div>
					<div class="col-lg-2 col-md-6 col-12">
						<!-- Single Widget -->
						<div class="single-footer links">
							<h4>Information</h4>
							<ul>
								<li><a href="index.php">Home</a></li>
								<?php 
									$pages = get_all_rows_data('pages','status',1,3);
									foreach($pages as $page){
										echo '<li><a href="page.php?id='.$page['id'].'">'.strtoupper($page['title']).'</a></li>';
									}
								?>
								<li><a href="contact.php">Contact Us</a></li>
							</ul>
						</div>
						<!-- End Single Widget -->
					</div>
					<div class="col-lg-2 col-md-6 col-12">
						<!-- Single Widget -->
						<div class="single-footer links">
							<h4>Categories</h4>
							<ul>
							<?php 
								$cats = get_all_rows_data('categories','status',1,5);
								foreach($cats as $cat){
									echo '<li><a href="category.php?id='.$cat['id'].'">'.strtoupper($cat['name']).'</a></li>';
								}
							?>
							</ul>
						</div>
						<!-- End Single Widget -->
					</div>
					<div class="col-lg-3 col-md-6 col-12">
						<!-- Single Widget -->
						<div class="single-footer social">
							<h4>Get In Tuch</h4>
							<!-- Single Widget -->
							<div class="contact">
								<ul>
									<li><?=get_item('site_address','settings','id',1)?></li>
									<li><?=get_item('site_email','settings','id',1)?></li>
									<li><?=get_item('site_phone','settings','id',1)?></li>
								</ul>
							</div>
							<!-- End Single Widget -->
							<ul>
								<li><a href="<?=get_item('fb_url','settings','id',1)?>"><i class="ti-facebook"></i></a></li>
								<li><a href="<?=get_item('tw_url','settings','id',1)?>"><i class="ti-twitter"></i></a></li>
								<li><a href="<?=get_item('ln_url','settings','id',1)?>"><i class="ti-linkedin"></i></a></li>
								<li><a href="<?=get_item('wh_url','settings','id',1)?>"><i class="ti-mobile"></i></a></li>
							</ul>
						</div>
						<!-- End Single Widget -->
					</div>
				</div>
			</div>
		</div>
		<!-- End Footer Top -->
		<div class="copyright">
			<div class="container">
				<div class="inner">
					<div class="row">
						<div class="col-lg-12 col-12">
							<div>
								<p class="text-center">	<?=get_item('site_copyrights','settings','id',1);?></p>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</footer>
	<!-- /End Footer Area -->
 
	<!-- Jquery -->
	<script src="<?=$js_front?>jquery.min.js"></script>
    <script src="<?=$js_front?>jquery-migrate-3.0.0.js"></script>
	<script src="<?=$js_front?>jquery-ui.min.js"></script>
	<!-- Popper JS -->
	<script src="<?=$js_front?>popper.min.js"></script>
	<!-- Bootstrap JS -->
	<script src="<?=$js_front?>bootstrap.min.js"></script>
	<!-- Slicknav JS -->
	<script src="<?=$js_front?>slicknav.min.js"></script>
	<!-- Owl Carousel JS -->
	<script src="<?=$js_front?>owl-carousel.js"></script>
	<!-- Magnific Popup JS -->
	<script src="<?=$js_front?>magnific-popup.js"></script>
	<!-- Waypoints JS -->
	<script src="<?=$js_front?>waypoints.min.js"></script>
	<!-- Countdown JS -->
	<script src="<?=$js_front?>finalcountdown.min.js"></script>
	<!-- Nice Select JS -->
	<script src="<?=$js_front?>nicesellect.js"></script>
	<!-- Flex Slider JS -->
	<script src="<?=$js_front?>flex-slider.js"></script>
	<!-- ScrollUp JS -->
	<script src="<?=$js_front?>scrollup.js"></script>
	<!-- Onepage Nav JS -->
	<script src="<?=$js_front?>onepage-nav.min.js"></script>
	<!-- Easing JS -->
	<script src="<?=$js_front?>easing.js"></script>
	<!-- Active JS -->
	<script src="<?=$js_front?>active.js"></script>
</body>
</html>