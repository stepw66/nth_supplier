@extends('layouts.default')

@section('content')


<div class="row">
	<div class="col-lg-12">
		
		<div class="row">
		<div class="col-lg-12">
			<ul class="breadcrumb">
			    <li><a href="{!! url('/') !!}">หน้าหลัก</a></li>
			    <li><a href="{!! url('user') !!}">จัดการผู้ใช้</a></li>
			    <li class="active">แก้ผู้ใช้</li>
			</ul>
		</div>
		</div>
		<br />
		<div class="row">
		<div class="col-lg-10 col-lg-offset-1">
			{!! Form::open( array('route' => ['user.update', e($data->id)], 'class' => 'form-horizontal', 'method' => 'PATCH') ) !!}
				@if($errors->has('fullname'))
				<div class="form-group has-error">
				@else
				<div class="form-group">
				@endif
					<label for="fullname" class="col-lg-2 control-label">ชื่อ-สกุล</label>
					<div class="col-lg-10">
						<input type="text" class="form-control" name="fullname" placeholder="ชื่อ-สกุล" value="{!! $data->fullname !!}" />
					</div>
				</div>
				@if($errors->has('username'))
				<div class="form-group has-error">
				@else
				<div class="form-group">
				@endif
					<label for="username" class="col-lg-2 control-label">ชื่อผู้ใช้งาน</label>
					<div class="col-lg-10">
						<input type="text" class="form-control" name="username" placeholder="ชื่อผู้ใช้งาน" value="{!! $data->username !!}" />
					</div>
				</div>
				@if($errors->has('password'))
				<div class="form-group has-error">
				@else
				<div class="form-group">
				@endif
					<label for="password" class="col-lg-2 control-label">รหัสผ่าน</label>
					<div class="col-lg-10">
						<input type="text" class="form-control" name="password" placeholder="รหัสผ่าน" value="{!! $data->password !!}"/>
					</div>
				</div>
				<div class="form-group">
					<label for="select" class="col-lg-2 control-label">แผนก:</label>
					<div class="col-lg-10">
						{!! Form::select('id_dep', $dep, $data->id_dep, ['class'=> 'form-control']) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">สิทธิ์:</label>
					<div class="col-lg-10">
						<div class="radio radio-primary">
						    <label>
						      {!! Form::radio('level', '3', $data->level == 3, ['class' => '']) !!} 
						      ผู้ใช้ทั่วไป
						    </label>
						  </div>
						<div class="radio radio-primary">
						    <label>
						      {!! Form::radio('level', '2', $data->level == 2, ['class' => '']) !!} 
						      เจ้าหน้าที่พัสดุ
						    </label>
						</div>  
						<div class="radio radio-primary">
						    <label>
						      {!! Form::radio('level', '1', $data->level == 1, ['class' => '']) !!} 
						      ผู้ดูแลระบบ
						    </label>
						 </div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">สถานะ:</label>
					<div class="col-lg-10">
						<div class="radio radio-primary">
						    <label>
						      {!! Form::radio('activated', '1', $data->activated == 1, ['class' => '']) !!}
						      เปิด
						    </label>
						  </div>
						  <div class="radio radio-primary">
						    <label>
						      {!! Form::radio('activated', '0', $data->activated == 0, ['class' => '']) !!}
						      ปิด
						    </label>
						  </div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-lg-10 col-lg-offset-2">
						<a href="{!! route('user.index') !!}" class="btn btn-default">ยกเลิก</a>
						<button type="submit" class="btn btn-success">บันทึก</button>
					</div>
				</div>
			{!! Form::close() !!}<!-- form -->
		</div>
		</div>
					
	</div>
</div>


@endsection