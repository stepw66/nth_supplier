<!doctype html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
	@include('includes.head')
</head>
<body>
	
	@include('includes.header')
	
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="main-content">
					@yield('content')
				</div>
			</div>
		</div>	
	</div>
	
	@include('includes.footer')
	@include('includes.script')	

</body>
</html>