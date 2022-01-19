<?php 
include "includes/templates/header.php";
include "includes/functions/Roles.php";
?>
<title><?=get_item('site_name','settings','id',1)?> | <?=get_title_cp('Roles');?></title>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><?=get_title_cp('Roles');?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Dahboard</a></li>
              <li class="breadcrumb-item active"><?=get_title_cp('Roles');?></li>
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
                          $pageTitle = 'Roles';
                        elseif($do == 'Add' || $do == 'Insert')
                          $pageTitle = 'Add New Role';
                        elseif($do == 'Edit' || $do == 'updateCode')
                          $pageTitle = 'Edit Role';
                        else
                          $pageTitle = 'Roles';
                        ?>
                        
                        <h3 class="card-title"><?=$pageTitle?></h3>
                        
                    </div>
                    <div class="card-body">
                        <?php 
                        if($_SESSION['admin_id'] == 1){
                          //show all roles
                          if($do == 'Manage'){
                              include "roles/index.php";
                          }
                          //add new role
                          elseif($do == 'Add'){
                              include "roles/addForm.php";
                          }
                          //insert new role
                          elseif($do == 'Insert'){
                              add_Role();
                          }
                          //edit role
                          elseif($do == 'Edit'){
                              include "roles/editForm.php";
                          }
                          //update role
                          elseif($do == 'updateCode'){
                              update_Role();
                          }
                          //delete role
                          elseif($do == 'Delete'){
                              delete_Role();
                          }
                          //delete all roles
                          elseif($do == 'deleteAll'){
                              delete_all_rows();
                          }
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
              "ajax": "Roles/server_processing.php",
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
          if($("input[name='checkRole[]']").filter(':checked').length > 0){
            $(".delAll").removeAttr("disabled");
          }else{
            $(".delAll").prop('disabled', true);              
          }

        }
        //Confirm Before delete Role
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
                      //redirect back after deleting Role 5 seconds
                      setTimeout(function(){
                            window.location.href = 'roles.php';
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
              $("input[name='checkRole[]']:checked:enabled").each(function () {
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
                    data :{ids:ids_cats,tblname:"roles"},
                    url: urlToRedirect, 
                    success: function(){   
                      swal("Poof! Your imaginary file has been deleted!", {
                        icon: "success",
                      });     
                      //redirect back after deleting Role 5 seconds
                      setTimeout(function(){
                            window.location.href = 'roles.php';
                        }, 5000);
                    }
                  });
                } else {
                  swal("Your imaginary file is safe!");
                }
              });
        }
</script>
