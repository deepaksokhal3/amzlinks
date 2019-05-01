@extends('layouts.admin')
@section('content')
<!-- Main content -->
<main class="main">
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{URL::to('/admin')}}">Dashboard</a></li>
        <li class="breadcrumb-item active">Manage Users</li>
        <li class="breadcrumb-menu d-md-down-none">
            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                <a class="btn" href="#"><i class="icon-speech"></i></a>
                <a class="btn" href="{{URL::to('/admin')}}"><i class="icon-graph"></i> &nbsp;Dashboard</a>
                <a class="btn" href="#"><i class="icon-settings"></i> &nbsp;Settings</a>
            </div>
        </li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Users
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-striped table-bordered datatable">
                        <thead>
                            <tr>
                                <th class="text-center">Name</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Plan</th>
                                <th class="text-center">Date registered</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($users) > 0) @foreach($users as $user)
                            <tr>
                                <td class="text-center">{{ucfirst($user->name)}}</td>
                                <td class="text-center">{{$user->email}}</td>
                                <td class="text-center">
                                    @if(count($user->userSubscription)>0)
                                    <div class="pmt-sts small text-muted">Premium</div>
                                 <span class="badge badge-success">{{ $user->userSubscription->name}}</span>
                                @else
                                 <span class="badge badge-success"> Trail</span>
                                @endif
                            </td>
                                <td class="text-center">{{date('d M, Y', strtotime($user->created_at))}}</td>
                                <td class="text-center">
                                    @if($user->is_active ==1)
                                    <span class="badge badge-success">Active</span> @else
                                    <span class="badge badge-danger">Deactivated</span> @endif
                                </td>
                                <td class="text-center">
                                    <a class="btn btn-success" href="{{URL::to('/admin/campaigns/detail/'.$user->id)}}">

                                        <i class="fa fa-search-plus "></i>
                                    </a>
                                    <a class="btn btn-info" href="{{ URL::to('/admin/users/'.$user->id) }}">
                                        <i class="fa fa-edit "></i>
                                    </a>
                                    <a class="btn btn-danger" href="javascript:;" data-target="{{$user->is_active}}" onclick="changeUserStatus({{$user->id}}, this)">
                                        <i class="fa {{ $user->is_active ==1? 'fa-unlock':'fa-lock'}}"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach @endif
                        </tbody>
                    </table>
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</main>
@endsection