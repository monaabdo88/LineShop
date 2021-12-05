<?php 
//check if category ID from get request
$catId = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
$row = get_row_data('categories',$catId);
$rowsCount = checkItem('id','categories',$catId);
//Check is category ID is already exists
if($rowsCount > 0){
?>                
<form class="form-horizontal" action="?do=updateCode" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="user_id" value="<?= $_SESSION['admin_id'] ?>" />
    <!-- Start Category name Field -->
    <div class="form-group form-group-lg">
        <label class="col-sm-2 control-label">Category Name</label>
        <div class="col-sm-10 col-md-12">
            <input type="text" name="name" class="form-control" value="<?=$row['name']?>"  required="required" />
        </div>
    </div>
                                    
    <!-- Start Category description Field -->
    <div class="form-group form-group-lg">
        <label class="col-sm-2 control-label">Cateogry Description</label>
        <div class="col-sm-10 col-md-12">
            <textarea class="form-control" name="description"><?=$row['description']?></textarea>
        </div>
    </div>
    <!-- End Category description Field -->
 
    <!-- Start Category status Field -->
    <div class="form-group form-group-lg">
        <label class="col-sm-2 control-label">Cateogry Status</label>
        <div class="col-sm-10 col-md-12">
            <input type="radio" name="status" value="0" <?=($row['status'] == '0')? 'checked':''?>/> Not Active 
            <input type="radio" name="status" value="1" <?=($row['status'] == '1') ? 'checked':''?>/> Active
        </div>
    </div>
    <!-- End Category status Field -->
    <!-- Start Parent Category Field -->
    <div class="form-group form-group-lg">
    <label class="col-sm-2 control-label">Parent Cateogry</label>
    <div class="col-sm-10 col-md-12">
        <select class="form-control" name="parent_id">
        <option value="">Choose Parent Category</option>
                                                    
            <?php
            foreach(fetchCategoryTree() as $cat){
                if($cat['id'] == $row['id'] && $row['parent_id'] !=0)
                    $select = "selected";
                else
                    $select = "";
            echo '<option value="'.$cat['id'].'" '.$select.'>'.$cat['name'].'</option>';
            }
                                                                
            ?>
        </select>
    </div>
    </div>
    <!-- End Parent Category Field -->
    <!-- Start Category Image Field -->
    <div class="form-group form-group-lg">
    <label class="col-sm-2 control-label">Category Image</label>
    <div class="col-sm-10 col-md-12">
        <input type="file" name="image" onchange="readURL(this);" class="form-control" />
        <input type="hidden" name="oldImg" value="<?=$row['image']?>"/>
        <input type="hidden" name="catID" value="<?=$row['id']?>" />
    </div>
    </div>
    <!-- End Category logo Field -->
    <!---- Category logo preview ----->
    <div class="col-md-6 col-md-offset-3">
        <?php if($row['image']){ ?>
            <img id="preview" src="../assets/uploads/categories/<?=$row['image']?>" class="img-thumbnail img-responsive" />
        <?php  }?>
        <br/><br>
    </div>
                                        
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
                errorFn("This Category is Not Found","error");

            });
            
        </script>';
        redirectPage('categories.php');
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
</script>
