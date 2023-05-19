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
                      $("tr#"+json.id).remove();
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
      //validate code for sending message in product
      $(document).ready(function() {
        $("#myForm").submit(function(event) {
          event.preventDefault();
          //var senderName = $("#senderName").val();
          var senderMsg  = $("#senderMsg").val();
          //var senderEmail = $("#senderEmail").val();
          var author = $("input[name=author]").val();
          var user  = $("input[name=user_id]").val();
          var method = $("input[name=method]").val();
          var product_id = $("input[name=product_id]").val();
          var msg_sub = $("#msgSubject").val();
          //if form is valid submit
         // if(senderName.length > 3 && isValidEmail(senderEmail) && senderMsg.length > 10)
         if(senderMsg.length > 10)
          {
              $(".error").text("");
              //$(".submit_msg").text('Sending ...').attr("disabled", true);
              //send message ajax code
              $.getJSON('includes/helpers.php', {
                    /*sender_name:senderName,
                    sender_email:senderEmail,*/
                    sender_msg:senderMsg,
                    p_author:author,
                    user_id:user,
                    action:method,
                    p_id:product_id,
                    subject:msg_sub
                })
                .done(function(json) {
                  $(".msg_status").html('<div class="alert alert-success"><p class="text-center">'+json.callback_msg+'</p></div>');
                  setTimeout(function(){// wait for 5 secs(2)
                    $('#exampleModalCenter').modal('hide');; // then reload the page.(3)
                    
                  }, 5000);
                  
                })
                .fail(function(jqXHR, textStatus, error) {
                  console.log("Error : " + error);         
                });
          }
          else{
            //validate email
            /*if (senderEmail== '' || !isValidEmail(senderEmail)) {
              $("#email-error").text("Please enter a valid email address.");
            }
            else{
              $("#email-error").text("");
            }*/
            //validate message subject
            if(msg_sub == '' || msg_sub.length < 3){
                $("#subject-error").text("Message subject must be at least 3 characters long.");
            }else{
                $("#subject-error").text();
            }
            //validate sender email
            /*if (senderName.length < 3) {
              $("#name-error").text("Name must be at least 3 characters long.");
            }else{
              $("#name-error").text("");
            } */
            //validate sender message
            if(senderMsg.length < 10)
            {
              $("#msg-error").text('Your Message must be at least 10 characters long.');
            }
            else{
              $("#msg-error").text("");
            }
          }
                   
        });
         //validate email
      
      function isValidEmail(email) {
        var emailPattern = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        return emailPattern.test(email);
      }//clear all data after close the modal
      $('#exampleModalCenter').on('hidden.bs.modal', function (e) {
        $(this)
          .find("input,textarea")
             .val('')
             .end()
        $(".msg_status").html("");
        $(".error").text("");
          
      });
      });
     
      //submit user comment
      $(".submit_comment").click(function(e) {
        e.preventDefault();
        var comment = $(".user_comment").val();
        var user  = $("input[name=user_id]").val();
        var method = $("input[name=comment_method]").val();
        var product_id = $("#product_comment").val();
        //validate comment
        if(comment != '' && comment.length > 10)
        {
            //add comment code
            $(".error").text("");
              $.getJSON('includes/helpers.php', {
                    user_id:user,
                    action:method,
                    p_id:product_id,
                    comment:comment
                })
                .done(function(json) {
                  $("#success_add").html('<div class="alert alert-success"><p class="text-center">'+json.callback_msg+'</p></div>');
                  setTimeout(function(){// wait for 5 secs(2)
                    location.reload(); // then reload the page.(3)
                  }, 5000); 
                })
                .fail(function(jqXHR, textStatus, error) {
                  console.log("Error : " + error);         
                });
        }else{
          if(comment.length < 10)
          {
            $("#comment-error").text('Your Comment must be at least 10 characters long.');
          }
          else{
            $("#comment-error").text("");
          }
        }
        
    });
    
    
