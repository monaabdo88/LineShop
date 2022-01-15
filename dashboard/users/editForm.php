<?php 
//check if user ID from get request
$userId = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
$row = get_row_data('users','id',$userId);
$rowsCount = checkItem('id','users',$userId);
//Check is user ID is already exists

//Check is user ID is already exists
if($rowsCount > 0){
?>                
<form class="form-horizontal" action="?do=updateCode" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="user_id" value="<?= $_SESSION['admin_id'] ?>" />
    <input type="hidden" name="user_id" value="<?= $row['id']?>" />

    <!-- Start user name Field -->
    <div class="form-group form-group-lg">
        <label class="col-sm-2 control-label">User Name</label>
        <div class="col-sm-10 col-md-12">
            <input type="text" name="user_name" class="form-control" value="<?=$row['username']?>"  required="required" />
        </div>
    </div>
                                    
    <!-- Start User Email Field -->
    <div class="form-group form-group-lg">
        <label class="col-sm-2 control-label">User Email</label>
        <div class="col-sm-10 col-md-12">
            <input type="email" name="email" class="form-control" value="<?=$row['email']?>" required="required" />
        </div>
    </div>
    <!-- End  User Name  Field -->
    <!-- Start User Password Field -->
    <div class="form-group form-group-lg">
        <label class="col-sm-2 control-label">User Password</label>
        <div class="col-sm-10 col-md-12">
            <input type="password" name="password" class="form-control" />
        </div>
    </div>
                                    <!-- End  User Password  Field -->
                                    <!-- Start User Status Field -->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-2 control-label">User Status</label>
                                        <div class="col-sm-10 col-md-12">
                                            <input type="radio" name="status" value="0" <?=($row['status'] == 0) ? 'checked' : ''?>> Not Atcive
                                            <input type="radio" name="status" value="1" <?=($row['status'] == 1) ? 'checked' : ''?>> Active
                                        </div>
                                    </div>
                                    <!-- End  User Status  Field -->
                                    <!-- Start User Trusted Field -->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-2 control-label">User Trusted</label>
                                        <div class="col-sm-10 col-md-12">
                                            <input type="radio" name="trust_user" value="0" <?=($row['trust_user'] == 0) ? 'checked' : ''?>> Not Truseted
                                            <input type="radio" name="trust_user" value="1" <?=($row['trust_user'] == 1) ? 'checked' : ''?>> Trusted
                                        </div>
                                    </div>
                                    <!-- End  User Trusted  Field -->
                                    <!-- Start  Role  Field -->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-2 control-label">Role </label>
                                        <div class="col-sm-10 col-md-12">
                                            <select name="role_id" class="form-control">
                                                <?php foreach(get_rows('roles ') as $role): 
                                                    ($role['id'] == $row['role_id']) ? $selected = 'selected' : $selected = '';
                                                    ?>
                                                    <option value="<?=$role['id']?>" <?=$selected?>> <?=$role['role_name']?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <!-- End Role  Field -->
                                    <!-- Start User Avatar Field -->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-2 control-label">User Avatar</label>
                                        <div class="col-sm-10 col-md-12">
                                            <input type="file" name="avatar" onchange="readURL(this);" class="form-control" />
                                        </div>
                                    </div>
                                    <!-- End site logo Field -->
                                    <!---- site logo preview ----->
                                    <div class="col-md-6 col-md-offset-3">
                                    <?php if($row['avatar']){ ?>
                                        <img id="preview" src="../assets/uploads/users/<?=$row['avatar']?>" class="img-thumbnail img-responsive" />
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
                errorFn("This user is Not Found","error");

            });
            
        </script>';
        redirectPage('users.php');
    }
    ?>
