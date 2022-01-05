<?php 
//check if Page ID from get request
$PageId = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
$row = get_row_data('pages','id',$PageId);
$rowsCount = checkItem('id','pages',$PageId);
//Check is Page ID is already exists

//Check is Page ID is already exists
if($rowsCount > 0){
?>                
<form class="form-horizontal" action="?do=updateCode" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="user_id" value="<?= $_SESSION['admin_id'] ?>" />
    <input type="hidden" name="page_id" value="<?= $row['id']?>" />

    <!-- Start Page name Field -->
    <div class="form-group form-group-lg">
        <label class="col-sm-2 control-label">Page Title</label>
        <div class="col-sm-10 col-md-12">
            <input type="text" name="title" class="form-control" value="<?=$row['title']?>"  required="required" />
        </div>
    </div>
                                    
    <!-- Start Page description Field -->
    <div class="form-group form-group-lg">
        <label class="col-sm-2 control-label">Page Content</label>
        <div class="col-sm-10 col-md-12">
            <textarea class="form-control" id="editor1" name="content"><?=$row['content']?></textarea>
        </div>
    </div>
    <!-- End Page description Field -->
 
    <!-- Start Page status Field -->
    <div class="form-group form-group-lg">
        <label class="col-sm-2 control-label">Page Status</label>
        <div class="col-sm-10 col-md-12">
            <input type="radio" name="status" value="0" <?=($row['status'] == '0')? 'checked':''?>/> Not Active 
            <input type="radio" name="status" value="1" <?=($row['status'] == '1') ? 'checked':''?>/> Active
        </div>
    </div>
    <!-- End Page status Field -->
        
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
                errorFn("This Page is Not Found","error");

            });
            
        </script>';
        redirectPage('Pages.php');
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
