                 <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="user_id" value="<?= $_SESSION['admin_id'] ?>" />
                                    <!-- Start Role Name Field -->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-2 control-label">Role Name</label>
                                        <div class="col-sm-10 col-md-12">
                                            <input type="text" name="role_name" class="form-control" required="required" />
                                        </div>
                                    </div>
                                    
                                   
                                    <!-- Start  Permissions Field -->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-2 control-label">Permissions</label>
                                        <div class="col-sm-10 col-md-12">
                                            <?php foreach(get_rows('permissions') as $permission): ?>
                                                <div class="col-md-3 float-left">
                                                    <input type="checkbox" name="permissions[]" value="<?=$permission['id']?>"> <?=strtoupper($permission['per_name'])?>
                                                </div>
                                            <?php endforeach ?>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <!-- End Permissions Field -->
                                    <!-- Start Submit Field -->
                                    <div class="clearfix"></div>
                                    <div class="col-md-12">
                                        <input type="submit" value="Save" class="btn btn-primary btn-block btn-lg" />
                                        <br>
                                    </div>
                                    
                                    <!-- End Submit Field -->
                                </form>
<!---- preview image before upload code ----->

