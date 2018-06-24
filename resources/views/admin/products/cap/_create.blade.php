<el-dialog
	title="Add a new product"
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
			<el-input placeholder="Story" v-model="create.story"></el-input>
		</div>
        <div class="col-md-12 mt-25">
			<el-input placeholder="Price" v-model="create.price"></el-input>
		</div>
        <div class="col-md-12 mt-25">
            <span class="demo-input-label">Sizes (divide them '|' (e.g. S|M|L))</span>
			<el-input placeholder="Sizes" v-model="create.sizes"></el-input>
		</div>
		<div class="col-md-12 mt-25">
			<span class="demo-input-label">Product Category </span>
			</br>
			<el-select v-model="create.type" placeholder="Select" :default-first-option="true">
				<el-option label="Cap" value="cap"></el-option>
				<el-option label="T-shirt" value="t-shirt"></el-option>
				<el-option label="Badge" value="badge"></el-option>
				<el-option label="Book" value="book"></el-option>
			</el-select>
		</div>
        <div class="col-md-12 mt-25">
            <label for="mainImage">Main Image</label>
            <input id="mainImage" type="file" />
		</div>
		<div class="col-md-12 mt-25">
            <label for="extraImages">Extra Images</label>
            <input id="extraImages" type="file" multiple/>
		</div>
	</div>
	<span slot="footer" class="dialog-footer">
		<el-button @click="createModal = false">Cancel</el-button>
		<el-button type="primary" @click="addItem">Create</el-button>
	</span>
</el-dialog>