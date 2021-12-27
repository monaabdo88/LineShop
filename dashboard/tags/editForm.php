<?php 
//check if category ID from get request
$TagID = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
$row = get_row_data('tags','id',$TagID);
$rowsCount = checkItem('id','tags',$TagID);
//Check is category ID is already exists
if($rowsCount > 0){
?>                
<form class="form-horizontal" action="?do=updateCode" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="user_id" value="<?= $_SESSION['admin_id'] ?>" />
    <input type="hidden" name="tagID" value="<?= $row['id']?>" />
    <!-- Start Tag title Field -->
    <div class="form-group form-group-lg">
        <label class="col-sm-2 control-label">Tag title</label>
        <div class="col-sm-10 col-md-12">
            <input type="text" name="title" class="form-control" value="<?=$row['title']?>"  required="required" />
        </div>
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
                errorFn("This Tag is Not Found","error");

            });
            
        </script>';
        redirectPage('tags.php');
    }
    ?>