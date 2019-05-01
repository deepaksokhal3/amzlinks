
@extends('layouts.admin')
@section('content')
<main class="main">
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{URL::to('/admin')}}">Dashboard</a></li>
        <li class="breadcrumb-item active">Manage Campaigns</li>
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
                    <i class="fa fa-align-justify"></i> Campaigns
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-striped table-bordered datatable">
                        <thead>
                            <tr>
                                <th class="text-center">Name</th>
                                <th class="text-center">Tracking Links</th>
                                <th class="text-center">Creation</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($campaigns) > 0) @foreach($campaigns as $campaign)
                            <tr>
                                <td class="text-center">{{ucfirst($campaign->campaignName)}}</td>
                                <td class="text-center">{{ count($campaign->countTakingLinks)}}</td>
                                <td class="text-center">{{$campaign->created_at->format('M d, Y')}}</td>
                                <td class="text-center">
                                    <a class="btn btn-success" href="{{URL::to('/admin/campaigns/single/'.$campaign->id)}}">
                                        <i class="fa fa-eye "></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach @endif
                        </tbody>
                    </table>
                    {{ $campaigns->links() }}
                </div>
            </div>
        </div>
    </div>
</main>
@endsection