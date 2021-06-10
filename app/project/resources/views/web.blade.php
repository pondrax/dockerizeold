<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
	<title>{{env('APP_NAME')}}</title>
	<link rel="stylesheet" href="{{ mix('css/web.css') }}">
</head>
<body>
	<div id="app"></div>
	<script>
		const config = {
			name	: "{{ env('APP_NAME') }}",
			url		: "{{ env('APP_URL') }}",
			version	: "{{ env('APP_VER') }}",
		};
	</script>
	<script src="{{ mix('js/web.js') }}"></script>
</body>
</html>
