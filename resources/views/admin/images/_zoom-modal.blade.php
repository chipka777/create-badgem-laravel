 <div class="modal fade" id="enlargeImageModal" tabindex="-1" role="dialog" aria-labelledby="enlargeImageModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <h3 style="position:absolute;margin-top:0;">Image Viewer</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
          <img :src="'/upload/' + zoomImage" class="enlargeImageModalSource" v-if="zoomImage" style="width: 100%;">
        </div>
      </div>
    </div>
</div>