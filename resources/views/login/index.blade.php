<!doctype html>
<html>
<head>
	@include('includes.head')
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4">	
				<div class="text-header-login">
					ระบบเบิกพัสดุ โรงพยาบาลโนนไทย
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4">
				<div class="shadow-z-1 loginbox">							
				{!! Form::open( array('route' => 'login.store', 'class' => 'form-horizontal') ) !!}
					<fieldset>
					<legend>
						<div class="box-line">
							<div class="f-legend">
								เข้าสู่ระบบ
								<div class="line-h"></div>
							</div>
						</div>
					</legend>
					@if(Session::has('error'))			
			        <div class="alert alert-dismissable alert-danger">         			  
			            <button type="button" class="close" data-dismiss="alert">×</button>
						<strong>เกิดข้อผิดพลาด!</strong>
						{{ e(Session::get('error')) }}
			        </div>
			        @endif

					<div class="form-group">
						<label for="username" class="col-lg-4 control-label">ชื่อผู้ใช้งาน</label>
						<div class="col-lg-8">
							<input type="text" name="username" id="username" class="form-control" placeholder="ชื่อผู้ใช้งาน">
						</div>
					</div>
					<div class="form-group">
						<label for="password" class="col-lg-4 control-label">รหัสผ่าน</label>
						<div class="col-lg-8">
							<input type="password" name="password" id="password" class="form-control" placeholder="รหัสผ่าน">
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-8 col-lg-offset-4">
							<input class="btn btn-success" type="submit" value="ลงชื่อเข้าใช้" name="commit">
						</div>
					</div>
					</fieldset>
				 {!! Form::close() !!}<!-- form -->
				</div>
			</div>		
		</div>
		<div class="row">
			<div class="col-md-4 col-md-offset-4">	
				<div class="text-footer-login">
					© 2015 ThemeSanasang, All rights reserved.
				</div>
			</div>
		</div>
	</div>

@include('includes.script')	

</body>
</html>