@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="/css/categories.css">

@endsection
@section('content')
    <div id="app">
        <admin-team inline-template>
            <div class="main-content">
                <div class="container-fluid">
                    <!-- OVERVIEW -->
                    <div class="panel panel-headline">
                            <button type="button" class="btn btn-default pull-right create-modal-btn" 
                                @click="createModal = true">
                                    <i class="fa fa-plus-square"></i>
                                    New member
                                </button>
                        <div class="panel-heading">
                            <h3 class="panel-title">Team</h3>
                        </div>
                        <div class="panel-body" v-loading="loading">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Description</th>                                        
                                        <th style="width: 420px">Actions</th>                                
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(member, key) in teams">
                                        <td>@{{ member.first_name }} </td>
                                        <td>@{{ member.last_name }} </td>
                                        <td>@{{ member.description }} </td>                                        
                                        <td>
                                            <button type="button" class="btn btn-warning" @click="editMemberOpen(key)"><i class="fa fa-pencil"></i> Edit</button>
                                            <button type="button" class="btn btn-info" @click="deleteMemberOpen(key)"><i class="fa fa-trash"></i> Delete</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="col-md-12" style="text-align:center">
                             
                            </div>

                            @include('admin.team._create')
                            @include('admin.team._edit')   
                            @include('admin.team._delete')                                                                                 
                            
                        </div>
                    </div>
                <!-- END OVERVIEW -->
                </div>
            </div>
        </admin-team>
    </div>
@endsection