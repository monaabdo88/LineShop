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
                                    
                                    <!-- start Product price Field -->
                                    <div class="form-group form-group-lg col-md-4 float-right">
                                        <label class="col-sm-6 control-label float-left">Product Price</label>
                                        <div class="col-sm-6 col-md-6 float-right">
                                            <input type="text" name="price" class="form-control" />
                                        </div>
                                    </div>
                                    <!-- End Product price Field -->
                                    <!-- start Product disount Field -->
                                    <div class="form-group form-group-lg col-md-4 float-right">
                                        <label class="col-sm-6 control-label float-left">Product Discount</label>
                                        <div class="col-sm-6 col-md-6 float-right">
                                            <input type="text" name="discount" class="form-control" />
                                        </div>
                                    </div>
                                    <!-- End Product disount Field -->
                                    <!-- start Product quantity Field -->
                                    <div class="form-group form-group-lg col-md-4 float-right">
                                        <label class="col-sm-6 control-label float-left">Product Quantity</label>
                                        <div class="col-sm-6 col-md-6 float-right">
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
                                    <!-- Start Submit Field -->
                                    <div class="clearfix"></div>
                                    <div class="col-md-12">
                                        <input type="submit" id="uploadfiles" value="Save" class="btn btn-primary btn-block btn-lg" />
                                        <br>
                                    </div>
                                    
                                    <!-- End Submit Field -->
                                </form>
<!---- preview image before upload code ----->
 
   
