@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="/css/images.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">

@endsection
@section('content')
    <!-- MAIN CONTENT -->
        <images-pending inline-template>
            <div class="main-content">
                <div class="container-fluid">
                    <!-- OVERVIEW -->
                    <div class="panel panel-headline">
                    
                        <div class="panel-heading">
                            <h3 class="panel-title">Pending Images</h3>
                            <select id="categoryOrder" class="form-control pull-right" style="margin-top: -33px; width:150px" @change="orderByCategory"> 
                                <option value="all">All</option>
                                <option :value="category.id" v-for="category in categories">@{{ category.name }}</option>
                            </select>
                        </div>
                        <div class="panel-body">
                            <div class="loader" v-show="loader"></div>
                            <div class="main-images">
                                <div class="row" v-for="(row, first_key) in images">
                                    <div class="col-md-3" v-for="(image, second_key) in row">
                                        <a href="#" class="thumbnail">
                                            <div class="image-mask">
                                                <h4>@{{ image.name }}</h4>
                                                <button type="button" class="btn btn-primary" @click="approveImage(image.id)"><i class="fa fa-check"></i>Approve</button>
                                                <button type="button" class="btn btn-danger" @click="deleteImage(image.id)"><i class="fa fa-trash-o"></i> Delete</button>
                                            </div>
                                            <img :src="'/upload/thumbs/' + image.name" />                                            
                                        </a>
                                    </div>
                                </div>
                               
                            </div>
                             <paginate
                                    :page-count="this.pageCount"
                                    :page-range="5"
                                    :margin-pages="1"
                                    :click-handler="paginateCallBack"
                                    :prev-text="'Prev'"
                                    :next-text="'Next'"
                                    :container-class="'pagination image-pagination'"
                                    :page-class="'page-item'">
                                </paginate>
                        </div>
                    </div>
                    <!-- END OVERVIEW -->
                </div>
                @include('admin.images._edit-modal')
                @include('admin.images._delete-modal')
            </div>
            
           
        </images-pending>
    <!-- END MAIN CONTENT -->
@endsection
@section('scripts')


@endsection
