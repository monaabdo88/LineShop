<?php 
//check if product ID from get request
$productId = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
$row = get_row_data('products','id',$productId);
$rowsCount = checkItem('id','products',$productId);
$media = get_row_data('files','product_id',$row['id']);
//Check is Product ID is already exists

//Check is Product ID is already exists
if($rowsCount > 0){
?>                
<form class="form-horizontal" action="?do=updateCode" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="user_id" value="<?= $_SESSION['admin_id'] ?>" />
    <input type="hidden" name="product_id" value="<?= $row['id']?>" />

    <!-- Start Product name Field -->
    <div class="form-group form-group-lg">
        <label class="col-sm-2 control-label">Product Title</label>
        <div class="col-sm-10 col-md-12">
            <input type="text" name="title" class="form-control" value="<?=$row['title']?>"  required="required" />
        </div>
    </div>
                                    
    <!-- Start Product description Field -->
    <div class="form-group form-group-lg">
        <label class="col-sm-2 control-label">Product Description</label>
        <div class="col-sm-10 col-md-12">
            <textarea class="form-control" id="editor1" name="details"><?=$row['details']?></textarea>
        </div>
    </div>
    <!-- End Product description Field -->
 
    <!-- Start Product status Field -->
    <div class="form-group form-group-lg">
        <label class="col-sm-2 control-label">Product Status</label>
        <div class="col-sm-10 col-md-12">
            <input type="radio" name="status" value="0" <?=($row['status'] == '0')? 'checked':''?>/> Not Active 
            <input type="radio" name="status" value="1" <?=($row['status'] == '1') ? 'checked':''?>/> Active
        </div>
    </div>
    <!-- End Product status Field -->
    <!-- Start Category Field -->
    <div class="form-group form-group-lg">
        <label class="col-sm-2 control-label">Category</label>
        <div class="col-sm-10 col-md-12">
            <select class="form-control" name="category_id">
                <option value="">Choose Category</option>
                    <?php
                        foreach(fetchCategoryTree() as $cat){
                            //check selected category
                            $selected = '';
                            if($cat['id'] == $row['category_id']) 
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
                <input type="text" name="price" value="<?=$row['price']?>" class="form-control" />
            </div>
    </div>
    <!-- End Product price Field -->
    <!-- start Product disount Field -->
    <div class="form-group form-group-lg col-md-4 float-right">
        <label class="col-sm-6 control-label float-left">Product Discount</label>
            <div class="col-sm-6 col-md-6 float-right">
                <input type="text" name="discount" class="form-control" value="<?=$row['discount']?>" />
            </div>
    </div>
    <!-- End Product disount Field -->
    <!-- start Product quantity Field -->
    <div class="form-group form-group-lg col-md-4 float-right">
        <label class="col-sm-6 control-label float-left">Product Quantity</label>
        <div class="col-sm-6 col-md-6 float-right">
            <input type="text" name="quantity" class="form-control" value="<?=$row['quantity']?>" />
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
                    $check_tag = check_product_tag($row['id'],$tag['id']);
                    ($check_tag > 0) ? $checked = 'checked' : $checked = '';
                
                    echo '<input type="checkbox" name="tag[]" value="'.$tag['id'].'" '.$checked.'> '.$tag['title'];  
                    ?>
                </div>
                <input type="hidden" name="tag_id" value="<?=$tag['id']?>" />
            <?php endforeach //end tags foreach?>
        </div>
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
                                <img class="img-thumbnail img-responsive" style="width: 100%; height: 100px;" src="../assets/uploads/products/'.$img['file_name'].'" />
                                <button type="button" data-id="'.$img['id'].'" class="btn btn-sm btn-danger remove-db cross-image remove">Remove</button>
                            </div>';
                    }
                    ?>
                </span>
            </div>
        </div>  
        <!-- end product media field -->
        <div class="clearfix"></div>
    </div>
    <!-- End Product tags Field -->                    
    <!-- Start Submit Field -->
                                        
    <div class="col-md-12">
        <input type="submit" value="Save" class="btn btn-primary btn-block btn-lg" />
    <br>
    </div>
    <!-- End Submit Field -->
    </form>
    <?php 
    }else{
        echo '
        <script type="text/javascript">
            $(document).ready(function(){
                errorFn("This Product is Not Found","error");

            });
            
        </script>';
        redirectPage('products.php');
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
                  '<img style="width: 100%; height: 100px;" src="' + e.target.result + '" class="img-thumbnail img-responsive">'+
                  '<p class="btn btn-sm btn-danger cross-image remove">Remove</p>'+
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
    //ckeditor
    CKEDITOR.replace( 'editor1', {
            filebrowserUploadUrl: '../upload.php?command=QuickUpload&type=Images&responseType=json',
            filebrowserUploadMethod: "form"

        } );
</script>
