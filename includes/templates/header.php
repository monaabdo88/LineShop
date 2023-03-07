<?php 
ob_start();
session_start();
ini_set("display_errors", 1); 
error_reporting(E_ALL);
include "includes/functions/functions.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Meta Tag -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="<?=get_item('site_desc','settings','id',1)?>">
    <meta name="keywords" content="<?=get_item('site_tags','settings','id',1)?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Title Tag  -->
    <title><?=get_item('site_name','settings','id',1)?></title>
	<!-- Favicon -->
	<link rel="icon" type="image/png" href="<?=get_item('site_logo','settings','id',1)?>">
	<!-- Web Font -->
	<link href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
	
	<!-- StyleSheet -->
	
	<!-- Bootstrap -->
	<link rel="stylesheet" href="<?=$css_front?>bootstrap.css">
	<!-- Magnific Popup -->
    <link rel="stylesheet" href="<?=$css_front?>magnific-popup.min.css">
	<!-- Font Awesome -->
    <link rel="stylesheet" href="<?=$css_front?>font-awesome.css">
	<!-- Fancybox -->
	<link rel="stylesheet" href="<?=$css_front?>jquery.fancybox.min.css">
	<!-- Themify Icons -->
    <link rel="stylesheet" href="<?=$css_front?>themify-icons.css">
	<!-- Nice Select CSS -->
    <link rel="stylesheet" href="<?=$css_front?>niceselect.css">
	<!-- Animate CSS -->
    <link rel="stylesheet" href="<?=$css_front?>animate.css">
	<!-- Flex Slider CSS -->
	<link rel="stylesheet" href="<?=$css_front?>flex-slider.min.css">
	<link rel="stylesheet" href="<?=$css_front?>jquery.exzoom.css"/>
	<!-- Owl Carousel -->
    <link rel="stylesheet" href="<?=$css_front?>owl-carousel.css">
	<!-- Slicknav -->
    <link rel="stylesheet" href="<?=$css_front?>slicknav.min.css">
	<!------------------Datatables style -------------------------------->
	<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <!-- Eshop StyleSheet -->
	<link rel="stylesheet" href="<?=$css_front?>reset.css">
	<link rel="stylesheet" href="<?=$css_front?>style.css">
    <link rel="stylesheet" href="<?=$css_front?>responsive.css">
	<link rel="stylesheet" href="<?=$css_front?>myStyle.css">
    <style type="text/css">
	    #removeFavourite {
          display: none;
        }
        .hidden { display: none; }
	</style>

	<?php 
		$baseUrl = get_item('site_link','settings','id',1);
		$site_status = get_item('site_status','settings','id',1);
		$text_close = get_item('site_text_close','settings','id',1);
		if($site_status == 0)
		{
			echo '
				<div class="col-md-12 msg-container">
					<div class="alert alert-danger msg-box">
						<p class="text-center"><b>'.$text_close.'</b></p>
					</div>
				</div>';
				die();
		}
	?>
<script>
	
