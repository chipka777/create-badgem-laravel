@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="/css/categories.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">

@endsection
@section('content')
    <!-- MAIN CONTENT -->
        <categories inline-template>
            <div class="main-content">
                <div class="container-fluid">
                    <!-- OVERVIEW -->
                    <div class="panel panel-headline">
                        <button type="button" class="btn btn-default pull-right create-modal-btn" 
                        data-toggle="modal" data-target="#createModal">
                            <i class="fa fa-plus-square"></i>
                            Add new 
                         </button>
                        <div class="panel-heading">
                            <h3 class="panel-title">Categories</h3>
                        </div>   
                        <div class="panel-body">
                        <div class="loader" v-show="loader"></div>
                            <table id="category-table" class="table table-striped" >
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Visibility</th>
                                        <th style="width: 30%;text-align: center;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="category in categories">
                                        <td>@{{ category.id }}</td>
                                        <td>@{{ category.name }}</td>
                                        <td>
                                            <div class="checkbox">
                                                <label class="category-check">
                                                    <input :id="'checkbox-'+ category.id" class="checkbox-visibiliy" type="checkbox" @click="setVisibleCategory(category.id)" :checked="category.visibility" onclick="return false;">
                                                </label>
                                            </div>
                                        </td>
                                        <td style="text-align: center;">
                                            <button type="button" class="btn btn-primary" @click="openEditCategory(category.id, category.name)" ><i class="lnr lnr-pencil"></i></button>
                                            <button type="button" class="btn btn-danger" @click="openDeleteCategory(category.id, category.name)"><i class="fa fa-trash-o"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
        
                        </div>
                    </div>
                    <!-- END OVERVIEW -->
                </div>
                 @include('admin.categories._create')
                 @include('admin.categories._edit')
                 @include('admin.categories._delete')
                
            </div>
            
           
        </categories>
    <!-- END MAIN CONTENT -->
@endsection
@section('scripts')


@endsection
