<style>
.dropzone .dz-preview .dz-image img{
        height: 100%;
        width:100%;
        object-fit: cover;    
}
</style>
<?php 
if(isset($_GET['product_id']) && is_numeric($_GET['product_id'])){
  $product_id = $_GET['product_id'];
  $check = checkItem('id', 'products', $product_id);
  if($check){
    echo '
    <h3 class="text-center"> '.get_item('title','products','id',$product_id).' Images</h3>
    <form action="?do=uploadImages&product_id='.$product_id.'"  class="dropzone" id="mydropzone" method="post" enctype="multipart/form-data">
    
    <br />
    </form><br>
    <button type="submit" class="btn btn-primary btn-block" id="upload_all">Upload Media</button>
    ';
  }else{
    echo show_msg('Error','This product is Not Found');
    redirectPage('products.php'); 
  }
            
}
?>
<script type="text/javascript">
  $(function() {

  //dropzone code
    Dropzone.options.mydropzone = {
      addRemoveLinks: true,
      autoProcessQueue: false,
      thumbnailWidth: 250,
      thumbnailHeight: 250,
      removedfile : function(file)
                {
                    var imageName = file.name;
                    var confirmation = confirm('Are you sure you want to delete this image?');
                    if(confirmation == true)
                    {
            //post request to remove file from server
                        $.post("?do=delImg&image_name=" + imageName +"&product_id="+ <?=$product_id?>);
            //deleting thumbnails
                        var _ref;
                        return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
                    }
                },
      init: function() {
        //if edit product
        thisDropzone = this;

        <?php if($_GET['do'] == 'showMedia'){
          $rows = get_related_data('files','product_id',$product_id);
          foreach($rows as $row){?>
            var mockFile = { name: "<?=$row['file_name']?>", size: "<?=$row['file_size']?>" };
            this.options.addedfile.call(thisDropzone, mockFile);
            this.options.complete.call(thisDropzone, mockFile);
            this.options.thumbnail.call(thisDropzone, mockFile, "<?=$row['file_dir'].$row['file_name']?>");
            mockFile.previewElement.classList.add('dz-success');
            mockFile.previewElement.classList.add('dz-complete');
            mockFile.previewElement.classList.add('dz-success');
            this.on("removedfile", function(file) {
              $.ajax({
                  url: '?do=delImg&imgID=<?=$row['id']?>',
                  type: "POST",
                  data: { 'imgID': file.name}
              });
            });
        <?php } //end foreach
        } //end if
      ?>
    }//end init function
  };//end dropzone code
    //submit Form
    $("#upload_all").click(function(){
      $("#mydropzone").submit();
      thisDropzone.processQueue();

    });
    //on edit product
  });
</script>

