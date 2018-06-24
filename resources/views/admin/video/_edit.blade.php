<el-dialog
	title="Edit a video"
	:visible.sync="editModal"
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
			<el-input placeholder="Name" v-model="edit.name"></el-input>
		</div>
		<div class="col-md-12 mt-25">
			<el-input placeholder="Video ID" v-model="edit.video_id"></el-input>
		</div>
		<div class="col-md-12 mt-25 text-center">
            <img :src="edit.thumbnail" style="max-width: 300px;"/>                
        </div>
        <div class="col-md-12 mt-25">
			<label for="editThumbnail">Thumbnail</label>
			<input id="editThumbnail" type="file" />
			<el-checkbox @change="changeThumbnailCheckbox" style="margin-top:25px; display: block;" v-model="thumbnailByApi">Get Thumbnail by API</el-checkbox>
		</div>
	</div>
	<span slot="footer" class="dialog-footer">
		<el-button @click="editModal = false">Cancel</el-button>
		<el-button type="primary" @click="editItem">Save</el-button>
	</span>
</el-dialog>