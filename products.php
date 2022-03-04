<?php 
include "init.php"; 
include $tpl."header.php";
$rows = paginate_records('products','status',1,16);
?>
	<!-- Breadcrumbs -->
    <div class="breadcrumbs">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="bread-inner">
							<ul class="bread-list">
								<li><a href="index.php">Home<i class="ti-arrow-right"></i></a></li>
								<li class="active"><a href="products.php">products</a></li>
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
						foreach($rows as $row):
							$image = get_item('file_name','files','product_id',$row['id']);

					?>
				<div class="col-lg-3 col-md-3 float-left">
					<!-- Start Single List  -->
					<div class="single-list" style="height:350px">
						<div class="row">
							<div class="col-lg-12 col-md-6 col-12">
								<div class="list-image overlay">
									<img src="assets/uploads/products/<?=$image?>" alt="#" style="max-height:180px;">
								</div>
							</div>
							<div class="col-lg-12 col-md-6 col-12 no-padding">
								<div class="content">
									<h4 class="title"><a href="product.php?product_id=<?=$row['id']?>"><?=$row['title']?></a></h4>
                                    <p><?=$row['created_at']?></p>
                                    <p><?=get_item('username','users','id',$row['user_id'])?></p>
								</div>
							</div>
						</div>
					</div>
					<!-- End Single List  -->
					</div>
				
					<?php 
						endforeach;
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