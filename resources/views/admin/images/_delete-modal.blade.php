<!-- Modal -->
<div id="deleteModal" class="modal fade" role="dialog" >
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close"  @click="closeDeleteModal">&times;</button>
        <h4 class="modal-title">Delete Image - <span class="del-image-name">@{{ editImage.name }}</span></h4>
      </div>
      <div class="modal-body">
      <p style="text-align: center">
        Are you sure you want to delete the image <span class="del-image-name">@{{ editImage.name }}</span>?
      </p>
        <input id="del-category-id" hidden :value="editImage.id" />
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger create-btn" @click="deleteImage"><i class="fa fa-trash-o"></i> Delete</button> 
        <button type="button" class="btn btn-danger create-load-btn hidden" disabled="disabled" ><i class="fa fa-spinner fa-spin"></i> Loading...</button>             
        <button type="button" class="btn btn-default" @click="closeDeleteModal">Close</button>
      </div>
    </div>

  </div>
</div>