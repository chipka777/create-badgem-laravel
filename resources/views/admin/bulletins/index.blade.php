@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="/css/categories.css">

@endsection
@section('content')
    <div id="app">
        <admin-bulletin inline-template>
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
                            <h3 class="panel-title">Bulletins</h3>
                        </div>
                        <div class="panel-body" v-loading="loading">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 30%">Name</th>
                                        <th>Description</th>
                                        <th style="width: 420px">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(bulletin, key) in bulletins">
                                        <td>@{{ bulletin.name }} </td>
                                        <td>@{{ bulletin.description }} </td>                                      
                                        <td>
                                            <button type="button" class="btn btn-warning" @click="editBulletinOpen(key)"><i class="fa fa-pencil"></i> Edit</button>
                                            <button type="button" class="btn btn-info" @click="deleteBulletinOpen(key)"><i class="fa fa-trash"></i> Delete</button>
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

                            @include('admin.bulletins._create')  
                            @include('admin.bulletins._edit')
                            @include('admin.bulletins._delete')                                                                                          
                        </div>
                    </div>
                <!-- END OVERVIEW -->
                </div>
            </div>
        </admin-bulletin>
    </div>
@endsection