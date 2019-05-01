@extends('layouts.app')
@section('content')
<main class="main">
	<!-- Breadcrumb -->
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{URL::to('/')}}">Home</a></li>
		<li class="breadcrumb-item active">Payment</li>
		<li class="breadcrumb-menu d-md-down-none">
			<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
				<a class="btn" href="{{URL::to('/dashboard')}}"><i class="icon-graph"></i> &nbsp;Dashboard</a>
			</div>
		</li>
	</ol>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-6">
				<div class="card-group">
					<div class="card p-4">
						<div class="card-body">
							<form class="form-horizontal" method="POST" id="payment-form" role="form" action="{{route('stripe.postPaymentWithStripe')}}" >
								{{ csrf_field() }}

								<fieldset class="form-group">
									<label>Card Number</label>
									<div class="input-group">
										<span class="input-group-prepend">
											<span class="input-group-text"><i class="fa fa-credit-card"></i></span>
										</span>
										<input type="text" class="form-control {{ $errors->has('card_no') ? ' is-invalid' : '' }}" id="ccn" name="card_no" placeholder="0000 0000 0000 0000" value="{{ old('card_no') }}">
										@if ($errors->has('card_no'))
										<span class="invalid-feedback" role="alert">
											<strong>{{ $errors->first('card_no') }}</strong>
										</span>
										@endif
									</div>
									<small class="text-muted">ex. 9999 9999 9999 9999</small>
								</fieldset>
								<!--/.row-->

								<div class="row">

									<div class="form-group col-sm-4">
										<label for="ccmonth">Month</label>
										<input class="form-control card-expiry-month {{ $errors->has('ccExpiryMonth') ? ' is-invalid' : '' }}" placeholder='MM' size='2' type='text' name="ccExpiryMonth" value="{{ old('ccExpiryMonth') }}">
										@if ($errors->has('ccExpiryMonth'))
										<span class="invalid-feedback" role="alert">
											<strong>{{ $errors->first('ccExpiryMonth') }}</strong>
										</span>
										@endif
									</div>

									<div class="form-group col-sm-4">
										<label for="ccyear">Year</label>
										<input class="form-control card-expiry-year {{ $errors->has('ccExpiryYear') ? ' is-invalid' : '' }}" placeholder='YYYY' size='4' type='text' name="ccExpiryYear" value="{{ old('ccExpiryYear') }}">
										@if ($errors->has('ccExpiryYear'))
										<span class="invalid-feedback" role="alert">
											<strong>{{ $errors->first('ccExpiryYear') }}</strong>
										</span>
										@endif
									</div>

									<div class="col-sm-4">
										<div class="form-group">
											<label for="cvv">CVV/CVC</label>
											<input autocomplete='off' class="form-control {{ $errors->has('cvvNumber') ? ' is-invalid' : '' }}" placeholder='ex. 311' max="4" size='4' type='text' name="cvvNumber" value="{{ old('cvvNumber') }}">
											@if ($errors->has('cvvNumber'))
											<span class="invalid-feedback" role="alert">
												<strong>{{ $errors->first('cvvNumber') }}</strong>
											</span>
											@endif
										</div>

									</div>

								</div>
								<!--/.row-->

								<div class='form-row'>
									<div class='col-md-12'>
										<div class='form-control total btn btn-info'>
											Total:
											<span class='amount'>$ {{$sub->fee}}</span>
										</div>
									</div>
								</div>
								<input type="hidden" name="subId" value="{{ $sub->id }}">
								<div class='form-row'>
									<div class='col-md-12 form-group'>
										<button class='form-control btn btn-primary submit-button' type='submit'>Pay »</button>
									</div>
								</div>
								<input type="hidden" name="amount" value="{{$sub->fee}}" >
								<div class='form-row'>
									<div class='col-md-12 error form-group hide'>
										@if(Session::has('message'))
										<div class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</div>
										@endif
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
@endsection