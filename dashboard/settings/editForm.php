<?php 
    $row = get_row_data('settings','1');
?>                   
<form class="form-horizontal" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="userid" value="<?php echo $userid ?>" />
                                    <!-- Start site name Field -->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-2 control-label">Site Name</label>
                                        <div class="col-sm-10 col-md-12">
                                            <input type="text" name="site_name" class="form-control" value="<?php echo $row['site_name'] ?>" required="required" />
                                        </div>
                                    </div>
                                    
                                    <!-- Start Email Field -->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-2 control-label">Site Email</label>
                                        <div class="col-sm-10 col-md-12">
                                            <input type="email" name="site_email" value="<?php echo $row['site_email'] ?>" class="form-control" required="required" />
                                        </div>
                                    </div>
                                    <!-- End Email Field -->
                                    <!-- Start phone Field -->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-2 control-label">Site Phone</label>
                                        <div class="col-sm-10 col-md-12">
                                            <input type="text" name="site_phone" value="<?php echo $row['site_phone'] ?>" class="form-control" required="required" />
                                        </div>
                                    </div>
                                    <!-- End site phone Field -->
                                    <!-- Start site description Field -->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-2 control-label">Site Description</label>
                                        <div class="col-sm-10 col-md-12">
                                            <textarea class="form-control" name="site_desc"><?=$row['site_desc']?></textarea>
                                        </div>
                                    </div>
                                    <!-- End site description Field -->
                                <!-- Start site tags Field -->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-2 control-label">Site Tags</label>
                                        <div class="col-sm-10 col-md-12">
                                            <textarea class="form-control" name="site_tags"><?=$row['site_tags']?></textarea>
                                        </div>
                                    </div>
                                    <!-- End site description Field -->
                                    <!-- Start site status Field -->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-2 control-label">Site Status</label>
                                        <div class="col-sm-10 col-md-12">
                                            <input type="radio" name="site_status" value="0" <?=($row['site_status'] == '0')? 'checked':''?>/> Close 
                                            <input type="radio" name="site_status" value="1" <?=($row['site_status'] == '1')? 'checked':''?>/> Open
                                        </div>
                                    </div>
                                    <!-- End site status Field -->
                                <!-- Start site Close Text Field -->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-2 control-label">Site Close Text</label>
                                        <div class="col-sm-10 col-md-12">
                                            <textarea class="form-control" name="site_text_close"><?=$row['site_text_close']?></textarea>
                                        </div>
                                    </div>
                                    <!-- End site Close Text Field -->
                                    <!-- Start site Copyrights Text Field -->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-2 control-label">Site Copyrights</label>
                                        <div class="col-sm-10 col-md-12">
                                            <textarea class="form-control" name="site_copyrights"><?=$row['site_copyrights']?></textarea>
                                        </div>
                                    </div>
                                    <!-- End site Copyrights Text Field -->
                                    <!-- Start site logo Field -->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-2 control-label">Site Logo</label>
                                        <div class="col-sm-10 col-md-12">
                                            <input type="file" name="site_logo" onchange="readURL(this);" class="form-control" />
                                        </div>
                                    </div>
                                    <!-- End site logo Field -->
                                    <!---- site logo preview ----->
                                    <div class="col-md-6 col-md-offset-3">
                                        <img id="preview" src="<?=$row['site_logo']?>" class="img-thumbnail img-responsive" />
                                        <br/><br>
                                    </div>
                                    
                                    <!-- Start Submit Field -->
                                    
                                    <div class="col-md-12">
                                        <input type="submit" value="Save" class="btn btn-primary btn-block btn-lg" />
                                        <br>
                                    </div>
                                    <!-- End Submit Field -->
                                </form>