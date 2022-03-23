<?php include "init.php"; ?>
<?php include $tpl."header.php"; ?>
	<!--/ End Header -->
	<?php 
	$slider_background = get_item('slider_background','settings','id',1);
	?>
	<!-- Slider Area -->
	<section class="hero-slider">
		<!-- Single Slider -->
		<div class="single-slider" style="background-image:url(<?=$slider_background?>)">
			
		</div>
		<!--/ End Single Slider -->
	</section>
	<!--/ End Slider Area -->
	
	
	<!-- Start Product Area -->
    <div class="product-area section">
            <div class="container">
				<div class="row">
					<div class="col-12">
						<div class="section-title">
							<h2>Trending Item</h2>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<div class="product-info">
							<div class="nav-main">
								<!-- Tab Nav -->
								<ul class="nav nav-tabs" id="myTab" role="tablist">
									<?php 
										$categories = get_all_rows_data('categories','status',1,6);
										foreach($categories as $index =>$category){
											$productCount = checkItem('category_id','products',$category['id']);
											if($productCount > 5):
												$class = '';
												if($index == 0) $class = 'active';
												
												echo '<li class="nav-item"><a class="nav-link '.$class.'" data-toggle="tab" href="#'.$category['id'].'" role="tab">'.$category['name'].'</a></li>';
											endif;
										}
									?>
								</ul>
								<!--/ End Tab Nav -->
							</div>
							
							<div class="tab-content" id="myTabContent">
								<?php 
								$categories = get_all_rows_data('categories','status',1,6);
								foreach($categories as $index =>$category):
									$productCount = checkItem('category_id','products',$category['id']);
									if($productCount > 5):
										$class = '';
										if($index == 0) $class = 'active show';
										
								?>
								<!-- Start Single Tab -->
								<div class="tab-pane fade <?=$class?>" id="<?=$category['id']?>" role="tabpanel">
									<div class="tab-single">
										<div class="row">
											<?php 
												$products = get_all_rows_data('products','category_id',$category['id']);
												foreach($products as $product):
													if($product['status'] == 1):
											?>
											<div class="col-xl-3 col-lg-4 col-md-4 col-12">
												<div class="single-product">
													<div class="product-img" style="height:250px;">
														<a href="product-details.html">
															<?php 
																$images = get_all_rows_data('files','product_id',$product['id'],1);
																foreach($images as $img):
															?>
															<img class="default-img" width="100%" height="350" src="assets/uploads/products/<?=$img['file_name']?>" alt="#">
															<?php endforeach; ?>
														</a>
														<div class="button-head">
															<div class="product-action">
																<a data-toggle="modal" data-target="#exampleModal" title="Quick View" href="#"><i class=" ti-eye"></i><span>Quick Shop</span></a>
																<a title="Wishlist" href="#"><i class=" ti-heart "></i><span>Add to Wishlist</span></a>
																<a title="Compare" href="#"><i class="ti-bar-chart-alt"></i><span>Add to Compare</span></a>
															</div>
															<div class="product-action-2">
																<a title="Add to cart" href="#">Add to cart</a>
															</div>
														</div>
													</div>
													<div class="product-content">
														<h3><a href="product.php?product_id=<?=$product['id']?>"><?= $product['title'] ?></a></h3>
														<div class="product-price">
															<span><?=$product['price']?></span>
														</div>
													</div>
												</div>
											</div>
											<?php 
												endif;
												endforeach; 
											?>
										</div>
									</div>
								</div>
								<!--/ End Single Tab -->
								
								<?php 
									endif;
									endforeach;
								?>
								
								
							</div>
						</div>
					</div>
				</div>
            </div>
    </div>
	<!-- End Product Area -->
	<!-- Start Shop Home List  -->
	<section class="shop-home-list section" style="margin-top:50px;">
		<div class="container">
			<div class="row">
				<div class="col-lg-4 col-md-6 col-12">
					<div class="row">
						<div class="col-12">
							<div class="shop-section-title">
								<h1>On sale</h1>
							</div>
						</div>
					</div>
					<?php 
						$products_sale = get_related_data('products','status',1,3,'discount');
						foreach($products_sale as $sale):
					?>
					<!-- Start Single List  -->
					<div class="single-list">
						<div class="row">
							<div class="col-lg-6 col-md-6 col-12">
								<div class="list-image overlay">
									<img src="assets/uploads/products/<?=get_item('file_name','files','product_id',$sale['id'])?>" alt="#">
									<a href="product.php?product_id=<?=$sale['id']?>" class="buy"><i class="fa fa-shopping-bag"></i></a>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-12 no-padding">
								<div class="content">
									<h4 class="title"><a href="product.php?product_id=<?=$sale['id']?>"><?=$sale['title']?></a></h4>
									<p class="price with-discount">$<?=$sale['price']?></p>
                                    <p><b>Quantity: </b><?=$sale['quantity']?></p>
									<p><b>By: </b><a href="userProducts.php?user_id=<?=$sale['user_id']?>"><?=get_item('username','users','id',$sale['user_id'])?></a></p>
								</div>
							</div>
						</div>
					</div>
					
					<!-- End Single List  -->
					<?php 
						endforeach;
					?>
					
					
				</div>
				<div class="col-lg-4 col-md-6 col-12">
					<div class="row">
						<div class="col-12">
							<div class="shop-section-title">
								<h1>Latest Items</h1>
							</div>
						</div>
					</div>
					<?php 
						$products_sale = get_related_data('products','status',1,3);
						foreach($products_sale as $sale):
					?>
					<!-- Start Single List  -->
					<div class="single-list">
						<div class="row">
							<div class="col-lg-6 col-md-6 col-12">
								<div class="list-image overlay">
									<img src="assets/uploads/products/<?=get_item('file_name','files','product_id',$sale['id'])?>" alt="#">
									<a href="product.php?product_id=<?=$sale['id']?>" class="buy"><i class="fa fa-shopping-bag"></i></a>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-12 no-padding">
								<div class="content">
									<h4 class="title"><a href="product.php?product_id=<?=$sale['id']?>"><?=$sale['title']?></a></h4>
									<p class="price with-discount">$<?=$sale['price']?></p>
									<p><b>Quantity: </b><?=$sale['quantity']?></p>
									<p><b>By: </b><a href="userProducts.php?user_id=<?=$sale['user_id']?>"><?=get_item('username','users','id',$sale['user_id'])?></a></p>
								
								</div>
							</div>
						</div>
					</div>
					<!-- End Single List  -->
					<?php 
						endforeach;
					?>
					
					
					
				</div>
				<div class="col-lg-4 col-md-6 col-12">
					<div class="row">
						<div class="col-12">
							<div class="shop-section-title">
								<h1>Top viewed</h1>
							</div>
						</div>
					</div>
					<?php 
						$products_sale = get_related_data('products','status',1,3,'views');
						foreach($products_sale as $sale):
					?>
					<!-- Start Single List  -->
					<div class="single-list">
						<div class="row">
							<div class="col-lg-6 col-md-6 col-12">
								<div class="list-image overlay">
									<img src="assets/uploads/products/<?=get_item('file_name','files','product_id',$sale['id'])?>" alt="#">
									<a href="product.php?product_id=<?=$sale['id']?>" class="buy"><i class="fa fa-shopping-bag"></i></a>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-12 no-padding">
								<div class="content">
									<h4 class="title"><a href="product.php?product_id=<?=$sale['id']?>"><?=$sale['title']?></a></h4>
									<p class="price with-discount">$<?=$sale['price']?></p>
									<p><b>Quantity: </b><?=$sale['quantity']?></p>
									<p><b>By: </b><a href="userProducts.php?user_id=<?=$sale['user_id']?>"><?=get_item('username','users','id',$sale['user_id'])?></a></p>
								
								</div>
							</div>
						</div>
					</div>
					<!-- End Single List  -->
					<?php 
						endforeach;
					?>
				</div>
			</div>
		</div>
	</section>
	<!-- End Shop Home List  -->
	
	
	
	<!-- Start Shop Services Area -->
	<section class="shop-services section home">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-6 col-12">
					<!-- Start Single Service -->
					<div class="single-service">
						<i class="ti-rocket"></i>
						<h4>Free shiping</h4>
						<p>Orders over $100</p>
					</div>
					<!-- End Single Service -->
				</div>
				<div class="col-lg-3 col-md-6 col-12">
					<!-- Start Single Service -->
					<div class="single-service">
						<i class="ti-reload"></i>
						<h4>Free Return</h4>
						<p>Within 30 days returns</p>
					</div>
					<!-- End Single Service -->
				</div>
				<div class="col-lg-3 col-md-6 col-12">
					<!-- Start Single Service -->
					<div class="single-service">
						<i class="ti-lock"></i>
						<h4>Sucure Payment</h4>
						<p>100% secure payment</p>
					</div>
					<!-- End Single Service -->
				</div>
				<div class="col-lg-3 col-md-6 col-12">
					<!-- Start Single Service -->
					<div class="single-service">
						<i class="ti-tag"></i>
						<h4>Best Peice</h4>
						<p>Guaranteed price</p>
					</div>
					<!-- End Single Service -->
				</div>
			</div>
		</div>
	</section>
	<!-- End Shop Services Area -->
	
	<?php include $tpl."subscribe.php" ?>

	
	<!-- Start Footer Area -->
<?php include $tpl."footer.php" ?>