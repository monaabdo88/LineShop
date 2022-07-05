<?php 
include "init.php"; 
include $tpl."header.php";
$search_keyword = $_GET['search_key'];
if(isset($cat_id))
    $cat_id = intval($_GET['cat_id']);
else
    $cat_id = '';
$rows = search_products($search_keyword,$cat_id);
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
			
		<!-- Start Shop Home List  -->
	<section class="shop-home-list section">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					
					<?php 
                    if(count($rows) > 0 ):
						foreach($rows as $row):
							$image = get_item('file_name','files','product_id',$row['id']);

					?>
				<div class="col-lg-3 col-md-3 float-left">
					<!-- Start Single List  -->
					<div class="single-list" style="height:400px">
						<div class="row">
							<div class="col-lg-12 col-md-6 col-12">
								<div class="list-image overlay">
									<img src="assets/uploads/products/<?=$image?>" alt="#" style="height:180px;">
								</div>
							</div>
							<div class="col-lg-12 col-md-6 col-12 no-padding">
								<div class="content">
									<h4 class="title"><a href="product.php?product_id=<?=$row['id']?>"><?=$row['title']?></a></h4>
                                    <p><b>price : </b><?=$row['price']?></p>
									<p><b>By: </b><a href="userProducts.php?user_id=<?=$row['user_id']?>"><?=get_item('username','users','id',$row['user_id'])?></a></p>
                                    <a href="" class="text-primary float-right">Read More <i class="fa fa-arrow-right"></i></a>
								</div>
							</div>
						</div>
					</div>
					<!-- End Single List  -->
					</div>
				
					<?php 
						endforeach;
                    else:
                        echo '<div class="alert alert-danger"><p class="text-center">No Products Found for '.$search_keyword.'</p></div>';
                    endif;
					?>
					
					</div>
					<?php 
					//pagination
					$total_records = records_total('products','status',1,16);
					//check if records count > 18 show pagination
					if($total_records > 8):
					?>
					<div class="col-md-12">
					<nav aria-label="Page navigation example">
						<ul class="pagination float-right">
						<?php
						if (!isset($_GET['page'])) {
							$page = 1;
						} else{
							$page = $_GET['page'];
						}
						$previous = $page-1;
						$next = $page+1;
						?>
						<li class="page-item <?=(!$page || @$page <= 1)? 'disabled':'';?>">
							<a class="page-link" href='?page=<?=($previous)?>' class="links">Previous</a>
						</li>
						<?php
						for ($page=1; $page <= $total_records; $page++):?>
							
							<li class="page-item <?=(isset($page) && @$page == @$_GET['page']) ? 'active':''?>">
								<a class="page-link" href='?page=<?=$page?>' class="links"><?=$page?></a>
							</li>
							
						<?php endfor; ?>
					    <li class="page-item <?=(@$_GET['page']== $total_records) ? 'disabled':''?>">
							<a class="page-link" href='?page=<?=($next)?>' class="links">Next</a>
						</li>
						
						</ul>
					</nav>
					</div>
					<?php endif; ?>
			</div>
		</div>
	</section>
	<!-- End Shop Home List  -->

<?php 
include $tpl."footer.php";
?>