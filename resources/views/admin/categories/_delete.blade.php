<!-- Modal -->
<div id="deleteModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Delete Category - <span class="del-category-name"></span></h4>
      </div>
      <div class="modal-body">
      <p style="text-align: center">
        Are you sure you want to delete the category <span class="del-category-name"></span>?
      </p>
        <input id="del-category-id" hidden />
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger create-btn" @click="deleteCategory"><i class="fa fa-trash-o"></i> Delete</button> 
        <button type="button" class="btn btn-danger create-load-btn hidden" disabled="disabled" ><i class="fa fa-spinner fa-spin"></i> Loading...</button>             
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>