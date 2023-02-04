<?php 
include "init.php"; 
include $tpl."header.php";
$id = intval($_GET['category_id']);
$checkCat = checkItem('id','categories',$id);
$catDetails = get_row_data('categories',$id);
$subCats = get_data_column_count('categories','parent_id',$id);
if(isset($id) && $checkCat > 0 ):
?>
    	<!-- Breadcrumbs -->
        <div class="breadcrumbs">
    			<div class="container">
    				<div class="row">
    					<div class="col-12">
    						<div class="bread-inner">
    							<ul class="bread-list">
    								<li><a href="index.php">Home</a></li>
    								<?=get_cat_parent($catDetails['parent_id'])?>
    								<li class="active">
    								    <a href="category.php?category_id=<?=$id?>">
    								        <i class="ti-arrow-right"></i><?=$catDetails['name']?>
    								    </a>
    								</li>
    							</ul>
    						</div>
    					</div>
    				</div>
    			</div>
    		</div>
    		<!-- End Breadcrumbs -->
    			
    <section class="<?=($subCats > 0)? 'shop-home-list': 'product-area';?> section">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-12">
					
					<?php 
					//get Sub Categories of Main Category
					if($subCats > 0){
    					$rows = get_all_rows_data('categories','parent_id',$id,16);
    				    
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
						//get Products Of Category
					}else{
					    echo '<div class="single-list">
                                <div class="row">';
					    $rows = get_all_rows_data('products','category_id',$id,16);
					    foreach($rows as $product):
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
														<?php //include $tpl."addToButtons.php"?>
													</div>
												<div class="product-content">
													<h3><a href="product.php?product_id=<?=$product['id']?>"><?= $product['title'] ?></a></h3>
												<div class="product-price">
													<span><?=$product['price']?>$</span>
												</div>
											</div>
										</div>
								</div>
					<?php
					        endif;
					   endforeach;
					   echo '</div></div>';
					}
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
    <?php include $tpl."footer.php";
    
    endif;
?>