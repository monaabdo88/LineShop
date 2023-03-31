<?php 
include "init.php"; 
include $tpl."header.php";
$id = intval($_GET['product_id']);
$checkproduct = checkItem('id','products',$id);

if(isset($id) && $checkproduct > 0){
$row = get_row_data('products',$id);
$authorInfo = get_row_data('users',$row['user_id']);
$product_tags = get_all_rows_data('product_tags','product_id',$row['id']);
$cats = get_rows('categories',4);
$recent_products = get_rows('products',5);
$recent_tags = get_rows('tags',5,1);
$views = up_views($row['id']);
?>
	<!-- Breadcrumbs -->
    <div class="breadcrumbs">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="bread-inner">
							<ul class="bread-list">
								<li><a href="index">Home</a></li>
								<?=get_cat_parent($row['category_id'])?>
								<li class="active"><i class="ti-arrow-right"></i> <a href="#"><?=$row['title']?></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- End Breadcrumbs -->
			
		<!-- Start Blog Single -->
		<section class="blog-single section">
			<div class="container">
				<div class="row">
					<div class="col-lg-8 col-12">
						<div class="blog-single-main">
							<div class="row">
								<div class="col-md-12 expand-img">

								    <!----- product Images Slider ----------->
								
								   <div class="exzoom hidden" id="exzoom">
                                    <div class="exzoom_img_box">
                                        <ul class='exzoom_img_ul'>
                                                <?php 
												//show product images
            									    $images = get_row_data('files',$row['id'],'product_id');
            									    foreach($images as $img):
            									        echo'<li><img src="assets/uploads/products/'.$img['file_name'].'"></li>';
            									    endforeach  
        									    ?>
                                            </ul>
                                        </div>
                                        <div class="exzoom_nav"></div>
                                        <p class="exzoom_btn">
                                            <a href="javascript:void(0);" class="exzoom_prev_btn"> < </a>
                                            <a href="javascript:void(0);" class="exzoom_next_btn"> > </a>
                                        </p>
                                    </div>
                                    <!------------------------------------------->
								    
									<div class="blog-detail">
										<h2 class="blog-title"><?=$row['title']?></h2>
										<div class="blog-meta">
											<span class="author">
												<i class="fa fa-user"></i>By
												<a href="userProducts?user_id=<?=$row['user_id']?>">
													<?=$authorInfo['username']?>
												</a>
												<a href="#">
													<i class="fa fa-calendar"></i><?=$row['created_at']?>
												</a>
												<a href="#">
													<i class="fa fa-comments"></i>Comment (<?=get_data_column_count('comments','product_id',$row['id'])?>)
												</a>
												<?php if(isset($_SESSION['user_id']) && $row['user_id'] != $_SESSION['user_id']): ?>
													<a href="#" data-toggle="modal" data-target="#exampleModalCenter">
														<i class="fa fa-envelope"></i> Send Message
													</a>
													<!-- Modal -->
													<div class="col-md-8 offset-md-4">
														<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
														<div class="modal-dialog modal-dialog-centered" role="document">
															<div class="modal-content">
																<div class="modal-header">
																	<!--<h5 class="modal-title text-center" id="exampleModalLongTitle">Modal title</h5>-->
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																		<span aria-hidden="true">&times;</span>
																	</button>
																</div>
																<div class="clearfix"></div>
																<div class="modal-body">
																	<div class="col-12">			
																			<div class="reply">
																				<div class="reply-head">
																					<!-- Comment Form -->
																					<form class="form" id="myForm" action="#" method="post">
																						<div class="row">
																							<div class="col-md-12">
																								<div class="msg_status"></div>
																							</div>	
																							<div class="col-lg-6 col-md-6 col-12">
																								<div class="form-group">
																									<label>Your Name<span>*</span></label>
																									<input type="text" name="name" id="senderName" placeholder="" >
																									<span class="error text-danger" id="name-error"></span>
																								</div>
																							</div>
																							<div class="col-lg-6 col-md-6 col-12">
																								<div class="form-group">
																									<label>Your Email<span>*</span></label>
																									<input type="email" name="email" id="senderEmail" placeholder="">
																									<span class="error text-danger" id="email-error"></span>
																								</div>
																							</div>
																							<div class="col-lg-12">
																								<div class="form-group">
																									<label>Your Message Subject<span>*</span></label>
																									<input type="text" name="msgSubject" id="msgSubject" placeholder="">
																									<span class="error text-danger" id="subject-error"></span>
																								</div>
																							</div>
																							<div class="col-12">
																								<div class="form-group">
																									<label>Your Message<span>*</span></label>

																									<textarea name="message" id="senderMsg" placeholder="" ></textarea>
																									<span class="error text-danger" id="msg-error"></span>
																								</div>
																							</div>
																							<div class="col-12">
																								<div class="form-group button">
																								<input type="hidden" name="user_id" value="<?=$_SESSION['user_id']?>" />
																								<input type="hidden" name="product_id" value="<?=$row['id']?>"/>
																								<input type="hidden" name="author" value="<?=$row['user_id']?>" />
																								<input type="hidden" name="method" value="send_product_msg" />
																									<button type="submit" class="btn submit_msg">Send</button>
																								</div>
																							</div>
																						</div>
																					</form>
																					<!-- End Comment Form -->
																				</div>
																			</div>			
																		</div>	
																	
																</div>
																<div class="clearfix"></div>
																<!--<div class="modal-footer">
																	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
																	<button type="button" class="btn btn-primary">Save changes</button>
																</div>-->
															</div>
														</div>
														</div>
													</div>
													
												<?php endif; ?>
												<?php if(isset($_SESSION['user_id']) && $row['user_id'] == $_SESSION['user_id']): ?>
													<a href="#">
														<i class="fa fa-pencil"></i> Edit
													</a>
												<?php endif?>
											</span>
										</div>
										<div class="content">
											<div class="d-inline p-2 bg-warning text-black" style="margin-right:2px"><b>Price: </b>
												<?php
													if($row['discount'] != 0) 
														echo'<strike>'.$row['price'].'$</strike>';
													else
														echo $row['price'].'$';
													
													?>
											</div>
											
											<?php if($row['discount'] != 0): ?>
												<div class="d-inline p-2 bg-warning text-black"><b>Discount: </b><?=$row['discount']?>%</div>
												<div class="d-inline p-2 bg-warning text-black" style="margin-right:2px"><b>Price After discount: </b>
													<?=price_after_discount($row['price'],$row['discount']).'$';?>
												</div>
											<?php endif; ?>
											<div class="d-inline p-2 bg-warning text-black"><b>Quantity: </b><span class="pro_quantity"><?=($row['quantity'] > 0) ? $row['quantity']:'out of stock'?></span></div>
											
											<br><br>
											<?=$row['details']?>
										</div>
										<?php
											//check if user is logged in and diffrent than the product author 
											if(isset($_SESSION['user_id']) && $_SESSION['user_id'] != $row['user_id']): ?>
										    <br>
										    <br>
    										<div class="float-right" id="fav_container">
    										    <?php 
												//check if this product is not in user favs list
												check_fav($row['id'],$_SESSION['user_id'],$row['price'],$row['quantity']);
												//check if the product in user cart
												check_cart($row['id'],$_SESSION['user_id'],$row['price'],$row['quantity']);
												?>
										
    										</div>
    										<br><br>
											<?php 
												endif; 
											?>
										
									</div>
									<div class="share-social">
										<div class="row">
											<div class="col-6 float-left">
												<div class="content-tags">
													<h4>Tags:</h4>
													<ul class="tag-inner">
													    <?php foreach($product_tags as $tag): 
													            $tagDetails = get_all_rows_data('tags','id',$tag['tag_id']);
													            foreach($tagDetails as $tagInfo):
													            
													        ?>
													            <li><a href="tagProducts?tag_id=<?=$tagInfo['id']?>"><?=$tagInfo['title']?></a></li>
													    <?php 
													        endforeach;
													    endforeach; 
													    ?>
														
													</ul>
												</div>
											</div>
											<div class="col-6 float-right">
												<div class="content-tags">
													<ul class="tag-inner">
														<li><a href="http://www.facebook.com/share.php?u=<?=$base_url.'product?product_id='.$row['id'];?>&title=<?=$row['title']?>" class="social_link"><i class="fa fa-facebook"></i></a></li>
														<li><a href="https://twitter.com/intent/tweet?text=<?=$base_url.'product?product_id='.$row['id'];?>&title=<?=$row['title']?>" class="social_link"><i class="fa fa-twitter"></i></a></li>
														<li><a href="http://www.reddit.com/submit?url=<?=$base_url.'product?product_id='.$row['id'];?>&title=<?=$row['title']?>" class="social_link"><i class="fa fa-reddit"></i></a></li>
														<li><a href="http://pinterest.com/pin/create/button/?url=<?=$base_url.'product?product_id='.$row['id'];?>&title=<?=$row['title']?>" class="social_link"><i class="fa fa-pinterest"></i></a></li>
													</ul>
												</div>
												
												
											</div>
										</div>
									</div>
								</div>
								<div class="col-12">
									<div class="comments">
										<h3 class="comment-title">Comments <span class="comments_count">(<?=get_data_column_count('comments','product_id',$row['id'])?>)</span></h3>
										<!-- Single Comment -->
										<?php 
											$comments = get_all_rows_data('comments','product_id',$row['id']);
											foreach($comments as $comment):
										?>
										<div class="single-comment">
											<?php 
												$user_data = get_row_data('users',$comment['user_id']);
												echo '<h6>'.$user_data['username'].'</h6><img src="assets/uploads/users/'.$user_data['avatar'].'" alt="#">';
											?>
											
											<div class="content">
												<h4><?=$comment['created_at']?></h4>
												<p><?=$comment['comment']?></p>
												<!--<div class="button">
													<a href="#" class="btn"><i class="fa fa-reply" aria-hidden="true"></i>Reply</a>
												</div>-->
											</div>
										</div>
										<!-- End Single Comment -->
										
										<?php endforeach; ?>
									</div>									
								</div>											
								<?php if(isset($_SESSION['user_id']) && $_SESSION['user_id'] != $row['user_id']): ?>
								<div class="col-12">			
									<div class="reply">
										<div class="reply-head">
											<h2 class="reply-title">Leave a Comment</h2>
											<!-- Comment Form -->
											<form id="add_comment" action="#" method="post">
												<div class="row">
													<div class="col-md-12" id="success_add"></div>
													<!--<div class="col-lg-6 col-md-6 col-12">
														<div class="form-group">
															<label>Your Name<span>*</span></label>
															<input type="text" name="name" placeholder="" required="required">
														</div>
													</div>
													<div class="col-lg-6 col-md-6 col-12">
														<div class="form-group">
															<label>Your Email<span>*</span></label>
															<input type="email" name="email" placeholder="" required="required">
														</div>
													</div>-->
													<input type="hidden" name="user_id" value="<?=$_SESSION['user_id']?>" />
													<input type="hidden" name="product_id" id="product_comment" value="<?=$row['id']?>"/>
													<input type="hidden" name="comment_method" value="add_comment"/>
													<div class="col-12">
														<div class="form-group">
															<label>Your Comment<span>*</span></label>
															<textarea name="comment" class="user_comment" placeholder="" required></textarea>
															<span class="error text-danger" id="comment-error"></span>
																								
														</div>
													</div>
													<div class="col-12">
														<div class="form-group button">
															<button type="submit" class="btn submit_comment">Post comment</button>
														</div>
													</div>
												</div>
											</form>
											<!-- End Comment Form -->
										</div>
									</div>			
								</div>	
								<?php endif; ?>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-12">
						<div class="main-sidebar">
							<!-- Single Widget -->
							<div class="single-widget search">
								<div class="form">
								    <form action="searchresult" method="get">
								    <input type="text" name="search_key" placeholder="Search Here...">
									<button type="submit" class="button"><i class="fa fa-search"></i></a>    
								    </form>
									
								</div>
							</div>
							<!--/ End Single Widget -->
							<!-- Single Widget -->
							<div class="single-widget category">
								<h3 class="title">Categories</h3>
								<ul class="categor-list">
								    <?php 
								        foreach($cats as $cat):
								            echo '<li><a href="category?category_id='.$cat['id'].'">'.$cat['name'].'</a></li>';
								        endforeach;
								    ?>
								
								</ul>
							</div>
							<!--/ End Single Widget -->
							<!-- Single Widget -->
							<div class="single-widget recent-post">
								<h3 class="title">Recent post</h3>
								<?php 
								    foreach($recent_products as $pro): 
								        if($pro['id'] != $id):
								?>
    								<!-- Single Post -->
    								<div class="single-post">
    									<div class="image">
    									    <?php 
											$images = get_all_rows_data('files','product_id',$pro['id'],1);
												foreach($images as $img):
											?>
												<img class="default-img" width="100%" height="100" src="assets/uploads/products/<?=$img['file_name']?>" alt="#">
											<?php endforeach; ?>
    										
    									</div>
    									<div class="content">
    										<h5><a href="product?product_id=<?=$pro['id']?>"><?=$pro['title']?></a></h5>
    										<ul class="comment">
    											<li><i class="fa fa-calendar" aria-hidden="true"></i><?=$pro['created_at']?></li>
    											<li><i class="fa fa-commenting-o" aria-hidden="true"></i><?=get_data_column_count('comments','product_id',$pro['id'])?></li>
    										</ul>
    									</div>
    								</div>
    								<!-- End Single Post -->
								<?php
								        endif;
								    endforeach;
								?>
								
								
							</div>
							<!--/ End Single Widget -->
							<!-- Single Widget -->
							<!--/ End Single Widget -->
							<!-- Single Widget -->
							<div class="single-widget side-tags">
								<h3 class="title">Tags</h3>
								<ul class="tag">
								    <?php 
								        foreach($recent_tags as $tag):
								            echo'<li><a href="tagProducts?tag_id='.$tag['id'].'">'.$tag['title'].'</a></li>';
								        endforeach;
								    ?>
									
								</ul>
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</section>
		<!--/ End Blog Single -->
			
<?php include $tpl."footer.php";
}else{
	redirectPage('index',1);
}
?>
