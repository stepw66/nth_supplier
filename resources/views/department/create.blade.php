@extends('layouts.default')

@section('content')


<div class="row">
	<div class="col-lg-12">
		
		<div class="row">
		<div class="col-lg-12">
			<ul class="breadcrumb">
			    <li><a href="{!! url('/') !!}">หน้าหลัก</a></li>
			    <li><a href="{!! url('department') !!}">จัดการแผนก</a></li>
			    <li class="active">เพิ่มแผนก</li>
			</ul>
		</div>
		</div>
		<br />
		<div class="row">
		<div class="col-lg-10 col-lg-offset-1">
			{!! Form::open( array('route' => 'department.store', 'class' => 'form-horizontal') ) !!}
				@if($errors->has('dep_name'))
				<div class="form-group has-error">
				@else
				<div class="form-group">
				@endif
					<label for="dep_name" class="col-lg-2 control-label">ชื่อแผนก</label>
					<div class="col-lg-10">
						<input type="text" class="form-control" name="dep_name" placeholder="ชื่อแผนก"/>
					</div>
				</div>
				<div class="form-group">
					<div class="col-lg-10 col-lg-offset-2">
						<a href="{!! route('department.index') !!}" class="btn btn-default">ยกเลิก</a>
						<button type="submit" class="btn btn-success">บันทึก</button>
					</div>
				</div>
			{!! Form::close() !!}<!-- form -->
		</div>
		</div>
					
	</div>
</div>


@endsection