<el-dialog
	title="Delete a video"
	:visible.sync="deleteModal"
	width="30%"
	>
  <span  style="text-align:center">
    <h4>Do you really want delete this Video?</h4>
</span>
	<span slot="footer" class="dialog-footer">
		<el-button @click="deleteModal = false">Cancel</el-button>
		<el-button type="primary" @click="deleteVideo">Delete</el-button>
	</span>
</el-dialog>