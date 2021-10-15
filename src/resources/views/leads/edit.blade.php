@extends('admin::layouts.admin')

@section('admin-content')
	<div class="admin-header">
		<h1>Edit lead</h1>
		<span class="last-update"></span>
	</div>

	<div class="admin-content">
		@foreach ($data as $key => $element)
			<label>{{ $key }}</label>
			<input disabled type="text" name="{{ $key }}" value="{{ $element }}">
			@if (!filter_var($element, FILTER_VALIDATE_EMAIL) === false)
				<?php $email = $element; ?>
			@endif
		@endforeach
		<a href="leads/delete/{{ $lead->id }}" class="button remove-item" style="margin:0">Delete lead</a>
		<ul>
			@foreach (SmartyStudio\SmartyCms\Models\LeadMailed::whereEmail($email)->get() as $mailed)
				<li><a href="leads/edit-email/{{$mailed->id}}"><b>{{ $mailed->email }} :: {{ $mailed->subject }}</a></li>
			@endforeach
		</ul>
	</div>
@endsection