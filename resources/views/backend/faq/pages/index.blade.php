 @extends('layouts.admin')
 @section('content')

<!-- Main content -->
<main class="main">
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{URL::to('/admin')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{URL::to('/admin/users')}}">Manage Users</a></li>
        <li class="breadcrumb-item active">FAQ Pages</li>
        <li class="breadcrumb-menu d-md-down-none">
            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                <a class="btn" href="{{URL::to('/admin')}}"><i class="icon-graph"></i> &nbsp;Dashboard</a>
            </div>
        </li>
    </ol>
	<div class="container-fluid">
		<div class="animated fadeIn">
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
					@include('backend.faq.pages.'.$title->active)
					<div class="card">
						<div class="card-header">
					        <i class="fa fa-align-justify"></i> FAQ Pages
				      	</div>
				      	<div class="card-body">
					        <table class="table table-responsive-sm table-striped">
					          <thead>
					            <tr>
					              <th>Title</th>
					              <th>Catagory</th>
					              <th class="text-center">Created At</th>
					              <th class="text-center">Action</th>
					            </tr>
					          </thead>
					          <tbody>
					          	@if(count($pages))
					          		@foreach($pages as $page)
					          		<tr>
					          			<td>{{$page->title}}</td>
					          			<td>{{$page->getCatagories->name}}</td>
					          			<td class="text-center">{{$page->created_at->format('M d, Y')}}</td>
					          			<td class="text-center"><a href="{{ route('page.edit', $page->id)}}" class="btn btn-info"> <i class="fa fa-edit"></i></a>
					          				<a href="{{ route('page.destroy', $page->id)}}" class="btn btn-danger"  title="Delete"> <i class="fa fa-trash"></i></a>
					          			</td>
					          		</tr>

					          		@endforeach
					          	@endif
					          </tbody>
					      </table>
				  	</div>
				  	{{$pages->links()}}
				</div>
			</div>
		</div>
	</div>
</main>
@endsection
@section('scripts')
<script>
	$(document).ready(function() {
	    $('.faq-text-editer').summernote({
		  	tabsize: 2,
			height: 400,
			disableResizeEditor: true,
			 popover: {
	         image: [],
	         link: [],
	         air: []
	       }
	    });
	});
</script>
@endsection