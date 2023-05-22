<?php
include "init.php"; 
include $tpl."header.php";
?>
<!-- Shopping Cart -->
<div class="shopping-cart section">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<!-- Shopping Summery -->
					<table class="table shopping-summery">
						<thead>
							<tr class="main-hading">
								<th>PRODUCT</th>
								<th>NAME</th>
								<th class="text-center">UNIT PRICE</th>
								<th class="text-center">QUANTITY</th>
								<th class="text-center">TOTAL</th> 
								<th class="text-center"><i class="ti-trash remove-icon"></i></th>
							</tr>
						</thead>
						<tbody>
                        <?php 
										//get the cart items
										$order_products = get_all_rows_data('orders','user_id',$_SESSION['user_id']);
										$total = 0;
										foreach($order_products as $order_pro):
											$pros = get_all_rows_data('products','id',$order_pro['product_id']);
											foreach($pros as $pro):
												if($pro['discount'] != 0)
													$price_after_discount = price_after_discount($pro['price'], $pro['discount']);
												else
													$price_after_discount = $pro['price'];
												$total  = get_orders_total($_SESSION['user_id']);
												echo'
												<tr id="'.$pro['id'].'">';
													$img_name = get_item('file_name','files','product_id',$pro['id']);
													$img_dir = get_item('file_dir','files','product_id',$pro['id']);
													echo'
													
                                                    <td class="image" data-title="No"><img src="'.$img_dir.'/'.$img_name.'" alt="#"></a></td>
                                                    <td class="product-des" data-title="Description">
                                                        <p class="product-name"><a href="product?product_id='.$pro['id'].'">'.$pro['title'].'</a></p>
                                                    </td>
                                                    <td class="price" data-title="Price"><span>$'.$price_after_discount.' </span></td>
                                                    <td class="qty" data-title="Qty"><!-- Input Order -->
                                                        <div class="input-group">
                                                            <div class="button minus">
                                                                <button type="button" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
                                                                    <i class="ti-minus"></i>
                                                                </button>
                                                            </div>
                                                            <input type="text" name="quant[1]" class="input-number"  data-min="1" data-max="'.$pro['quantity'].'" value="1">
                                                            <div class="button plus">
                                                                <button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[1]">
                                                                    <i class="ti-plus"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <!--/ End Input Order -->
                                                    </td>
                                                    <td class="total-amount" data-title="Total"><span>$'.$price_after_discount.'</span></td>
                                                    <td class="action" data-title="Remove"><a href="#" class="remove_cart" data-product-id="'.$pro['id'].'" data-user-id="'.$_SESSION['user_id'].'" data-price="'.$price_after_discount.'" data-method="delCart"><i class="ti-trash remove-icon"></i></a></td>
                                                
                                                
                                                    </tr>';
												
											endforeach;
										endforeach;
										?>
										
							
						</tbody>
					</table>
					<!--/ End Shopping Summery -->
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<!-- Total Amount -->
					<div class="total-amount">
						<div class="row">
							<div class="col-lg-8 col-md-5 col-12">
							    <!--<div class="left">
									<div class="coupon">
										<form action="#" target="_blank">
											<input name="Coupon" placeholder="Enter Your Coupon">
											<button class="btn">Apply</button>
										</form>
									</div>
									<div class="checkbox">
										<label class="checkbox-inline" for="2"><input name="news" id="2" type="checkbox"> Shipping (+10$)</label>
									</div>
								</div>-->
							</div>
							<div class="col-lg-4 col-md-7 col-12">
								<div class="right">
									<ul>
										<li>Cart Subtotal<span>$<?=$total?></span></li>
										<li>Shipping<span>Free</span></li>
										<li class="last">You Pay<span>$<?=$total?></span></li>
									</ul>
									<div class="button5">
										<a href="#" class="btn">Checkout</a>
										<a href="allProducts" class="btn">Continue shopping</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--/ End Total Amount -->
				</div>
			</div>
		</div>
	</div>
	<!--/ End Shopping Cart -->
			
<?php 
include $tpl."footer.php";
?>