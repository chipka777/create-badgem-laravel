<el-dialog
	title="Edit a question"
	:visible.sync="editModal"
	width="30%"
	>
	<div class="row">
		<div class="col-md-12">
			<el-input placeholder="Question" v-model="edit.question"></el-input>
		</div>
		<div class="col-md-12 mt-25">
			<el-input placeholder="Answer" v-model="edit.answer"></el-input>
		</div>
	</div>
	<span slot="footer" class="dialog-footer">
		<el-button @click="editModal = false">Cancel</el-button>
		<el-button type="primary" @click="editQuestion">Save</el-button>
	</span>
</el-dialog>