@extends('layouts.app')
@section('content')

	
	@if($analytic)
		
		@if($analytic->accountid)


		@else
			<div class="row">
				@foreach($accounts as $account)
				@if(@$account && @$account->items)
				<div class="col-md-4 col-sm-6">
					<a href="javascript:void(0)" class="data_box">
						@foreach($account->items as $item)
						<p>{{ $item->name }}</p>
						<p>{{ $item->websiteUrl }}</p>
						<p>{{ $item->id }}</p>
							@if(@$item->defaultProfileId)
							<p class="accountId">{{ $item->defaultProfileId }}</p>
							@else
							<p style="color:red">Profile Id Not Get</p>
							@endif
						@endforeach
					</a>
				</div>
				@endif
				@endforeach
			</div>
			

			{!! Form::model($analytic, ['route' => ['connect.update', $analytic->id], 'method' => 'PATCH', 'id' => 'select-account', 'style'=>'display: none;']) !!}
			{!! Form::close() !!}
		@endif

		<a title="Delete" data-method="Delete" data-confirm="Are you sure?" href="{{ route('connect.destroy', $analytic->id) }}" class="btn btn-danger btn-lg btn-block">Remove Google Analytic Account</a>
	@else
		<a href="{{ route('google.oauth') }}" class="btn btn-success btn-lg btn-block">Connect with Google Analytic</a>
	@endif


@endsection

@section('script')
<script>
jQuery('.data_box').on('click', function(){
	var accountId = jQuery(this).find('.accountId').html();

	if($.isNumeric(accountId)){
		var form$ = $("#select-account");
		// insert the accountId into the form so it gets submitted to the server
		form$.append("<input type='hidden' name='accountid' value='" + accountId + "' />");
		// and submit
		form$.get(0).submit();
	}
	else {
		alert('Analytic Profile Id Not Get.');
	}
});
</script>
@endsection