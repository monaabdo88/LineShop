<?php 
include "init.php"; 
include $tpl."header.php";
$rows = paginate_records('categories','parent_id',0,16);
?>
	<!-- Breadcrumbs -->
    <div class="breadcrumbs">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="bread-inner">
							<ul class="bread-list">
								<li><a href="index.php">Home<i class="ti-arrow-right"></i></a></li>
								<li class="active"><a href="categories.php">Categories</a></li>
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
							if($row['status'] == 1):
								if($row['image'] == '')
									$image = 'no-img.jpg';
								else	
									$image = $row['image'];
					?>
				<div class="col-lg-3 col-md-3 float-left">
					<!-- Start Single List  -->
					<div class="single-list">
						<div class="row">
							<div class="col-lg-6 col-md-6 col-12">
								<div class="list-image overlay">
									<img src="assets/uploads/categories/<?=$image?>" alt="#">
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-12 no-padding">
								<div class="content">
									<h4 class="title"><a href="category.php?category_id=<?=$row['id']?>"><?=$row['name']?></a></h4>
								</div>
							</div>
						</div>
					</div>
					<!-- End Single List  -->
					</div>
				
					<?php 
							endif;
						endforeach;
					?>
					
					</div>
					<?php 
					//pagination
					$total_records = records_total('categories','parent_id',0,16);
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