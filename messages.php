<?php 
include_once "init.php"; 
include_once $tpl."header.php";
$user_id = $_SESSION['user_id'];
$do = isset($_GET['do']) ? $_GET['do'] : '';
$type = isset($_GET['type']) ? $_GET['type'] : '';
$file = "users/server_index_msg.php?user_id=$user_id&type=$type";
if(isset($user_id)){
  include_once "dashboard/includes/functions/products.php";

    $user = get_row_data('users',$user_id);
    $messages = get_all_rows_data('messages','user_id',$user_id);
    //delete Message
    if($do == 'delMsg'){
      delete_record('messages');
    }
    else
    {
      //delete All products code
      if($do == 'deleteAll')
          delete_all_rows();
    }
?>
<!-- Breadcrumbs -->
<div class="breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="bread-inner">
						<ul class="bread-list">
							<li><a href="index">Home<i class="ti-arrow-right"></i></a></li>
              <li><a href="profile">Profile <i class="ti-arrow-right"></i></a></li>
							<li class="active"><?=($type == 'inbox') ? 'Inbox' : 'Send'?></li>
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
									<h4><?=$user['username']?> Messages</h4>
									
								</div>
								<table id="example" class="display" style="width:100%">
									<thead>
									<tr>
										<th class="no-sort"><input type="checkbox" class="checkall"/></th>
										<th>#</th>
										<th>Subject</th>
										<th><?=($type == 'inbox')? 'From' : 'To';?></th>
										<th>Message</th>
										<th>Product Name</th>
                    <th>Options</th>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<th><input type="checkbox" class="checkall"/></th>
										<th>#</th>
										<th>Subject</th>
										<th><?=($type == 'inbox')? 'From' : 'To';?></th>
										<th>Message</th>
										<th>Product Name</th>
                    <th>Options</th>
									</tr>
								</tfoot>
								</table>
								<br><br>
								<button onclick="confirmationDel()" class="btn btn-danger btn-non float-right delAll" disabled="disabled">Delete All</button>
							
              
              </div>
						</div>
            <div class="col-lg-3 col-12">
							<div class="single-head profile-list">
								<div class="single-info">
									
									<ul class="list-group">
										<li class="list-group-item"><a href="profile.php?user_id=<?=$user_id?>">Edit Profile</a></li>
										<li class="list-group-item"><a href="myProducts.php">Products</a></li>
										<li class="list-group-item"><a href="favs.php">Favs</a></li>
										<li class="list-group-item <?=($type == 'inbox') ? 'active':''?>"><a href="messages?type=inbox">Inbox Messages</a></li>
										<li class="list-group-item <?=($type == 'send') ? 'active':''?>"><a href="messages?type=send">Send Messages</a></li>
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
    
    include_once $tpl."footer.php";
}else{
    redirectPage('index.php',1);
}
?>
<script type="text/javascript">
          $(document).ready(function() {
            //Show records of products on datatables
			      var user_id = <?=$user_id?>;
            var t = $('#example').DataTable( {
              "columnDefs": [
                  { "orderable": false, "targets": 0 }
                ],
              "processing": true,
              "serverSide": true,
              "targets": 0,
              "ajax": '<?=$file;?>',
              "order": [[ 1, 'asc' ]]
            });
            t.on( 'order.dt search.dt', function () {
                t.column(1, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
              } );
            } ).draw();
          });
           //check box code to
          $(".checkall").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
          });
          //enable delete all if check all checked
          $(".checkall").click(function() {
            $(".delAll").attr("disabled", !this.checked);
          });
          //enable delete all if checkbox checked length greater than 0
          function toggleCheckbox()
          {
            if($("input[name='checkMsg[]']").filter(':checked').length > 0){
              $(".delAll").removeAttr("disabled");
            }else{
              $(".delAll").prop('disabled', true);              
            }
          }
        //Confirm Before delete Product
        function confirmation(ev) {
              ev.preventDefault();
              var urlToRedirect = ev.currentTarget.getAttribute('href'); //use currentTarget because the click may be on the nested i Product and not a Product causing the href to be empty
              console.log(urlToRedirect); // verify if this is the right URL
              swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this imaginary file!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
              })
              .then((willDelete) => {
                // redirect with javascript here as per your logic after showing the alert using the urlToRedirect value
                if (willDelete) {
                  //window.location.href=urlToRedirect;
                  $.ajax({    
                    type: "GET",
                    url: urlToRedirect, 
                    success: function(){   
                      swal("Poof! Your imaginary file has been deleted!", {
                        icon: "success",
                      });     
                      //redirect back after deleting Product 5 seconds
                      setTimeout(function(){
                            window.location.href = 'messages';
                        }, 5000);
                    }
                  });
                } else {
                  swal("Your imaginary file is safe!");
                }
              });
        }
       //Delete All function
       function confirmationDel() {
              var ids_products = new Array(); 
              $("input[name='checkMsg[]']:checked:enabled").each(function () {
                ids_products.push($(this).val());
              });      
              var urlToRedirect = "?do=deleteAll"; 
              swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this imaginary file!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
              })
              .then((willDelete) => {
                // redirect with javascript here as per your logic after showing the alert using the urlToRedirect value
                if (willDelete) {
                  //window.location.href=urlToRedirect;
                  $.ajax({    
                    type: "POST",
                    data :{ids:ids_products,tblname:"messages"},
                    url: urlToRedirect, 
                    success: function(){   
                      swal("Poof! Your imaginary file has been deleted!", {
                        icon: "success",
                      });     
                      //redirect back after deleting Product 5 seconds
                      setTimeout(function(){
                            window.location.href = 'messages';
                        }, 5000);
                    }
                  });
                } else {
                  swal("Your imaginary file is safe!");
                }
              });
        }

        
</script> 