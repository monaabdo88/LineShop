<?php 
$productId = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
$product_data = get_row_data('products','id',$productId);
$rowsCount = checkItem('id','products',$productId);
$media = get_row_data('files','product_id',$product_data['id']);
if($rowsCount > 0 && $user_id == $product_data['user_id']){
?>

	<!-- Breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="bread-inner">
						<ul class="bread-list">
							<li><a href="index.php">Home<i class="ti-arrow-right"></i></a></li>
                            <li><a href="userProducts.php">My Products<i class="ti-arrow-right"></i></a></li>
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
                                <form class="form-horizontal" action="?do=updateCode" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>" />
                                    <input type="hidden" name="product_id" value="<?= $product_data['id']?>" />

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
                                    <!-- Product Media Field --->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-2 control-label">Product Images</label>
                                            <div class="col-sm-10 col-md-12">
                                                <input type="file" name="file[]" class="form-control image-file" multiple=""/>
                                            </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <span id="selected-images">
                                                <?php 
                                                foreach($media as $img){
                                                    echo'<div class="pip col-md-3 float-left">
                                                            <img class="img-thumbnail img-responsive" src="assets/uploads/products/'.$img['file_name'].'" />
                                                            <button type="button" data-id="'.$img['id'].'" class="btn btn-sm btn-danger remove-db cross-image remove" style="padding:2px;margin-bottom:10px;margin-top:10px">Remove</button>
                                                        </div>';
                                                }
                                                ?>
                                            </span>
                                        </div>
                                    </div>  
                                    <!-- end product media field -->
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
<?php 
}else{
    redirectPage('userProducts.php',1);
}
?>
<!---- preview image before upload code ----->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script> 

$(document).ready(function() {
        
        if (window.File && window.FileList && window.FileReader) 
        {
          $(".image-file").on("change", function(e) 
          {
            var file = e.target.files,
            imagefiles = $(".image-file")[0].files;
            var i = 0;
            $.each(imagefiles, function(index, value){
              var f = file[i];
              var fileReader = new FileReader();
              fileReader.onload = (function(e) {
  
                $('<div class="pip col-md-3 float-left">' +
                  '<img src="' + e.target.result + '" class="img-thumbnail img-responsive">'+
                  '<p class="btn btn-sm btn-danger cross-image remove" style="padding:2px;margin-bottom:10px;margin-top:10px">Remove</p>'+
                  '<input type="hidden" name="image[]" value="' + e.target.result + '">' +
                  '<input type="hidden" name="imageName[]" value="' + value.name + '">' +
                  '</div>').insertAfter("#selected-images");
                  $(".remove").click(function(){
                    $(this).parent(".pip").remove();
                  });
              });
              fileReader.readAsDataURL(f);
              i++;
            });
          });
        } else {
          alert("Your browser doesn't support to File API")
        }
        //delete image
        $(".remove-db").on("click", function(e) {
            var img_id = $(this).attr('data-id');            
            $.ajax({
              type: "GET", 
              dataType: "json", 
              url: "?do=delImg&img_id=" + img_id,
              success: function(response) {
                  if (response.status == "success") {
                    console.log(response);
                  } else {
                    console.log(response);
                  }
              }
            });
            $(this).parent(".pip").remove();  
  
        });
      });
   
</script>