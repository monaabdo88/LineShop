<?php 
$product_id = intval($_GET['id']);
//check if isset product_id
//get product details
$product_data = get_row_data('products','id',$product_id);         
?>

	<!-- Breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="bread-inner">
						<ul class="bread-list">
							<li><a href="index.php">Home<i class="ti-arrow-right"></i></a></li>
							<li class="active"><a href="#">Edit <?=$product_data['title']?></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Breadcrumbs -->
  
	<!-- Start Contact -->
	<section id="contact-us" class="contact-us section" style="padding-bottom:0">
		<div class="container">
				<div class="contact-head">
					<div class="row">
						<div class="col-lg-9 col-12">
							<div class="form-main">
							
								<div class="title">
									<h4>Edit <?=$product_data['title']?></h4>
									
								</div>
                                <form class="form-horizontal" action="<?=$_SERVER['PHP_SELF']?>" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>" />
                                    <!-- Start Product name Field -->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-2 control-label">Product Title</label>
                                        <div class="col-sm-10 col-md-12">
                                            <input type="text" name="title" class="form-control" required="required" value="<?=$product_data['title']?>"/>
                                        </div>
                                    </div>
                                    
                                    <!-- Start Product description Field -->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-12 control-label">Product Description</label>
                                        <div class="col-sm-10 col-md-12">
                                            <textarea class="form-control" id="editor1" name="details"><?=$product_data['details']?></textarea>
                                        </div>
                                    </div>
                                    <!-- End Product description Field -->
                                       
                                    <!-- Start Category Field -->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-2 control-label">Category</label>
                                        <div class="col-sm-10 col-md-12">
                                            <select class="form-control" name="category_id">
                                                <option value="">Choose Category</option>
                                                <?php
                                                    foreach(fetchCategoryTree() as $cat){
                                                        $selected = '';
                                                        if($cat['id'] == $product_data['category_id']) 
                                                            $selected = 'selected';
                                                        else 
                                                        $select = '';
                                                        echo '<option value="'.$cat['id'].'" '.$selected.'>'.$cat['name'].'</option>';
                                                    }
                                                    
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- End Category Field -->
                                    
                                    <!-- start Product price Field -->
                                    <div class="form-group form-group-lg col-md-4 float-right">
                                        <label class="col-sm-6 control-label float-left">Product Price</label>
                                        <div class="col-sm-6 col-md-6 float-right">
                                            <input type="text" name="price" class="form-control" value="<?=$product_data['price']?>"/>
                                        </div>
                                    </div>
                                    <!-- End Product price Field -->
                                    <!-- start Product disount Field -->
                                    <div class="form-group form-group-lg col-md-4 float-right">
                                        <label class="col-sm-6 control-label float-left">Product Discount</label>
                                        <div class="col-sm-6 col-md-6 float-right">
                                            <input type="text" name="discount" class="form-control" value="<?=$product_data['discount']?>"/>
                                        </div>
                                    </div>
                                    <!-- End Product disount Field -->
                                    <!-- start Product quantity Field -->
                                    <div class="form-group form-group-lg col-md-4 float-right">
                                        <label class="col-sm-6 control-label float-left">Product Quantity</label>
                                        <div class="col-sm-6 col-md-6 float-right">
                                            <input type="text" name="quantity" class="form-control" value="<?=$product_data['quantity']?>"/>
                                        </div>
                                    </div>
                                    <!-- End Product quantity Field -->
                                    <!-- Start Product tags Field -->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-2 control-label">Tags</label>
                                        <div class="col-sm-10 col-md-12">
                                            <?php foreach(get_rows('tags') as $tag): ?>
                                                <div class="col-md-3 float-left">
                                                    <?php 
                                                    $check_tag = check_product_tag($product_data['id'],$tag['id']);
                                                    ($check_tag > 0) ? $checked = 'checked' : $checked = '';
                                                
                                                    ?>
                                                    <input type="checkbox" name="tag[]" value="<?=$tag['id']?>" <?=$checked?>> <?=$tag['title']?>
                                                </div>
                                            <?php endforeach ?>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <!-- End Product tags Field -->
                                    <!-- Start Submit Field -->
                                    <div class="clearfix"></div>
                                    <div class="col-md-12">
                                        <input type="submit" name="add_pro" value="Save" class="btn btn-primary btn-block btn-lg" />
                                        <br>
                                    </div>
                                    
                                    <!-- End Submit Field -->
                                </form>
							</div>
						</div>
						<div class="col-lg-3 col-12">
							<div class="single-head profile-list">
								<div class="single-info">
									
									<ul class="list-group">
										<li class="list-group-item"><a href="profile.php?user_id=<?=$user_id?>">Edit Profile</a></li>
										<li class="list-group-item active"><a href="userProducts.php">Products</a></li>
										<li class="list-group-item"><a href="favs.php">Favs</a></li>
										<li class="list-group-item"><a href="messages.php">Messages</a></li>
										<li class="list-group-item"><a href="orders.php">Orders</a></li>
									</ul>
								</div>
								
							</div>
						</div>
					</div>
				</div>
			</div>
	</section>
	<!--/ End Contact -->
