<?php 
include "includes/templates/header.php";
include "includes/functions/categories.php";
?>
<title><?=get_item('site_name','settings','id',1)?> | <?=get_title_cp('Categories');?></title>
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
                        //show categories
                        if($do == 'Manage'){
                          if(get_user_permission($_SESSION['role_id'],'show categories'))
                            include "categories/index.php";
                          else
                            echo '<div class="alert alert-danger"><p class="text-center">You dont Have Permission To Login To This Page</p></div>';
                        }
                        //Add New Category
                        elseif($do == 'Add'){
                          if(get_user_permission($_SESSION['role_id'],'add new category'))
                            include "Categories/addForm.php";
                          else
                            echo '<div class="alert alert-danger"><p class="text-center">You dont Have Permission To Login To This Page</p></div>';
                        }
                        //Insert New Category
                        elseif($do == 'Insert'){
                          if(get_user_permission($_SESSION['role_id'],'add new category'))
                            add_category();
                          else
                            echo '<div class="alert alert-danger"><p class="text-center">You dont Have Permission To Login To This Page</p></div>';
                        }
                        //Edit Category
                        elseif($do == 'Edit'){
                          if(get_user_permission($_SESSION['role_id'],'update category'))
                            include "Categories/editForm.php";
                          else
                            echo '<div class="alert alert-danger"><p class="text-center">You dont Have Permission To Login To This Page</p></div>';
                        }
                        //update category code
                        elseif($do == 'updateCode'){
                          if(get_user_permission($_SESSION['role_id'],'update category'))
                            update_category();
                          else
                            echo '<div class="alert alert-danger"><p class="text-center">You dont Have Permission To Login To This Page</p></div>';                        
                        }
                        //Delete Category Code
                        elseif($do == 'Delete'){
                          if(get_user_permission($_SESSION['role_id'],'delete category'))
                            delete_category();
                          else
                            echo '<div class="alert alert-danger"><p class="text-center">You dont Have Permission To Login To This Page</p></div>';
                        }
                        //Delete All Categories
                        elseif($do == 'deleteAll'){
                          if(get_user_permission($_SESSION['role_id'],'delete category'))
                            delete_all_rows();
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
      
        //datatables code
        $(document).ready(function() {
            //Show records of cateogries on datatables
            var t = $('#example').DataTable( {
              "columnDefs": [
                  { "orderable": false, "targets": 0 }
                ],
              "processing": true,
              "serverSide": true,
              "targets": 0,
              "ajax": "categories/server_processing.php",
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
          if($("input[name='checkCat[]']").filter(':checked').length > 0){
            $(".delAll").removeAttr("disabled");
          }else{
            $(".delAll").prop('disabled', true);              
          }

        }
        //Confirm Before delete category
        function confirmation(ev) {
              ev.preventDefault();
              var urlToRedirect = ev.currentTarget.getAttribute('href'); //use currentTarget because the click may be on the nested i tag and not a tag causing the href to be empty
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
       //Delete All function
       function confirmationDel() {
              var ids_cats = new Array(); 
              $("input[name='checkCat[]']:checked:enabled").each(function () {
                ids_cats.push($(this).val());
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
                    data :{ids:ids_cats,tblname:"categories"},
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
