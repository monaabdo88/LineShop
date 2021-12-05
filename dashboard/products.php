<?php 
include "includes/templates/header.php";
include "includes/functions/products.php";
?>
<script type="text/javascript">
  
</script>

<title><?=get_item('site_name','settings',1)?> | <?=get_title_cp('Products');?></title>
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
                        if($do == 'Manage'){
                            include "products/index.php";
                        }
                        elseif($do == 'Add'){
                            include "products/addForm.php";
                        }
                        elseif($do == 'Insert'){
                            add_product();
                        }
                        elseif($do == 'Edit'){
                            include "products/editForm.php";
                        }
                        elseif($do == 'updateCode'){
                            update_product();
                        }
                        elseif($do == 'Delete'){
                          delete_product();
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
              "processing": true,
              "serverSide": true,
              "targets": 0,
              "ajax": "products/server_processing.php",
              "order": [[ 1, 'asc' ]]
            });
            t.on( 'order.dt search.dt', function () {
                t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
              } );
            } ).draw();
          });
        //Confirm Before delete Product
        function confirmation(ev) {
              ev.preventDefault();
              var urlToRedirect = ev.currentTarget.getAttribute('href'); //use currentTarget because the click may be on the nested i tag and not a tag causing the href to be empty
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
                            window.location.href = 'Products.php';
                        }, 5000);
                    }
                  });
                } else {
                  swal("Your imaginary file is safe!");
                }
              });
        }
       
</script>
