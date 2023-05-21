	<!-- Start Blog Single -->
		<section class="blog-single section">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="blog-single-main">
							<div class="row">
																		
							<div class="col-12">			
									<div class="reply">
										<div class="reply-head">
											<h4 class="reply-title">Replay to The Message</h4>
											<div class="msg_status"></div>
                                                    
											<!-- Comment Form -->
											<form id="myForm" action="#" method="post">
												<div class="row">
													<div class="col-md-12" id="success_add"></div>
													
													<div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label>Your Message Subject<span>*</span></label>
                                                            <input type="text" value="Replay To : <?=$row['title']?>" disabled name="msgSubject" id="msgSubject" placeholder="">
                                                            <span class="error text-danger" id="subject-error"></span>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Your Message<span>*</span></label>
                                                            <textarea name="message" id="senderMsg" placeholder="" ></textarea>
                                                            <span class="error text-danger" id="msg-error"></span>
                                                        </div>
                                                        </div>
													<div class="col-12">
													        <div class="form-group button">
                                                                <input type="hidden" name="user_id" value="<?=$_SESSION['user_id']?>" />
                                                                <input type="hidden" name="product_id" value="<?=$row['product_id']?>"/>
                                                                <input type="hidden" name="author" value="<?=$row['sender_id']?>" />                                        
                                                                <input type="hidden" name="method" value="send_product_msg" />
                                                                <input type="hidden" name="replay_id" value="<?=$row['id']?>" />
                                                                
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
						</div>
					</div>
				
				</div>
			</div>
		</section>

    