$('.button_fav').click(function(e) {
    //getting current element which is clicked
    var button = $(this);
     e.preventDefault();
    $.getJSON('includes/helpers.php', {
        user_id: $(this).attr('data-user-id'),
        p_id: $(this).attr('data-product-id'),
        method: $(this).attr('data-method'),
        price: $(this).attr('data-price'),
        quantity:$(this).attr('data-quantity'),
        action:'add_to_fav'
      })
      .done(function(json) {
        switch (json.feedback) {
          case 'Like':
            button.attr('data-method', 'Unlike');
            button.html('<i class="mi mi_sml text-danger" id="' + json.id + '"></i>Remove From Favorite').toggleClass('button mybtn'); // Replace the image with the liked button
            break;
          case 'Unlike':
            button.html('<i class="mi mi_sml" id="' + json.id + '"></i>Add To Favorite').toggleClass('mybtn button');
            button.attr('data-method', 'Like');
            break;
          case 'Fail':
            console.log('The Favorite setting could not be changed.');
            break;
        }
      })
      .fail(function(jqXHR, textStatus, error) {
        //console.log("Error Changing Favorite: " + error);
      });
  });
        //remove from cart list in header
        $(".remove_cart").click(function(e){
          var cart = $(this);
          var orders_total = $("input[name=cart_total]").val();
          //console.log('this is total : '+orders_total);
          e.preventDefault();
          $.getJSON('includes/helpers.php', {
              user_id: $(this).attr('data-user-id'),
              p_id: $(this).attr('data-product-id'),
              method: $(this).attr('data-method'),
              price: $(this).attr('data-price'),
              action:'add_to_cart'
              })
              .done(function(json) {
              switch (json.feedback) {
                  case 'delCart':
                      $('#btn-'+json.id).html('<i class="mi mi_sml" id="' + json.id + '"></i>Add To Cart').toggleClass('mybtn button');
                      $('#btn-'+json.id).attr('data-method', 'addCart');
                      $(".total-count").text(json.items_count);
                      $("#"+json.id).remove();
                      $('.total-amount').html("$ "+ json.total);
                      $('.pro_quantity').html(json.quantity);
                  break;
                  case 'Fail':
                      console.log('The Cart setting could not be changed.');
                      $(".total-count").text(json.items_count);
                  break;
              }
              })
              .fail(function(jqXHR, textStatus, error) {
              //console.log("Error Changing Cart: " + error);
              });
      });
      //Add to cart ajax code
      $('.button_cart').click(function(e) {
          //getting current element which is clicked
          var button = $(this);
          var orders_total = $("input[name=cart_total]").val();
          //console.log('this is total : '+orders_total);
          e.preventDefault();
          $.getJSON('includes/helpers.php', {
              user_id: $(this).attr('data-user-id'),
              p_id: $(this).attr('data-product-id'),
              method: $(this).attr('data-method'),
              price: $(this).attr('data-price'),
              action:'add_to_cart'
              })
              .done(function(json) {
              switch (json.feedback) {
                  case 'addCart':
                      button.attr('data-method', 'delCart');
                      button.html('<i class="mi mi_sml text-danger" id="' + json.id + '"></i>Remove From Cart').toggleClass('button mybtn'); // Replace the image with the liked button
                      $(".total-count").text(json.items_count);
                      $(".shopping-list").append(json.product_data);
                      $('.total-amount').html("$ "+ json.total);
                      $('.pro_quantity').html(json.quantity);
                
                  break;
                  case 'delCart':
                      button.html('<i class="mi mi_sml" id="' + json.id + '"></i>Add To Cart').toggleClass('mybtn button');
                      button.attr('data-method', 'addCart');
                      $(".total-count").text(json.items_count);
                      $("#"+json.id).remove();
                      $('.total-amount').html("$ "+ json.total);
                      $('.pro_quantity').html(json.quantity);
                
                  break;
                  case 'Fail':
                      console.log('The Cart setting could not be changed.');
                      $(".total-count").text(json.items_count);
                  break;
              }
              })
              .fail(function(jqXHR, textStatus, error) {
              //console.log("Error Changing Cart: " + error);
              });
      });
      //add comment ajax code
      $('.submit_comment').click(function(e) {
          //getting current element which is clicked
          var button = $(this);
          e.preventDefault();
          $.getJSON('includes/helpers.php', {
              user_id: $(this).attr('data-user-id'),
              p_id: $(this).attr('data-product-id'),
              })
              .done(function(json) {
              switch (json.feedback) {
                  case 'addCart':
                  button.attr('data-method', 'delCart');
                  button.html('<i class="mi mi_sml text-danger" id="' + json.id + '"></i>Remove From Cart').toggleClass('button mybtn'); // Replace the image with the liked button
                  break;
                  case 'delCart':
                  button.html('<i class="mi mi_sml" id="' + json.id + '"></i>Add To Cart').toggleClass('mybtn button');
                  button.attr('data-method', 'addCart');
                  break;
                  case 'Fail':
                  console.log('The Cart setting could not be changed.');
                  break;
              }
              
              })
              .fail(function(jqXHR, textStatus, error) {
              //console.log("Error Changing Cart: " + error);
              });
      });
