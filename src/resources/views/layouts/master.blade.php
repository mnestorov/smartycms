<!DOCTYPE html>
<html lang="en">
<head>
	<title>{{ (!empty(SmartyStudio\SmartyCms\Models\Setting::first()) && SmartyStudio\SmartyCms\Models\Setting::first()->title != null) ? SmartyStudio\SmartyCms\Models\Setting::first()->title : 'Smarty CMS | Admin Panel' }}</title>
	<base href="{{ url('/'.config('smartycms.route_prefix')) }}/">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="format-detection" content="telephone=no">
	<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="icon" type="image/png" href="images/favicon.png" />
	@yield('head_meta')
	@yield('styles')
	@section('scripts')
		<script>var _baseUrl = '{{ url('/') }}';</script>
	@show
	@yield('analytics')
</head>
<body>
	@yield('body')
</body>
</html>