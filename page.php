<?php 
include "init.php"; 
include $tpl."header.php";
$id = intval($_GET['page_id']);
$checkPage = checkItem('id','pages',$id);

if(isset($id) && $checkPage > 0)
	$row = get_row_data('pages','id',$id);

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
								<li class="active"><a href="blog-single.html"><?=$row['title']?></a></li>
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
									
									<div class="blog-detail">
										<h2 class="blog-title"><?=$row['title']?></h2>
										
										<div class="content">
											<?=$row['content']?>
										</div>
									</div>
									
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