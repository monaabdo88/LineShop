<?php 
//check if product ID from get request
$productId = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
$row = get_row_data('products','id',$productId);
$rowsCount = checkItem('id','products',$productId);
//Check is Product ID is already exists

//Check is Product ID is already exists
if($rowsCount > 0){
?>                
<form class="form-horizontal" action="?do=updateCode" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="user_id" value="<?= $_SESSION['admin_id'] ?>" />
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
                            if($cat['id'] == $row['category_id']) 
                                 $selected = 'selected';
                            else $select = '';
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
                    $product_tags = get_related_data('product_tags','product_id',$row['id']);
                    foreach($product_tags as $pro_tag){
                        //check product tags
                        if($pro_tag['tag_id'] == $tag['id'])
                            $checked = 'checked';
                        else
                            $checked = '';
                    }
                    ?>
                    <input type="checkbox" name="tag[]" value="<?=$tag['id']?>" <?=$checked?>> <?=$tag['title']?>
                </div>
            <?php endforeach //end tags foreach?>
        </div>
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
<script type="text/javascript">
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        //ckeditor
        CKEDITOR.replace( 'editor1', {
            customConfig: 'config.js'
        } );
</script>
