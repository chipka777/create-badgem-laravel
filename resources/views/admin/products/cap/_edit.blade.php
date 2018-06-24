<el-dialog
	title="Edit a product"
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
			<el-input placeholder="Story" v-model="edit.story"></el-input>
		</div>
        <div class="col-md-12 mt-25">
			<el-input placeholder="Price" v-model="edit.price"></el-input>
		</div>
        <div class="col-md-12 mt-25">
            <span class="demo-input-label">Sizes (divide them '|' (e.g. S|M|L))</span>
			<el-input placeholder="Sizes" v-model="edit.sizes"></el-input>
		</div>
		<div class="col-md-12 mt-25">
			<span class="demo-input-label">Product Category </span>
			</br>
			<el-select v-model="edit.type" placeholder="Select" :default-first-option="true">
				<el-option label="Cap" value="cap"></el-option>
				<el-option label="T-shirt" value="t-shirt"></el-option>
				<el-option label="Badge" value="badge"></el-option>
				<el-option label="Book" value="book"></el-option>
			</el-select>
		</div>
        <div class="col-md-12 mt-25 text-center">
            <img :src="edit.photo" style="max-width: 300px;"/>                
        </div>
        <div class="col-md-12 mt-25">
            <label for="editMainImage">Main Image</label>
            <input id="editMainImage" type="file" />
		</div>
		<div class="col-md-12 mt-25 text-center">
			<div class="col-md-4" v-for="(image,key) in edit.extra">
				<img :src="image" style="max-width: 100px;"/>     
				<i class="fa fa-trash" style="cursor:pointer" @click="removeExtra(key)"></i> 			
			</div>
        </div>
		<div class="col-md-12 mt-25">
            <label for="editExtraImages">Extra Images</label>
            <input id="editExtraImages" type="file" multiple />
		</div>
	</div>
	<span slot="footer" class="dialog-footer">
		<el-button @click="editModal = false">Cancel</el-button>
		<el-button type="primary" @click="editItem">Save</el-button>
	</span>
</el-dialog>