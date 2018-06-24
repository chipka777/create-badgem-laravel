<el-dialog
	title="Add a new question"
	:visible.sync="createModal"
	width="30%"
	>
	<div class="row">
		<div class="col-md-12">
			<el-input placeholder="Question" v-model="create.question"></el-input>
		</div>
		<div class="col-md-12 mt-25">
			<el-input placeholder="Answer" v-model="create.answer"></el-input>
		</div>
	</div>
	<span slot="footer" class="dialog-footer">
		<el-button @click="createModal = false">Cancel</el-button>
		<el-button type="primary" @click="createQuestion">Create</el-button>
	</span>
</el-dialog>