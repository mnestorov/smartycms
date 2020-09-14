<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<title>{{ (!empty(SmartyStudio\SmartyCms\Models\Setting::first()) && SmartyStudio\SmartyCms\Models\Setting::first()->title != null) ? SmartyStudio\SmartyCms\Models\Setting::first()->title : 'SmartyCMS | Admin Panel' }}</title>
		<base href="{{ url('/'.config('smartycms.route_prefix')) }}/">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
		<meta charset="utf-8">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<link rel="icon" type="image/png" href="images/favicon.png" />
		@yield('styles')
	</head>
	<body>
		@yield('content')

		@yield('analytics')
		
		<script type="text/javascript">
			var _baseUrl = '{{ url('/') }}';
		</script>

		@yield('scripts')
	</body>
</html>