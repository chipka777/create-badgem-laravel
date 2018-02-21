@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="/css/images.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
    <style>
        .thumb-mask {
            display: flex;
            justify-content: center;
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            opacity: 0;
            transition: opacity .5s ease;
        }

        .thumb-mask>i {
            margin:auto;
            font-size: 75px;
            color: #ffffff;
        }

        .thumb-mask:hover {
            opacity: 1;
        }
        .thumbnail {
            position: relative;
        }
    </style>
@endsection
@section('content')
    <!-- MAIN CONTENT -->
        <images-show inline-template>
            <div class="main-content">
                <div class="container-fluid">
                    <!-- OVERVIEW -->
                    <div class="panel panel-headline">
                    
                        <div class="panel-heading">
                            <h3 class="panel-title">Images</h3>
                            <select id="categoryOrder" class="form-control pull-right" style="margin-top: -33px; width:150px" @change="orderByCategory"> 
                                <option value="all">All</option>
                                <option value="favorited">Favorited</option>                                
                                <option :value="category.id" v-for="category in categories">@{{ category.name }}</option>
                            </select>
                        </div>
                        <div class="panel-body">
                            <div class="loader" v-show="loader"></div>
                            <div class="main-images">
                                <div class="row" v-for="(row, first_key) in images">
                                    <div class="col-md-3" v-for="(image, second_key) in row">
                                        <a  class="thumbnail" v-loading="image.loading">
                                            <img :src="'/upload/thumbs/' + image.name" />
                                            <div class="thumb-mask" title="Remove from Favorite" v-if='image.favorite' @click="removeFromFavorited(image.id,first_key,second_key)">
                                                <i class="fa fa-heart"></i>                 
                                            </div> 
                                            <div class="thumb-mask" title="Add to Favorite"  v-else @click="addToFavorited(image.id,first_key,second_key)" >
                                                <i class="fa fa-heart-o"></i>                                                
                                            </div> 
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

            </div>
            
           
        </images-show>
    <!-- END MAIN CONTENT -->
@endsection
@section('scripts')

@endsection
