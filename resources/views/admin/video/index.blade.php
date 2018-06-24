@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="/css/categories.css">

@endsection
@section('content')
    <div id="app">
        <youtube-video inline-template>
            <div class="main-content">
                <div class="container-fluid">
                    <!-- OVERVIEW -->
                    <div class="panel panel-headline">
                            <button type="button" class="btn btn-default pull-right create-modal-btn" 
                                @click="createModal = true">
                                    <i class="fa fa-plus-square"></i>
                                    Add new 
                                </button>
                        <div class="panel-heading">
                            <h3 class="panel-title">Videos</h3>
                        </div>
                        <div class="panel-body" v-loading="loading">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Video ID</th>
                                        <th style="width: 420px">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(video, key) in videos">
                                        <td>@{{ video.name }} </td>
                                        <td>@{{ video.video_id }} </td>                                      
                                        <td>
                                            <button type="button" class="btn btn-warning" @click="editVideoOpen(key)"><i class="fa fa-pencil"></i> Edit</button>
                                            <button type="button" class="btn btn-info" @click="deleteVideoOpen(key)"><i class="fa fa-trash"></i> Delete</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="col-md-12" style="text-align:center">
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

                            @include('admin.video._create')  
                            @include('admin.video._edit')
                            @include('admin.video._delete')                                                                                          
                        </div>
                    </div>
                <!-- END OVERVIEW -->
                </div>
            </div>
        </youtube-video>
    </div>
@endsection