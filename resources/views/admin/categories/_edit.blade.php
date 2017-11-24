<!-- Modal -->
<div id="editModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Category <span class="edit-category-name"></span></h4>
      </div>
      <div class="modal-body">
          <div class="form-group">
            <label for="name-edit">Name</label>
            <input id="name-edit" class="form-control" type="text" name="name" >
             <input id="edit-category-id" hidden />
          </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-default create-btn"  @click="saveCategory">Save</button>
        <button type="button" class="btn btn-primary create-load-btn hidden" disabled="disabled"><i class="fa fa-spinner fa-spin"></i> Loading...</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>