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
                                    <!-- Start User phone Field -->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-2 control-label">User Phone</label>
                                        <div class="col-sm-10 col-md-12">
                                            <input type="text" name="phone" class="form-control" value="<?=$row['phone']?>"/>
                                        </div>
                                    </div>
                                    <!-- End  User phone  Field -->
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
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-2 control-label">Country</label>
                                        <div class="col-sm-10 col-md-12">
                                            <select class="form-control" name="country_id" id="country-dropdown">
                                                <?php 
                                                $countries = get_rows('countries');
                                                foreach($countries as $country):
                                                    ($country['id'] == $row['country_id'])? $selected = 'selected' : $selected = '';
                                                    echo '<option value='.$country['id'].' '.$selected.'>'.$country['name'].'</option>';
                                                endforeach;
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                    <label class="col-sm-2 control-label">State</label>
                                        <div class="col-sm-10 col-md-12">
                                            <select name="state_id" class="form-control" id="state-dropdown">
                                                <?php 
                                                if($row['state_id'] != 0)
                                                    echo '<option value="'.$row['state_id'].'">'.get_item('name','states','id',$row['state_id']).'</option>';
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                    <label class="col-sm-2 control-label">City</label>
                                        <div class="col-sm-10 col-md-12">
                                            <select name="city_id" class="form-control" id="city-dropdown">
                                            <?php 
                                                if($row['city_id'] != 0)
                                                    echo '<option value="'.$row['city_id'].'">'.get_item('name','cities','id',$row['city_id']).'</option>';
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    
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
<script>
$(document).ready(function() {
    $('#country-dropdown').on('change', function() {
            var country_id = this.value;
            $.ajax({
                url: "getStates.php",
                type: "POST",
                data: {
                    country_id: country_id
                },
                cache: false,
                success: function(result){
                    $("#state-dropdown").html(result);
                    $('#city-dropdown').html('<option value="">Select State First</option>'); 
                    console.log("this is "+ result);
                }
            }); 
    });    
    $('#state-dropdown').on('change', function() {
            var state_id = this.value;
            $.ajax({
                url: "getCities.php",
                type: "POST",
                data: {
                    state_id: state_id
                },
                cache: false,
                success: function(result){
                    $("#city-dropdown").html(result);
                }
            }); 
    });
});
</script>
