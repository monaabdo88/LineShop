                 <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="user_id" value="<?= $_SESSION['admin_id'] ?>" />
                                    <!-- Start Product name Field -->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-2 control-label">Product Title</label>
                                        <div class="col-sm-10 col-md-12">
                                            <input type="text" name="title" class="form-control" required="required" />
                                        </div>
                                    </div>
                                    
                                    <!-- Start Product description Field -->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-2 control-label">Product Description</label>
                                        <div class="col-sm-10 col-md-12">
                                            <textarea class="form-control" id="editor1" name="details"></textarea>
                                        </div>
                                    </div>
                                    <!-- End Product description Field -->
                                       
                                    <!-- Start Product status Field -->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-2 control-label">Product Status</label>
                                        <div class="col-sm-10 col-md-12">
                                            <input type="radio" name="status" value="0"/> Not Active 
                                            <input type="radio" name="status" value="1"/> Active
                                        </div>
                                    </div>
                                    <!-- End Product status Field -->
                                    <!-- start Product price Field -->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-2 control-label">Product Price</label>
                                        <div class="col-sm-10 col-md-12">
                                            <input type="text" name="price" class="form-control" />
                                        </div>
                                    </div>
                                    <!-- End Product price Field -->
                                    <!-- start Product disount Field -->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-2 control-label">Product Discount</label>
                                        <div class="col-sm-10 col-md-12">
                                            <input type="text" name="discount" class="form-control" />
                                        </div>
                                    </div>
                                    <!-- End Product disount Field -->
                                    <!-- start Product quantity Field -->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-2 control-label">Product Quantity</label>
                                        <div class="col-sm-10 col-md-12">
                                            <input type="text" name="quantity" class="form-control" />
                                        </div>
                                    </div>
                                    <!-- End Product quantity Field -->
                                    <!-- Start Product tags Field -->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-2 control-label">Tags</label>
                                        <div class="col-sm-10 col-md-12">
                                            <?php foreach(get_rows('tags') as $tag): ?>
                                                <div class="col-md-3 float-left">
                                                    <input type="checkbox" name="tag[]" value="<?=$tag['id']?>"> <?=$tag['title']?>
                                                </div>
                                            <?php endforeach ?>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <!-- End Product tags Field -->
                                    <!-- Start Category Field -->
                                    <div class="form-group form-group-lg">
                                            <label class="col-sm-2 control-label">Category</label>
                                            <div class="col-sm-10 col-md-12">
                                                <select class="form-control" name="category_id">
                                                    <option value="">Choose Category</option>
                                                    <?php
                                                    foreach(fetchCategoryTree() as $cat){
                                                        echo '<option value="'.$cat['id'].'">'.$cat['name'].'</option>';
                                                    }
                                                    
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    <!-- End Category Field -->
                                    
                                    <!-- Start Product Image Field -->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-2 control-label">Product Main Image</label>
                                        <div class="col-sm-10 col-md-12">
                                            <input type="file" name="main_img" onchange="readURL(this);" class="form-control" />
                                        </div>
                                    </div>
                                    <!-- End Product Main Image Field -->
                                    <!---- Product Main Image preview ----->
                                    <div class="col-md-6 col-md-offset-3">
                                        <img id="preview" style="display:none;" src="#" class="img-thumbnail img-responsive" />
                                        <br/><br>
                                    </div>
                                    <!---- start upload product images --->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-2 control-label">Product Images</label>
                                        <div class="col-sm-10 col-md-12">
                                            <div class="dropzone" id="mydropzone">
                                                <div class="dropzone-previews"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <!---- end upload product images ----->
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
        CKEDITOR.replace( 'editor1', {
            customConfig: 'config.js'
        } );
        Dropzone.autoDiscover = false;
        var fileList = new Array;
            var i = 0;
            var myDropzone = new Dropzone("div#mydropzone", {
                paramName: "file", // The name that will be used to transfer the file 
                url:"upload_product_images()",
                uploadMultiple: true,
                maxFilesize: 99,
                maxFiles : 15,
                autoDiscover:false,
                acceptedFiles: ".png,.jpg,.jpeg",
                previewsContainer: '.dropzone-previews',
                autoProcessQueue : false,
                parallelUploads: 100,
                addRemoveLinks: true,       
                init:function(){
                    this.on("success", function (index, response) {
                        var res = JSON.parse(response);
                        console.log(res);
                        fileList = res.images;
                        for (i = 0; i < fileList.length; i++) {
                        var imgname = fileList[i];
                        $(".dz-remove").eq(index).attr('data-url',imgname);
                    }
                    $('.dz-success-mark').show();
                    });
                }
            }); 
</script>
