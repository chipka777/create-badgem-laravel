<el-dialog
	title="Edit a bulletin"
	:visible.sync="editModal"
	width="30%"
	>
	<div class="row">
		<el-alert
            :title="errorMessage"
            type="error"
            class="hidden"
            id="errorBox"
            show-icon>
        </el-alert>
		<div class="col-md-12">
			<el-input placeholder="Name" v-model="edit.name"></el-input>
		</div>
		<div class="col-md-12 mt-25">
			<el-input type="textarea" :rows="2" placeholder="Description" v-model="edit.description"></el-input>
		</div>
	</div>
	<span slot="footer" class="dialog-footer">
		<el-button @click="editModal = false">Cancel</el-button>
		<el-button type="primary" @click="editBulletin">Save</el-button>
	</span>
</el-dialog>