<?php if(isset($_SESSION['user_id']) && $_SESSION['user_id'] != $row['user_id']): ?>
    <div class="button-head">
        <div class="product-action">
			<a data-toggle="modal" data-target="#exampleModal" title="Quick View" href="#"><i class=" ti-eye"></i><span>Quick Shop</span></a>
    	    <?php if(check_product($_SESSION['user_id'], $row['id'],'favs') == 0): ?>
    		<a title="Wishlist" href="#" id="addFavourite" class="button_fav" method="like" product_id="<?=$row['id']?>" user_id="<?=$_SESSION['user_id']?>">
    			<i class=" ti-heart "></i><span>Add to Wishlist</span>
    		</a>
    		<?php else: ?>
    		<a title="Wishlist" href="#" id="addFavourite" class="button_fav" method="unlike" product_id="<?=$row['id']?>" user_id="<?=$_SESSION['user_id']?>">
    			<i class=" ti-heart-broken"></i><span>Remove from Wishlist</span>
    		</a>
    		<?php endif; ?>
    	<a title="Compare" href="#"><i class="ti-bar-chart-alt"></i><span>Add to Compare</span></a>
      </div>
    		<div class="product-action-2">
    			<a title="Add to cart" href="#">Add to cart</a>
    		</div>
    </div>
<?php endif; ?>
<script>

</script>