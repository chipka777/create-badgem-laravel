<el-dialog
	title="Delete a product"
	:visible.sync="deleteModal"
	width="30%"
	>
  <span  style="text-align:center">
    <h4>Do you really want delete this Product?</h4>
</span>
	<span slot="footer" class="dialog-footer">
		<el-button @click="deleteModal = false">Cancel</el-button>
		<el-button type="primary" @click="deleteProduct">Delete</el-button>
	</span>
</el-dialog>