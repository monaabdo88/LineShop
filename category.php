<?php 
include "init.php"; 
include $tpl."header.php";
$id = intval($_GET['category_id']);
$checkCat = checkItem('id','categories',$id);

if(isset($id) && $checkCat > 0)
	$row = get_row_data('categories','id',$id);

if($row['status'] == 1){
?>
	<!-- Breadcrumbs -->
    <div class="breadcrumbs">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="bread-inner">
							<ul class="bread-list">
								<li><a href="index.php">Home<i class="ti-arrow-right"></i></a></li>
								<li class="active"><a href="blog-single.html"><?=$row['name']?></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- End Breadcrumbs -->
			
		<!-- Start Blog Single -->
		<section class="blog-single section">
			<div class="container">
				<div class="row">
					<div class="col-lg-8 offset-md-2 col-12">
						<div class="blog-single-main">
							<div class="row">
								<div class="col-12">
									
									
									
								</div>
																	
								
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</section>
		<!--/ End Blog Single -->
			
<?php include $tpl."footer.php";
}else{
	redirectPage('index.php',1);
}
?>