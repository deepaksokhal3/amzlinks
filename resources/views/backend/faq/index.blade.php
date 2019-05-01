 @extends('layouts.admin')
 @section('content')

<!-- Main content -->
<main class="main">
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{URL::to('/admin')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{URL::to('/admin/users')}}">Manage Users</a></li>
        <li class="breadcrumb-item active">FAQ Catagory</li>
        <li class="breadcrumb-menu d-md-down-none">
            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                <a class="btn" href="{{URL::to('/admin')}}"><i class="icon-graph"></i> &nbsp;Dashboard</a>
            </div>
        </li>
    </ol>
	<div class="container-fluid">
		<div class="animated fadeIn">
			<div class="row">
				<div class="col-sm-6">
					@if(session('success'))
	                    <div class="alert alert-success alert-block text-left">
	                        <button type="button" class="close" data-dismiss="alert">×</button>
	                        <strong>{{session('success')}}</strong>
	                    </div>
                    @endif
                    @if(session('error'))
	                    <div class="alert alert-danger alert-block text-left">
	                        <button type="button" class="close" data-dismiss="alert">×</button>
	                        <strong>{{session('error')}}</strong>
	                    </div>
                    @endif
					@include('backend.faq.'.$title->active)
				</div>
				<div class="col-sm-6">
					<div class="card">
						<div class="card-header">
					        <i class="fa fa-align-justify"></i> FAQ Catagories
				      	</div>
				      	<div class="card-body">
					        <table class="table table-responsive-sm table-striped">
					          <thead>
					            <tr>
					              <th>Title</th>
					              <th class="text-center">Created At</th>
					              <th class="text-center">Action</th>
					            </tr>
					          </thead>
					          <tbody>
					          	@if(count($faqCatagories))
					          		@foreach($faqCatagories as $catagory)
					          		<tr>
					          			<td>{{$catagory->name}}</td>
					          			<td class="text-center">{{$catagory->created_at->format('M d, Y')}}</td>
					          			<td class="text-center"><a href="{{ route('faq.edit', $catagory->id)}}" class="btn btn-info"> <i class="fa fa-edit"></i></a>
					          				<a href="{{ route('faq.destroy', $catagory->id)}}" class="btn btn-danger"  title="Delete" data-method="Delete" data-confirm="Are you sure?"> <i class="fa fa-trash"></i></a>
					          			</td>
					          		</tr>

					          		@endforeach
					          	@endif
					          </tbody>
					      </table>
					  	</div>
				  	</div>
				</div>
			</div>
		</div>
	</div>
</main>
@endsection