<el-dialog
	title="Edit a member"
	:visible.sync="editModal"
	width="30%"
	>
	<div class="row">
		<div class="col-md-12">
			<img class="col-md-12" style="max-heigth: 300px;" :src="'/upload/team/' + edit.image" />
		</div>
		<div class="col-md-12 mt-25">
			<el-input placeholder="First Name" v-model="edit.first_name"></el-input>
		</div>
		<div class="col-md-12 mt-25">
			<el-input placeholder="Last Name" v-model="edit.last_name"></el-input>
		</div>
		<div class="col-md-12 mt-25">
			<el-input type="textarea" :rows="2" placeholder="Description" v-model="edit.description"></el-input>
		</div>
		<div class="col-md-12 mt-25">
			<label for="exampleInputFile">User Avatar</label>
			<input id="editAvatar" type="file" id="exampleInputFile">
		</div>
	</div>
	<span slot="footer" class="dialog-footer">
		<el-button @click="editModal = false">Cancel</el-button>
		<el-button type="primary" @click="editMember">Save</el-button>
	</span>
</el-dialog>