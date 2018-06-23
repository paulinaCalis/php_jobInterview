@extends('layouts.master')

@section('title')
	All contacts
@endsection

@section('content')
	
	@foreach($contacts as $contact)
    <tr>
      <td align="center"><img src="/../uploads/profile_images/{{ $contact->profile_image }}" style="width:25px; height:25px;"/></td>
      <td>{{ $contact->first_name.' '.$contact->last_name }}</td>
      <td>
        <a href="/{{ $contact->id }}"><img src="/../images/about.png" style="width:16px; height:16px;" title="About" /></a>
      </td>
      <td>
        <a href="/{{ $contact->id }}/edit"><img src="/../images/edit.png" style="width:16px; height:16px;" title="Edit" /></a>
      </td>
      <td>
        <a href="/" class="favorite" data-contact_id="{{ $contact->id }}" data-favorite="{{ $contact->favorite }}"><img src="/../images/favorite_{{ $contact->favorite }}.png" style="width:16px; height:16px;" /></a>
      </td>
      <td>
        <a data-contact_id="{{ $contact->id }}" data-url="{!! URL::route('delete', $contact->id) !!}" data-full_name="{{ $contact->first_name.' '.$contact->last_name }}" data-toggle="modal" data-target="#custom-width-modal" class="remove-contact">
          <img src="/../images/delete.png" style="width:16px; height:16px;" title="Delete" />
        </a>
      </td>
    </tr>
	@endforeach
	
@endsection