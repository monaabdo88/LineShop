                 
<form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="user_id" value="<?= $_SESSION['admin_id'] ?>" />
                                    <!-- Start Category name Field -->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-2 control-label">Category Name</label>
                                        <div class="col-sm-10 col-md-12">
                                            <input type="text" name="name" class="form-control" required="required" />
                                        </div>
                                    </div>
                                    
                                    <!-- Start Category description Field -->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-2 control-label">Cateogry Description</label>
                                        <div class="col-sm-10 col-md-12">
                                            <textarea class="form-control" name="description"></textarea>
                                        </div>
                                    </div>
                                    <!-- End Category description Field -->
                                       
                                    <!-- Start Category status Field -->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-2 control-label">Cateogry Status</label>
                                        <div class="col-sm-10 col-md-12">
                                            <input type="radio" name="status" value="0"/> Not Active 
                                            <input type="radio" name="status" value="1"/> Active
                                        </div>
                                    </div>
                                    <!-- End Category status Field -->
                                    <!-- Start Parent Category Field -->
                                    <div class="form-group form-group-lg">
                                            <label class="col-sm-2 control-label">Parent Cateogry</label>
                                            <div class="col-sm-10 col-md-12">
                                                <select class="form-control" name="parent_id">
                                                    <option value="">Choose Parent Category</option>
                                                    <?php
                                                    foreach(fetchCategoryTree() as $cat){
                                                        echo '<option value="'.$cat['id'].'">'.$cat['name'].'</option>';
                                                    }
                                                    
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    <!-- End Parent Category Field -->
                                    <!-- Start Category Image Field -->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-2 control-label">Category Image</label>
                                        <div class="col-sm-10 col-md-12">
                                            <input type="file" name="image" onchange="readURL(this);" class="form-control" />
                                        </div>
                                    </div>
                                    <!-- End Category logo Field -->
                                    <!---- Category logo preview ----->
                                    <div class="col-md-6 col-md-offset-3">
                                        <img id="preview" src="#" class="img-thumbnail img-responsive" />
                                        <br/><br>
                                    </div>
                                    
                                    <!-- Start Submit Field -->
                                    
                                    <div class="col-md-12">
                                        <input type="submit" value="Save" class="btn btn-primary btn-block btn-lg" />
                                        <br>
                                    </div>
                                    <!-- End Submit Field -->
                                </form>