</script>	
</head>
<body class="js">
	
	<!-- Preloader -->
	<div class="preloader">
		<div class="preloader-inner">
			<div class="preloader-icon">
				<span></span>
				<span></span>
			</div>
		</div>
	</div>
	<!-- End Preloader -->
	
	
	<!-- Header -->
	<header class="header shop">
		<!-- Topbar -->
		<div class="topbar">
			<div class="container">
				<div class="row">
					<div class="col-lg-5 col-md-12 col-12">
						<!-- Top Left -->
						<div class="top-left">
							<ul class="list-main">
								<li><i class="ti-headphone-alt"></i><?=get_item('site_phone','settings','id',1)?></li>
								<li><i class="ti-email"></i><?=get_item('site_email','settings','id',1)?></li>
							</ul>
						</div>
						<!--/ End Top Left -->
					</div>
					<div class="col-lg-7 col-md-12 col-12">
						<!-- Top Right -->
						<div class="right-content">
							<ul class="list-main">
								<?php if(isset($_SESSION['user_id']) && $_SESSION['user_id'] != ''): ?>
								<li><i class="ti-user"></i><a href="profile.php"><?=$_SESSION['username']?></a></li>
								<li><i class="ti-power-off"></i><a href="logout.php">Logout</a></li>
								<?php else: ?>
								<li><i class="ti-user"></i><a href="singup.php">Singup</a></li>
								<li><i class="ti-power-off"></i><a href="login.php">Login</a></li>
								<?php endif ?>
							</ul>
						</div>
						<!-- End Top Right -->
					</div>
				</div>
			</div>
		</div>
		<!-- End Topbar -->
		<div class="middle-inner">
			<div class="container">
				<div class="row">
					<div class="col-lg-2 col-md-2 col-12">
						<!-- Logo -->
						<div class="logo">
							<a href="index" class="navbar-brand site_name"><?=get_item('site_name','settings','id',1)?></a>
						</div>
						<!--/ End Logo -->
						<!-- Search Form -->
						<div class="search-top">
							<div class="top-search"><a href="#0"><i class="ti-search"></i></a></div>
							<!-- Search Form -->
							<div class="search-top">
								<form class="search-form" method="GET" action="searchresult.php">
									<input type="text" placeholder="Search here..." name="search_key">
									<button value="search" type="submit"><i class="ti-search"></i></button>
								</form>
							</div>
							<!--/ End Search Form -->
						</div>
						<!--/ End Search Form -->
						<div class="mobile-nav"></div>
					</div>
					<div class="col-lg-8 col-md-7 col-12">
						<div class="search-bar-top">
							<div class="search-bar">
								<select class="nice-select" id="search_cats">
									<option selected="selected">All Category</option>
									<?php 
									foreach(get_all_rows_data('categories','status',1) as $cat){
										echo '<option value="'.$cat['id'].'">'.$cat['name'].'</option>';
									}
									?>
								</select>
								<form method="GET" action="searchresult.php">
									<input name="search_key" placeholder="Search Products Here....." type="search">
									<input type="hidden" name="category_id" id="cat_id" value="" />
									<button class="btnn" type="submit"><i class="ti-search"></i></button>
								</form>
							</div>
						</div>
					</div>
					<div class="col-lg-2 col-md-3 col-12">
						<?php if(isset($_SESSION['user_id'])): ?>
						<div class="right-bar">
							<!-- Search Form -->
							<div class="sinlge-bar">
								<a href="myProducts.php?do=addPro" class="single-icon"><i class="fa fa-plus" aria-hidden="true" title="Add New Product"></i></a>
							</div>
							<div class="sinlge-bar">
								<a href="favs.php" class="single-icon"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
							</div>
							
							<div class="sinlge-bar shopping">
								<a href="userCart.php" class="single-icon"><i class="ti-bag"></i> <span class="total-count"><?=get_data_column_count('orders','user_id',$_SESSION['user_id'])?></span></a>
								<!-- Shopping Item -->
								<div class="shopping-item">
									<div class="dropdown-cart-header">
										<span class="total-count"><?=get_data_column_count('orders','user_id',$_SESSION['user_id'])?> </span> <span>Items</span>
										<a href="userCart.php">View Cart</a>
									</div>
									<ul class="shopping-list">
										<?php 
										//get the cart items
										$order_products = get_all_rows_data('orders','user_id',$_SESSION['user_id']);
										$total = 0;
										foreach($order_products as $order_pro):
											$pros = get_all_rows_data('products','id',$order_pro['product_id']);
											foreach($pros as $pro):
												if($pro['discount'] != 0)
													$price_after_discount = price_after_discount($pro['price'], $pro['discount']);
												else
													$price_after_discount = $pro['price'];
												$total  = get_orders_total($_SESSION['user_id']);
												echo'
												<li id="'.$pro['id'].'">
													<a href="#" class="remove_cart" title="Remove this item" data-product-id="'.$pro['id'].'" data-user-id="'.$_SESSION['user_id'].'" data-price="'.$price_after_discount.'" data-method="delCart">
														<i class="fa fa-remove"></i>
													</a>
													<a class="cart-img" href="product?product_id='.$pro['id'].'">';
													$img_name = get_item('file_name','files','product_id',$pro['id']);
													$img_dir = get_item('file_dir','files','product_id',$pro['id']);
													echo'
													<img src="'.$img_dir.'/'.$img_name.'" alt="#"></a>
													<h4><a href="product?product_id='.$pro['id'].'">'.$pro['title'].'</a></h4>
													<p class="quantity">1x - <span class="amount">$'.$price_after_discount.'</span></p>
												</li>';
												
											endforeach;
										endforeach;
										?>
										
										
									</ul>
									<div class="bottom">
										<div class="total">
											<input type="hidden" name="cart_total" value="<?=$total?>"/>
											<span>Total</span>
											<span class="total-amount">$
												<?=$total?></span>
										</div>
										<a href="checkout.html" class="btn animate">Checkout</a>
									</div>
								</div>
								<!--/ End Shopping Item -->
							</div>
						</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		<!-- Header Inner -->
		<div class="header-inner">
			<div class="container">
				<div class="cat-nav-head">
					<div class="row">
					<?php 
						if(isActive('index.php',1) == 'active'|| isActive(' ',1) == 'active'):
					?>	
					<div class="col-lg-3">
							
						<div class="all-category">
								
							<h3 class="cat-heading"><i class="fa fa-bars" aria-hidden="true"></i>CATEGORIES</h3>
								
								<ul class="main-category">
									<?php 
										//Get All Main Categories
										$main_cats = get_all_rows_data('categories','parent_id',0);
										//start to fetch all main categories
										foreach($main_cats as $parent_cat){
											//check if category had sub categories
											$sub_cats = get_data_column_count('categories','parent_id',$parent_cat['id']);
											if($parent_cat['status'] == 1):
												echo '<li><a href="category.php?category_id='.$parent_cat['id'].'">'.$parent_cat['name'];
												if($sub_cats > 0){
													echo '<i class="fa fa-angle-right" aria-hidden="true"></i></a>
													<ul class="sub-category">';
														$sub_categories = get_all_rows_data('categories','parent_id',$parent_cat['id']);
														foreach($sub_categories as $sub_cat){
															echo '<li><a href="category.php?category_id='.$sub_cat['id'].'">'.$sub_cat['name'].'</a></li>';
														}
													echo'</ul></li>';
												}
												else{
													echo '</a></li>';
												}
											endif;
									
											}
									?>
								</ul>
								
							</div>
							
						</div>
						<?php endif; ?>
						<div class="col-lg-<?=(isActive('index',1) == 'active' || isActive('',1) == 'active')? '9' : '12'?> col-12">
							<div class="menu-area">
								<!-- Main Menu -->
								<nav class="navbar navbar-expand-lg">
									<div class="navbar-collapse">	
										<div class="nav-inner">	
											<ul class="nav main-menu menu navbar-nav">
													<li class="<?=isActive('index')?><?=isActive('')?>"><a href="index">Home</a></li>
													<li class="<?=isActive('categories')?>"><a href="categories">All Categories</a></li>
													<li class="<?=isActive('allProducts')?>"><a href="allProducts">Products</a></li>
													<?php 
														$pages = get_all_rows_data('pages','status',1,3);
														foreach($pages as $page){
															(isset($_GET['page_id']) && $_GET['page_id'] == $page['id'])? $class='active' : $class = '';
															echo '<li class="'.$class.'"><a href="page?page_id='.$page['id'].'">'.$page['title'].'</a></li>';
														}
													?>
													<li class="<?=isActive('contact')?>"><a href="contact">Contact Us</a></li>
												</ul>
										</div>
									</div>
								</nav>
								<!--/ End Main Menu -->	
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--/ End Header Inner -->
	</header>