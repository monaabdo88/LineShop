<?php 
include "init.php"; 
include $tpl."header.php";
$search_keyword = $_GET['search_key'];
if(isset($cat_id))
    $cat_id = intval($_GET['cat_id']);
else
    $cat_id = '';
$products = search_products($search_keyword,$cat_id);
?>
	<!-- Breadcrumbs -->
    <div class="breadcrumbs">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="bread-inner">
							<ul class="bread-list">
								<li><a href="index.php">Home<i class="ti-arrow-right"></i></a></li>
								<li class="active"><a href="products.php">Search Results For <?=$search_keyword?></a></li>
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
include $tpl."footer.php";
?>