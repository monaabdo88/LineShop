<?php 
//check if role ID from get request
$roleId = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
$row = get_row_data('roles',$roleId);
$rowsCount = checkItem('id','roles',$roleId);
//Check is role ID is already exists

//Check is role ID is already exists
if($rowsCount > 0){
?>                
<form class="form-horizontal" action="?do=updateCode" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="user_id" value="<?= $_SESSION['admin_id'] ?>" />
    <input type="hidden" name="role_id" value="<?= $row['id']?>" />

    <!-- Start role name Field -->
    <div class="form-group form-group-lg">
        <label class="col-sm-2 control-label">Role Name</label>
        <div class="col-sm-10 col-md-12">
            <input type="text" name="role_name" class="form-control" value="<?=$row['role_name']?>"  required="required" />
        </div>
    </div>                              
     <!-- Start  Permissions Field -->
     <div class="form-group form-group-lg">
        <label class="col-sm-2 control-label">Permissions</label>
           <div class="col-sm-10 col-md-12">
                <?php foreach(get_rows('permissions') as $permission): 
                    $check_permission = check_role_permission($row['id'],$permission['id']);
                    ($check_permission > 0) ? $checked = 'checked' : $checked = '';
                    ?>
                   <div class="col-md-3 float-left">
                        <input type="checkbox" name="permissions[]" value="<?=$permission['id']?>" <?=$checked?>> <?=strtoupper($permission['per_name'])?>
                    </div>
                <?php endforeach ?>
            </div>
            <div class="clearfix"></div>
    </div>
    <!-- End Permissions Field -->                
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
                errorFn("This role is Not Found","error");

            });
            
        </script>';
        redirectPage('roles.php');
    }
    ?>
