<?php 
include "includes/templates/header.php";
include "includes/functions/products.php";
?>
<title><?=get_item('site_name','settings','id',1)?> | <?=get_title_cp('Products');?></title>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><?=get_title_cp('Products');?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Dahboard</a></li>
              <li class="breadcrumb-item active"><?=get_title_cp('Products');?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <?php 
                        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
                        
                        if($do == 'Manage')
                          $pageTitle = 'Products';
                        elseif($do == 'Add' || $do == 'Insert')
                          $pageTitle = 'Add New Product';
                        elseif($do == 'Edit' || $do == 'updateCode')
                          $pageTitle = 'Edit Product';
                        else
                          $pageTitle = 'Products';
                        ?>
                        <h3 class="card-title"><?=$pageTitle?></h3>
                    </div>
                    <div class="card-body">
                        <?php 
                        //show all products
                        if($do == 'Manage'){
                          if(get_user_permission($_SESSION['role_id'],'show products'))
                            include "products/index.php";
                          else
                            echo '<div class="alert alert-danger"><p class="text-center">You dont Have Permission To Login To This Page</p></div>';
                      
                        }
                        //show add form
                        elseif($do == 'Add'){
                          if(get_user_permission($_SESSION['role_id'],'add product'))
                            include "products/addForm.php";
                          else
                            echo '<div class="alert alert-danger"><p class="text-center">You dont Have Permission To Login To This Page</p></div>';
                        }
                        //insert new product data
                        elseif($do == 'Insert'){
                          if(get_user_permission($_SESSION['role_id'],'add product'))
                            add_product();
                          else
                            echo '<div class="alert alert-danger"><p class="text-center">You dont Have Permission To Login To This Page</p></div>';
                        }
                        //show edit form
                        elseif($do == 'Edit'){
                          if(get_user_permission($_SESSION['role_id'],'update product'))
                            include "products/editForm.php";
                          else
                            echo '<div class="alert alert-danger"><p class="text-center">You dont Have Permission To Login To This Page</p></div>';
                        }
                        //update data
                        elseif($do == 'updateCode'){
                          if(get_user_permission($_SESSION['role_id'],'update product'))
                            update_product();
                          else
                            echo '<div class="alert alert-danger"><p class="text-center">You dont Have Permission To Login To This Page</p></div>';
                        }
                        //delete on record
                        elseif($do == 'Delete'){
                          if(get_user_permission($_SESSION['role_id'],'delete product'))
                            delete_product();
                          else
                            echo '<div class="alert alert-danger"><p class="text-center">You dont Have Permission To Login To This Page</p></div>';
                        }
                        //delete All Selected products
                        elseif($do == 'deleteAll'){
                          if(get_user_permission($_SESSION['role_id'],'delete product'))
                            delete_all_rows();
                          else
                            echo '<div class="alert alert-danger"><p class="text-center">You dont Have Permission To Login To This Page</p></div>';  
                        }
                        //upload product images
                        if(($do == 'addMedia' && isset($_GET['product_id'])) || $do == 'showMedia'){
                          if(get_user_permission($_SESSION['role_id'],'add product'))
                            include "products/media.php"; 
                          else
                            echo '<div class="alert alert-danger"><p class="text-center">You dont Have Permission To Login To This Page</p></div>';  
                        }
                        //show Product Media in update
                        elseif($do == 'uploadImages'){
                          if(get_user_permission($_SESSION['role_id'],'add product'))
                            upload_product_images($_GET['product_id']);
                          else
                            echo '<div class="alert alert-danger"><p class="text-center">You dont Have Permission To Login To This Page</p></div>';  
                        }
                        //delete product Image
                        if($do == 'delImg'){
                          if(get_user_permission($_SESSION['role_id'],'add product'))
                            delImg();
                          else
                            echo '<div class="alert alert-danger"><p class="text-center">You dont Have Permission To Login To This Page</p></div>';  
                        }
                        ?>
                    </div><!--card-body-->
                </div>

            </div> 
            
        </div>
      </div>
    </section>
</div>
<?php include $tpl_cp."footer.php" ?>

<script type="text/javascript">
          $(document).ready(function() {
            //Show records of products on datatables
            var t = $('#example').DataTable( {
              "columnDefs": [
                  { "orderable": false, "targets": 0 }
                ],
              "processing": true,
              "serverSide": true,
              "targets": 0,
              "ajax": "products/server_processing.php",
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
            if($("input[name='checkProduct[]']").filter(':checked').length > 0){
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
                            window.location.href = 'products.php';
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
              $("input[name='checkProduct[]']:checked:enabled").each(function () {
                ids_products.push($(this).val());
              });      
              var urlToRedirect = "?do=deleteAll&ids="; 
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
                    data :{ids:ids_products,tblname:"products"},
                    url: urlToRedirect, 
                    success: function(){   
                      swal("Poof! Your imaginary file has been deleted!", {
                        icon: "success",
                      });     
                      //redirect back after deleting Product 5 seconds
                      setTimeout(function(){
                            window.location.href = 'products.php';
                        }, 5000);
                    }
                  });
                } else {
                  swal("Your imaginary file is safe!");
                }
              });
        }
</script>
