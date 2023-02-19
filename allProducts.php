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
							<li><a href="index">Home<i class="ti-arrow-right"></i></a></li>
							<li class="active"><a href="allProducts">products</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
		<!-- End Breadcrumbs -->
	<section class="product-area section" >
		<div class="container">
					<div class="row">
						<div class="col-lg-12 col-12">
                            <div class="single-list">
    						<div class="row">
    						    <?php 
    						        foreach($rows as $product):
    						            if($product['status'] == 1):
    						                 include $tpl."products.php"; 
    							        endif;
    							    endforeach;
    							?>
    						</div>
    					    </div>
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


<?php 
include $tpl."footer.php";
?>