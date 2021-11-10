<?php include "includes/templates/header.php" ?>
<title>Admin | <?=get_title_cp('Categories');?></title>
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
                        elseif($do == 'edit')
                          $pageTitle = 'Edit Category';
                        ?>
                        
                        <h3 class="card-title"><?=$pageTitle?></h3>
                        <a href="?do=Add" class="btn btn-success float-right">
                          <i class="fa fa-plus"></i> Add Category
                        </a>
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
                            include "Categories/insertCode.php";
                        }
                        elseif($do == 'edit'){
                            include "Categories/editForm.php";
                        }
                        elseif($do == 'updateCode'){
                            include "Categories/updateCode.php";
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
        $(document).ready(function() {
          $('#example').DataTable( {
              "processing": true,
              "serverSide": true,
              "ajax": "categories/server_processing.php"
            } );
        } );
</script>
