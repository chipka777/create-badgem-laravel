<el-dialog
	title="Add a new video"
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
		<div class="col-md-12 mt-25">
			<el-input placeholder="Name" v-model="create.name"></el-input>
		</div>
		<div class="col-md-12 mt-25">
			<el-input placeholder="Video ID" v-model="create.video_id"></el-input>
		</div>
        <div class="col-md-12 mt-25">
			<label for="thumbnail">Thumbnail</label>
			<input id="thumbnail" type="file" />
			<el-checkbox @change="changeThumbnailCheckbox" style="margin-top:25px; display: block;" v-model="thumbnailByApi">Get Thumbnail by API</el-checkbox>
		</div>
	</div>
	<span slot="footer" class="dialog-footer">
		<el-button @click="createModal = false">Cancel</el-button>
		<el-button type="primary" @click="addVideo" >Create</el-button>
	</span>
</el-dialog>