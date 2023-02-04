<?php 
include_once "init.php"; 
include_once $tpl."header.php";
$user_id = intval($_GET['user_id']);
$user = get_row_data('users',$user_id);
$products = get_all_rows_data('products','user_id',$user_id);
?>
	<!-- Breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="bread-inner">
						<ul class="bread-list">
							<li><a href="index.php">Home<i class="ti-arrow-right"></i></a></li>
							<li class="active"><a href="#"><?=$user['username']?> Products</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Breadcrumbs -->
  
	<!-- Start Contact -->
	<section class="product-area section" >
		<div class="container">
					<div class="row">
						<div class="col-lg-12 col-12">
                            <div class="single-list">
    						<div class="row">
    						    <?php 
    						        foreach($products as $product):
    						            if($product['status'] == 1):
    						                include $tpl.'products.php';
    							        endif;
    							    endforeach;
    							?>
    						</div>
    					    </div>
						</div>

					</div>
			</div>
	</section>
	<!--/ End Contact -->
	
<?php 
    include_once $tpl."footer.php";
?>