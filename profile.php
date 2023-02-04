<?php 
include "init.php"; 
include $tpl."header.php";
$user_id = $_SESSION['user_id'];
if(!isset($_SESSION['user_id']))
	header("Location: index.php");

if(isset($user_id)){
	include "includes/functions/users.php";
	$user = get_row_data('users',$user_id);

?>

	<!-- Breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="bread-inner">
						<ul class="bread-list">
							<li><a href="index.php">Home<i class="ti-arrow-right"></i></a></li>
							<li class="active"><?=$user['username']?> Profile</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Breadcrumbs -->
  
	<!-- Start Contact -->
	<section id="contact-us" class="contact-us section">
		<div class="container">
				<div class="contact-head">
					<div class="row">
						<div class="col-lg-9 col-12">
							<div class="form-main">
							
								<div class="title">
									<h4>Edit Profile</h4>
								</div>
								<?php 
									if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_user']) && $_POST['edit_user'] == 'save_changes'){
										$errors = edit_user($user_id);
									}
								
									//show error message
									if(isset($errors) && $errors != ''){
										foreach($errors as $key => $value){
											($key == 'error') ? $type = 'danger': $type='success';
											echo '<div class="alert alert-'.$type.' alert-dismissible fade show" role="alert">
											<strong class="text-center">'.$value.'</strong>
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
											</div>';
											if($type == 'success') header('refresh:5;url='.$_SERVER['HTTP_REFERER']);
										}
										
									}
								?>
								<form class="form" action="<?=$_SERVER['PHP_SELF']?>"  method="POST" enctype="multipart/form-data">
									<div class="row">
										<div class="col-lg-6 col-12">
											<div class="form-group">
												<label>Username<span>*</span></label>
												<input name="username" type="text" value="<?=$user['username']?>">
											</div>
										</div>
										<div class="col-lg-6 col-12">
											<div class="form-group">
												<label>Email<span>*</span></label>
												<input name="email" type="email" value="<?=$user['email']?>">
											</div>
										</div>
										<div class="col-lg-6 col-12">
											<div class="form-group">
												<label>Password<span>*</span></label>
												<input name="password" type="password" placeholder="Password">
											</div>	
										</div>
										
										<!-- Start User phone Field -->
										<div class="col-lg-6 col-12">
											<div class="form-group">
												<label>Phone</label>
												<input name="phone" type="text" value="<?=$user['phone']?>">
											</div>	
										</div>
                                    	<!-- End  User phone  Field -->
										<div class="col-lg-6 col-12">
											<div class="form-group">
												<label>Country</label>
												<select class="form-control" name="country_id" id="country-dropdown">
													<option value="">Select Country</option>
													<?php 
													$countries = get_rows('countries');
													foreach($countries as $country):
														($country['id'] == $user['country_id'])? $selected = 'selected': $selected = '';
														echo '<option value='.$country['id'].' '.$selected.'>'.$country['name'].'</option>';
													endforeach;
													?>
												</select>
											</div>	
										</div>
										
										<div class="col-lg-6 col-12">
											<div class="form-group">
										    	<label>State</label>
												<select name="state_id" class="form-control" id="state-dropdown">
													<option value="<?=$user['state_id']?>"><?=get_item('name','states','id',$user['state_id'])?></option>
												</select>
											</div>
										</div>
										<div class="col-lg-6 col-12">
											<div class="form-group">
											<label>City</label>
												<select name="city_id" class="form-control" id="city-dropdown">
												<option value="<?=$user['city_id']?>"><?=get_item('name','cities','id',$user['city_id'])?></option>
												
												</select>
											</div>
										</div>
										<!-- Start User Avatar Field -->
										<div class="col-lg-12 col-12">
											<div class="form-group">
                                        		<label>User Avatar</label>
                                        		<input type="file" class="form-control" name="avatar" onchange="readURL(this);" class="form-control" />
                                        </div>
										</div>
										<!-- End site logo Field -->
										<!---- site logo preview ----->
										<div class="col-md-6 col-md-offset-3">
											<img id="preview" src="assets/uploads/users/<?=$user['avatar']?>" class="img-thumbnail img-responsive" />
											<br/><br>
										</div>
										<div class="col-12">
											<div class="form-group button">
												<button type="submit" class="btn" name="edit_user" value="save_changes">Save Changes</button>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
						<div class="col-lg-3 col-12">
							<div class="single-head profile-list">
								<div class="single-info">
									
									<ul class="list-group">
										<li class="list-group-item active"><a href="profile.php">Edit Profile</a></li>
										<li class="list-group-item"><a href="myProducts.php">Products</a></li>
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
	<!--/ End Contact -->
	
<?php 
    include $tpl."footer.php";
}else{
    redirectPage('index.php',1);
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
// preview image before upload code
function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#preview').attr('src', e.target.result);
                    $('#preview').show();
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
</script>
