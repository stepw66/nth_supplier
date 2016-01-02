@extends('layouts.default')

@section('content')


<div class="row">
	<div class="col-lg-12">
		
		<div class="row">
		<div class="col-lg-12">
			<ul class="breadcrumb">
			    <li><a href="{!! url('/') !!}">หน้าหลัก</a></li>
			    <li><a href="{!! url('type') !!}">จัดการหน่วยนับพัสดุ</a></li>
			    <li class="active">เพิ่มหน่วย</li>
			</ul>
		</div>
		</div>
		<br />
		<div class="row">
		<div class="col-lg-10 col-lg-offset-1">
			{!! Form::open( array('route' => ['unit.update', e($data->id)], 'class' => 'form-horizontal', 'method' => 'PATCH') ) !!}
				@if($errors->has('unit_name'))
				<div class="form-group has-error">
				@else
				<div class="form-group">
				@endif
					<label for="unit_name" class="col-lg-2 control-label">หน่วย</label>
					<div class="col-lg-10">
						<input type="text" class="form-control" name="unit_name" placeholder="หน่วย" value="{!! $data->unit_name !!}" />
					</div>
				</div>
				<div class="form-group">
					<div class="col-lg-10 col-lg-offset-2">
						<a href="{!! route('unit.index') !!}" class="btn btn-default">ยกเลิก</a>
						<button type="submit" class="btn btn-success">บันทึก</button>
					</div>
				</div>
			{!! Form::close() !!}<!-- form -->
		</div>
		</div>
					
	</div>
</div>


@endsection