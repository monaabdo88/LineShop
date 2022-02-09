                 <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="user_id" value="<?= $_SESSION['admin_id'] ?>" />
                                    <!-- Start page name Field -->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-2 control-label">Page Title</label>
                                        <div class="col-sm-10 col-md-12">
                                            <input type="text" name="title" class="form-control" required="required" />
                                        </div>
                                    </div>
                                    
                                    <!-- Start page description Field -->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-2 control-label">Page Content</label>
                                        <div class="col-sm-10 col-md-12">
                                            <textarea class="form-control" id="editor1" name="content"></textarea>
                                        </div>
                                    </div>
                                    <!-- End page description Field -->
                                       
                                    <!-- Start page status Field -->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-2 control-label">Page Status</label>
                                        <div class="col-sm-10 col-md-12">
                                            <input type="radio" name="status" value="0"/> Not Active 
                                            <input type="radio" name="status" value="1"/> Active
                                        </div>
                                    </div>
                                    <!-- End page status Field -->
                                   
                                    <!-- Start Submit Field -->
                                    <div class="clearfix"></div>
                                    <div class="col-md-12">
                                        <input type="submit" value="Save" class="btn btn-primary btn-block btn-lg" />
                                        <br>
                                    </div>
                                    
                                    <!-- End Submit Field -->
                                </form>
<!---- preview image before upload code ----->

<script type="text/javascript">
        //ckeditor
        CKEDITOR.replace( 'editor1', {
            filebrowserUploadUrl: '../upload.php',
            filebrowserUploadMethod: "form"

        } );
</script>  
   
