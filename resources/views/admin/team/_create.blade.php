<el-dialog
	title="Add a new member"
	:visible.sync="createModal"
	width="30%"
	>
	<div class="row">
		<div class="col-md-12">
			<el-input placeholder="First Name" v-model="create.firstName"></el-input>
		</div>
		<div class="col-md-12 mt-25">
			<el-input placeholder="Last Name" v-model="create.lastName"></el-input>
		</div>
		<div class="col-md-12 mt-25">
			<el-input type="textarea" :rows="2" placeholder="Description" v-model="create.description"></el-input>
		</div>
		<div class="col-md-12 mt-25">
			<span class="demo-input-label">Category </span>
			</br>
			<el-select v-model="create.type" placeholder="Select" :default-first-option="true">
				@foreach(App\Team::TYPES as $type => $value)
					<el-option label="{{ $type }}" value="{{ $value }}"></el-option>
				@endforeach
			</el-select>
		</div>
		<div class="col-md-12 mt-25">
			<label for="exampleInputFile">User Avatar</label>
    		<input id="avatar" type="file" id="exampleInputFile">
		</div>
	</div>
	<span slot="footer" class="dialog-footer">
		<el-button @click="createModal = false">Cancel</el-button>
		<el-button type="primary" @click="createMember">Create</el-button>
	</span>
</el-dialog>