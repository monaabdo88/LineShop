<?php 
include "includes/templates/header.php"; 
include "includes/functions/settings.php";
?>
<title><?=get_item('site_name','settings','id',1)?> | <?=get_title_cp('Main Settings');?></title>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><?=get_title_cp('Main Settings');?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Dahboard</a></li>
              <li class="breadcrumb-item active"><?=get_title_cp('Main Settings');?></li>
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
                        <h3 class="card-title">Edit Settings</h3>
                    </div>
                    <div class="card-body">
                        <?php
                        //check if user has permission to log into settings page 
                        if(get_user_permission($_SESSION['role_id'],'update settings')){
                          //Edit Form
                          include ("settings/editForm.php");
                          //update settings
                          if($_SERVER['REQUEST_METHOD'] == 'POST'){
                             update_settings();
                          }
                        }
                        else{
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

<!---- preview image before upload code ----->
<script type="text/javascript">
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                $('#preview').attr('src', e.target.result);
            }

                reader.readAsDataURL(input.files[0]);
            }
        }
        //for slider background image
        function readURL2(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                $('#preview2').attr('src', e.target.result);
            }

                reader.readAsDataURL(input.files[0]);
            }
        }
        
</script>
