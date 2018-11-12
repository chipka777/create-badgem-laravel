@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="/css/categories.css">

@endsection
@section('content')
    <div id="app">
        <admin-users inline-template>
            <!-- MAIN CONTENT -->
            <div class="main-content">
                <div class="container-fluid">
                    <!-- OVERVIEW -->
                    <div class="panel panel-headline">
                        <div class="panel-heading">
                            <h3 class="panel-title">Users</h3>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th style="width: 520px">Actions</th>                                
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->roles->first()['display_name'] }}</td>
                                            <td>
                                                <a href="{{ route('users.show', ['id' => $user->id]) }}" >
                                                    <button type="button" class="btn btn-info"><i class="fa fa-info-circle"></i> Profile</button>
                                                </a>
                                                <a href="{{ route('users.edit', ['id' => $user->id]) }}" >                                       
                                                    <button type="button" class="btn btn-warning"><i class="fa fa-pencil"></i> Edit Profile</button>
                                                </a>
                                                @if ($user->hasRole('consumer') && $user->invite_code === NULL)
                                                    <button type="button" class="btn btn-success" @click="openModal('{{ $user->name }}', '{{ $user->id }}')"><i class="fa fa-envelope"></i> Send invite</button>                                  
                                                @elseif ($user->hasRole('consumer') && $user->invite_code !== NULL)
                                                    <button type="button" class="btn btn-default" @click="openModal('{{ $user->name }}', '{{ $user->id }}', true)"><i class="fa fa-retweet"></i> Resend invite</button>                                                                                  
                                                @endif
                                                <button @click="openDeleteModal('{{ $user->id }}', '{{ $user->name }}')" type="button" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div style="text-align:center">
                                {{ $users->links() }}
                            </div>
                            <el-dialog
                                title="Invite as Designer"
                                :visible.sync="dialogVisible"
                                width="40%"
                               
                                v-loading="loading"
                                >
                                <span  style="text-align:center"><h4>Do you really want to invite <b>@{{ dialogName }}</b> as a designer?</h4></span>
                                <span slot="footer" class="dialog-footer">
                                    <el-button @click="dialogVisible = false">Cancel</el-button>
                                    <el-button type="primary" @click="sendInvite">Confirm</el-button>
                                </span>
                                </el-dialog>
                            <el-dialog
                                title="Deleting User"
                                :visible.sync="deleteModal"
                                width="40%"
                               
                                v-loading="loading"
                                >
                                <span  style="text-align:center"><h4>Do you really want to delete the user <b>@{{ currentDeleteName }}</b> ?</h4></span>
                                <span slot="footer" class="dialog-footer">
                                    <el-button @click="deleteModal = false">Cancel</el-button>
                                    <el-button type="primary" @click="deleteUser">Confirm</el-button>
                                </span>
                            </el-dialog>
                        </div>
                    </div>
                <!-- END OVERVIEW -->
                </div>
            </div>
            <!-- END MAIN CONTENT -->
        </admin-users>
    </div>
@endsection

@section('scripts')

@endsection