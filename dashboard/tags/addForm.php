                 
<form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="user_id" value="<?= $_SESSION['admin_id'] ?>" />
                                    <!-- Start Tag Title Field -->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-2 control-label">Tag Title</label>
                                        <div class="col-sm-10 col-md-12">
                                            <input type="text" name="title" class="form-control" required="required" />
                                        </div>
                                    </div>
                                    
                                    <!-- Start Submit Field -->
                                    
                                    <div class="col-md-12">
                                        <input type="submit" value="Save" class="btn btn-primary btn-block btn-lg" />
                                        <br>
                                    </div>
                                    <!-- End Submit Field -->
                                </form>
<!---- preview image before upload code ----->
<script type="text/javascript">
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#preview').attr('src', e.target.result);
                    $('#preview').show();
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
</script>
