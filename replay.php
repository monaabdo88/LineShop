<?php 
include "init.php"; 
include $tpl."header.php";
include "includes/functions/users.php";
$id = intval($_GET['replay_id']);
$checkMsg = checkItem('id','messages',$id);
$user_id = $_SESSION['user_id'];
//check session & message
if(isset($user_id) && isset($id) && $checkMsg > 0 ):
	$row = get_row_data('messages',$id);
	//check the user permission
	if($user_id == $row['sender_id'] || $user_id == $row['user_id']):
    	$sender_name = get_row_data('users',$row['sender_id']);
?>
	<!-- Breadcrumbs -->
    <div class="breadcrumbs">
			<div class="container">
				<div class="row">
					<div class="col-12">
							
						<div class="bread-inner">
							<ul class="bread-list">
								<li><a href="index">Home<i class="ti-arrow-right"></i></a></li>
								<li><a href="messages?type=inbox">Inbox Messages<i class="ti-arrow-right"></i></a></li>
								
                                <li class="active"><a href="#"><?=$row['title']?></a></li>
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
							
								
                                   <div class="blog-single-main">
                                        <div class="row">
                                            <div class="col-12">
                                                
                                                <div class="blog-detail">
                                                    <p><b>Message Subject : </b><?=$row['title']?></p>
                                                    <br>
                                                    <p><b>From: </b><?=$sender_name['username']?></p>
                                                    <br>
                                                    <div class="content">
                                                       <p><b>Message: </b><?=$row['message']?></p>
													   
                                                    </div>
                                                </div>
                                                
                                            </div>
                                                                                
                                            
                                        </div>
                                    </div>
									<hr>
									<?php 
									if($_SESSION['user_id'] != $row['sender_id']):
										 include ("includes/templates/replay_msg.php");
									endif;
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
								
							</div>
						</div>
						<div class="col-lg-3 col-12">
						
							<div class="single-head profile-list">
								<div class="single-info">
									
									<ul class="list-group">
										<li class="list-group-item"><a href="profile">Edit Profile</a></li>
										<li class="list-group-item"><a href="myProducts">Products</a></li>
										<li class="list-group-item"><a href="favs">Favs</a></li>
										<li class="list-group-item active"><a href="messages?type=inbox">Inbox Messages</a></li>
										<li class="list-group-item"><a href="messages?type=send">Send Messages</a></li>
										<li class="list-group-item"><a href="orders">Orders</a></li>
									</ul>
								</div>
								
							</div>
						</div>
					</div>
				</div>
			</div>

	</section>
	<!--/ End Contact -->

    
<?php include $tpl."footer.php";
	else:
		redirectPage('index.php');
	endif;
	//end main if
endif;
?>