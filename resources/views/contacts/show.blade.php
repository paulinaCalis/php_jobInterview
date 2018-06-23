@extends('layouts.contact')

@section('title')
	Details
@endsection

@section('content')
	<div class="row">
		<!-- left column -->
		<a href="{{ route('index') }}" style="font-size:17px; border:none;"><img src="/../images/goBack.png" style="width:175px; height:100px;" /></a>
		<br /><br /><br />
		<div class="col-md-3">
			<div class="text-center">
				<img src="/../uploads/profile_images/{{ $contact->profile_image }}" class="avatar img-circle" alt="avatar" style="width:200px; height:200px;">
			</div>
		</div>
      
		<!-- show form column -->
		<div class="col-md-9 personal-info">
			<form class="form-horizontal" role="form">
				<div class="form-group">
					<label class="col-lg-3 control-label">First name:</label>
					<div class="col-lg-8">
						<input id="first_name" name="first_name" class="form-control" value="{{ $contact->first_name }}" disabled>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label">Last name:</label>
					<div class="col-lg-8">
						<input id="last_name" name="last_name" class="form-control" value="{{ $contact->last_name }}" disabled>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label">Email:</label>
					<div class="col-lg-8">
						<input id="email" name="email" class="form-control" value="{{ $contact->email }}" disabled>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label">Favorite:</label>
					<div class="col-lg-8" style="margin-top:8px;">
					<input type="checkbox" id="favorite" name="favorite" @if($contact->favorite == 'yes') checked @endif disabled /> 
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label">Numbers:</label>
					<div class="col-lg-8">
						<table class="table table-striped" id="table_phones">
						@foreach( $contact->phones as $phone )
							<tr>
								<td>
									<input type="text" name="number[]" id="number" class="form-control" value="{{ $phone->number }}" disabled>
								</td>
								<td><input type="text" name="descrption[]" id="descrption" class="form-control" value="{{ $phone->description }}" disabled></td>
							</tr>
						@endforeach
						</table>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label"></label>
					<div class="col-md-8" style="margin-left:8px;">
						<a href="/{{ $contact->id }}/edit">
							<input class="btn btn-warning" value="Edit" type="button" style="width:194px;">
						</a>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<a data-contact_id="{{ $contact->id }}" data-url="{!! URL::route('delete', $contact->id) !!}" data-full_name="{{ $contact->first_name.' '.$contact->last_name }}" data-toggle="modal" data-target="#custom-width-modal" class="btn btn-default remove-contact" style="width:194px;">
							Delete
						</a>
					</div>
				</div>
			</form>
		</div>
  </div>
@endsection