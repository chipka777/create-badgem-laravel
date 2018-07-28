<el-dialog
	title="Add a new bulletin"
	:visible.sync="createModal"
	width="30%"
	>
	<div class="row" v-loading="loading">
		<el-alert
            :title="errorMessage"
            type="error"
            class="hidden"
            id="errorBox"
            show-icon>
        </el-alert>
		<div class="col-md-12">
			<el-input placeholder="Name" v-model="create.name"></el-input>
		</div>
		<div class="col-md-12 mt-25">
			<el-input type="textarea" :rows="2" placeholder="Description" v-model="create.description"></el-input>
		</div>
	</div>
	<span slot="footer" class="dialog-footer">
		<el-button @click="createModal = false">Cancel</el-button>
		<el-button type="primary" @click="addBulletin" >Create</el-button>
	</span>
</el-dialog>