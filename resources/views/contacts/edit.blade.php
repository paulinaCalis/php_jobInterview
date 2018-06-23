@extends('layouts.contact')

@section('title')
	Edit contact
@endsection

@section('content')
	<div class="row">
		<!-- left column -->
		<a href="{{ URL::previous() }}" style="font-size:17px; border:none;"><img src="/../images/goBack.png" style="width:175px; height:100px;" /></a>
		<br /><br /><br />
      
		<!-- edit form column -->
		<form class="form-horizontal" method="post" action="{{ route('update', [$contact->id]) }}" enctype="multipart/form-data">
			{{ csrf_field() }}
			<input type="hidden" name="_method" value="put">
			<div class="col-md-3">
				<div class="text-center">
					<img src="/../uploads/profile_images/{{ $contact->profile_image }}" class="avatar img-circle" alt="avatar" style="width:200px; height:200px;">		
					<input class="form-control" type="file" name="profile_image" value="{{ $contact->profile_image }}">
				</div>
			</div>
			<div class="col-md-9 personal-info">
				<div class="form-group">
					<label class="col-lg-3 control-label">First name:<span class="required">*<span></label>
					<div class="col-lg-8">
						<input id="first_name" required name="first_name" class="form-control" value="{{ $contact->first_name }}" placeholder="first name">
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label">Last name:<span class="required">*<span></label>
					<div class="col-lg-8">
						<input id="last_name" required name="last_name" class="form-control" value="{{ $contact->last_name }}" placeholder="last name">
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label">Email:<span class="required">*<span></label>
					<div class="col-lg-8">
						<input id="email" required name="email" class="form-control" value="{{ $contact->email }}" placeholder="you@email.com">
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label">Favorite:</label>
					<div class="col-lg-8" style="margin-top:8px;">
						<input type="checkbox" id="favorite" name="favorite" @if($contact->favorite == 'yes') checked @endif /> 
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-3 control-label">Numbers:</label>
					<div class="col-lg-8">
						<table class="table table-striped" id="table_phones">
						@foreach( $contact->phones as $phone )
							<tr id="[]">
								<td>
									<input id="phone_id" type="hidden" name="phone_id[]" value="{{ $phone->id }}" />
									<input type="text" required name="number[]" id="number" class="form-control" placeholder="enter number" value="{{ $phone->number }}">
								</td>
								<td><input type="text" required name="description[]" id="description" class="form-control" placeholder="description number" value="{{ $phone->description }}"></td>
								<td headers="delete_number"><span name="delete_number[]"><img src="/../images/remove.png" style="width:25px; height:25px;" /></span></td>
							</tr>
						@endforeach
						</table>
					</div>
					<label class="col-lg-3 control-label"></label>
					<div class="col-lg-8">
						<button id="btn_add_number" type="button" class="btn btn-basic"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add number</button> 
					</div><br /><br />
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label"></label>
					<div class="col-md-8" style="margin-left:8px;">
						<a href="{{ URL::route('index') }}" class="btn btn-default" style="width:173px;">Cancel</a>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="submit" class="btn btn-primary" value="Save" style="width:173px;">
					</div>
				</div>
			</div>
		</form>
  </div>
@endsection