<div class="col-xl-3 col-lg-4 col-md-4 col-12">
	<div class="single-product">
		<div class="product-img">
			<a href="product?product_id=<?=$product['id']?>">
			<?php 
				$images = get_all_rows_data('files','product_id',$product['id'],1);
				foreach($images as $img):
			?>
				<img class="default-img" width="100%" height="350" src="assets/uploads/products/<?=$img['file_name']?>" alt="#">
			<?php endforeach; ?>
			</a>
			<?php //include $tpl."addToButtons.php"?>
														
		</div>
		<div class="product-content">
			<h3><a href="product?product_id=<?=$product['id']?>"><?= $product['title'] ?></a></h3>
				<div class="product-price">
					<span><?=$product['price']?>$</span>
				</div>
			</div>
	</div>
</div>