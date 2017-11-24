@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="/css/images.css">
@endsection
@section('content')
    <!-- MAIN CONTENT -->
    <div id="app">
        <images-create inline-template>
            <div class="main-content">
                <div class="container-fluid">
                    <!-- OVERVIEW -->
                    <div class="panel panel-headline">
                        
                        <div class="panel-heading">
                            <h3>Upload files</h3>
                        </div>
                        <div class="panel-body">
                            <div class="alert alert-danger" role="alert" v-show="error" style="display: none">
                                <i class="fa fa-times-circle"></i> @{{ error }}
                            </div>
                            <div class="alert alert-success" role="alert" v-show="success" style="display: none">
                                <i class="fa fa-check-circle"></i> @{{ success }}
                            </div>
                            <div class="input-group image-preview">
                                <input placeholder="" type="text" class="form-control image-preview-filename" disabled="disabled">
                                <!-- don't give a name === doesn't send on POST/GET --> 
                                <span class="input-group-btn"> 
                                <!-- image-preview-clear button -->
                                <select class="form-control  image-preview-input image-category">
                                    <option value="all">Category</option>
                                    <option :value="category.id" v-for="category in categories">@{{ category.name }}</option>
                                    
                                </select>
                                <!-- image-preview-input -->
                                <div class="btn btn-default image-preview-input"> <span class="glyphicon glyphicon-folder-open"></span> <span class="image-preview-input-title">Browse</span>
                                    <input type="file" multiple accept="image/png, image/jpeg, image/gif" @change="setPreloadImages($event)" name="input-file-preview"/>
                                    <!-- rename it --> 
                                </div>
                                <button type="button" class="btn btn-labeled btn-primary" @click="setUpload(0)"> <span class="btn-label"><i class="glyphicon glyphicon-upload"></i> </span>Upload</button>
                                </span> </div>
                            <!-- /input-group image-preview [TO HERE]--> 
                            
                            <br />
                            
                            <!-- Drop Zone -->
                            <div id="upload-zone" class="upload-drop-zone" >  
                                <div class="row" v-for="(row, first_key) in uploadImages">
                                    <div class="col-md-3" v-for="(image, second_key) in row">
                                        <a href="#" class="thumbnail" >
                                            <div class="image-mask">
                                                <h4>@{{ image.name }}</h4>
                                                <button type="button" class="btn btn-primary" @click="openZoomModal(image.name)"><i class="fa fa-search-plus"></i>View</button>
                                                <button type="button" class="btn btn-danger" @click="deleteImage(image.id)"><i class="fa fa-trash-o"></i> Delete</button>
                                            </div>
                                            <img :src="'/upload/' + image.name" />
                                        </a>
                                    </div>
                                </div>
                             </div>
                            <br />
                            <!-- Progress Bar -->
                            <div id="upload-progress" class="progress">
                                <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                </div>
                            </div>
                            <br />
                        </div>
                    </div>
                    @include('admin.images._zoom-modal')
                    <!-- END OVERVIEW -->
                </div>
            </div>
        </images-create>
    </div>
    <!-- END MAIN CONTENT -->
@endsection
@section('scripts')

<script src="{{ asset('js/app.js') }}"></script>

@endsection
