                 <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="user_id" value="<?= $_SESSION['admin_id'] ?>" />
                                    <!-- Start User Name Field -->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-2 control-label">User Name</label>
                                        <div class="col-sm-10 col-md-12">
                                            <input type="text" name="user_name" class="form-control" required="required" />
                                        </div>
                                    </div>
                                    <!-- End  username  Field -->
                                    <!-- Start User Email Field -->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-2 control-label">User Email</label>
                                        <div class="col-sm-10 col-md-12">
                                            <input type="email" name="email" class="form-control" required="required" />
                                        </div>
                                    </div>
                                    <!-- End  User Name  Field -->
                                    <!-- Start User Password Field -->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-2 control-label">User Password</label>
                                        <div class="col-sm-10 col-md-12">
                                            <input type="password" name="password" class="form-control" required="required" />
                                        </div>
                                    </div>
                                    <!-- End  User Password  Field -->
                                    <!-- Start User phone Field -->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-2 control-label">User Phone</label>
                                        <div class="col-sm-10 col-md-12">
                                            <input type="text" name="phone" class="form-control" required="required" />
                                        </div>
                                    </div>
                                    <!-- End  User phone  Field -->
                                    <!-- Start User Status Field -->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-2 control-label">User Status</label>
                                        <div class="col-sm-10 col-md-12">
                                            <input type="radio" name="status" value="0"> Not Atcive
                                            <input type="radio" name="status" value="1"> Active
                                        </div>
                                    </div>
                                    <!-- End  User Status  Field -->
                                    <!-- Start User Trusted Field -->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-2 control-label">User Trusted</label>
                                        <div class="col-sm-10 col-md-12">
                                            <input type="radio" name="trust_user" value="0"> Not Truseted
                                            <input type="radio" name="trust_user" value="1"> Trusted
                                        </div>
                                    </div>
                                    <!-- End  User Trusted  Field -->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-2 control-label">Country</label>
                                        <div class="col-sm-10 col-md-12">
                                            <select class="form-control" name="country_id" id="country-dropdown">
                                                <option value="">Select Country</option>
                                                <?php 
                                                $countries = get_rows('countries');
                                                foreach($countries as $country):
                                                    echo '<option value='.$country['id'].'>'.$country['name'].'</option>';
                                                endforeach;
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                    <label class="col-sm-2 control-label">State</label>
                                        <div class="col-sm-10 col-md-12">
                                            <select name="state_id" class="form-control" id="state-dropdown">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                    <label class="col-sm-2 control-label">City</label>
                                        <div class="col-sm-10 col-md-12">
                                            <select name="city_id" class="form-control" id="city-dropdown">
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Start  Role  Field -->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-2 control-label">Role </label>
                                        <div class="col-sm-10 col-md-12">
                                            <select name="role_id" class="form-control">
                                                <?php foreach(get_rows('roles ') as $role): ?>
                                                    <option value="<?=$role['id']?>"> <?=$role['role_name']?></option>
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
                                        <img id="preview" src="#" style="display:none;" class="img-thumbnail img-responsive" />
                                        <br/><br>
                                    </div>
                                    <!-- Start Submit Field -->
                                    <div class="clearfix"></div>
                                    <div class="col-md-12">
                                        <input type="submit" value="Save" class="btn btn-primary btn-block btn-lg" />
                                        <br>
                                    </div>
                                    
                                    <!-- End Submit Field -->
                                </form>
<!---- preview image before upload code ----->
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

