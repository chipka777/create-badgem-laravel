<div class="modal fade product_view" id="product_view">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a href="#" data-dismiss="modal" class="class pull-right"><span class="glyphicon glyphicon-remove"></span></a>
                <h3 class="modal-title">Changing the image</h3>
            </div>
            <div class="modal-body">
                <div class="loader edit-loader" v-show="loader"></div>
                <div class="row edit-modal-body" v-if="editImage.name">
                    <div class="col-md-6 product_img">
                        <img :src="'/upload/'+editImage.name" class="img-responsive">
                    </div>
                    <div class="col-md-6 product_content">
                        <h4>Image name : <span>@{{ editImage.name }}</span>
                        <h4>
                            <label>Visibility : </label>
                            <input class="checkbox-visibiliy edit-checkbox" type="checkbox" @click="setVisibleImage" :checked="editImage.approved" onclick="return false;">
                        </h4>
                    </div>
                    <div class="space-ten"></div>
                    <div class="btn-ground">
                        <button type="button" class="btn btn-danger" @click="openDeleteModal" style="margin-left:75px;"><i class="fa fa-trash-o"></i> Delete</button>
                        <!--<button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-heart"></span> Add To Wishlist</button>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>