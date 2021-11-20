<?php include "includes/templates/header.php" ?>
<title><?=get_item('site_name','settings',1)?> | <?=get_title_cp('Categories');?></title>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><?=get_title_cp('Categories');?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Dahboard</a></li>
              <li class="breadcrumb-item active"><?=get_title_cp('Categories');?></li>
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
                          $pageTitle = 'Categories';
                        elseif($do == 'Add' || $do == 'Insert')
                          $pageTitle = 'Add New Category';
                        elseif($do == 'Edit' || $do == 'updateCode')
                          $pageTitle = 'Edit Category';
                        else
                          $pageTitle = 'Categories';
                        ?>
                        
                        <h3 class="card-title"><?=$pageTitle?></h3>
                        
                    </div>
                    <div class="card-body">
                        <?php 
                        if($do == 'Manage'){
                            include "categories/index.php";
                        }
                        elseif($do == 'Add'){
                            include "Categories/addForm.php";
                        }
                        elseif($do == 'Insert'){
                            add_category();
                        }
                        elseif($do == 'Edit'){
                            include "Categories/editForm.php";
                        }
                        elseif($do == 'updateCode'){
                            up_category();
                        }
                        elseif($do == 'Delete'){
                            del_cat();
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
            //Show records of cateogries on datatables
            $('#example').DataTable( {
              "processing": true,
              "serverSide": true,
              "ajax": "categories/server_processing.php"
            });
          });
        //Confirm Before delete category
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
                      //redirect back after deleting category 5 seconds
                      setTimeout(function(){
                            window.location.href = 'categories.php';
                        }, 5000);
                    }
                  });
                } else {
                  swal("Your imaginary file is safe!");
                }
              });
        }
       
</script>
