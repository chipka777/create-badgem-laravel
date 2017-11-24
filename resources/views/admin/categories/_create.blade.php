<!-- Modal -->
<div id="createModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add a new category</h4>
      </div>
      <div class="modal-body">
          <div class="form-group">
            <label for="name-add">Name</label>
            <input id="name-add" class="form-control" type="text" name="name" >
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-default create-btn" style="margin-left: 85%" @click="addCategory">Create</button>
            <button type="button" class="btn btn-primary create-load-btn hidden" disabled="disabled" style="margin-left: 79%"><i class="fa fa-spinner fa-spin"></i> Loading...</button>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>