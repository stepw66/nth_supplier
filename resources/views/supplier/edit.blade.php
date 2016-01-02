@extends('layouts.default')

@section('content')


<div class="row">
	<div class="col-lg-12">
		
		<div class="row">
		<div class="col-lg-12">
			<ul class="breadcrumb">
			    <li><a href="{!! url('/') !!}">หน้าหลัก</a></li>
			    <li><a href="{!! url('supplier') !!}">จัดการชื่อรายการพัสดุ</a></li>
			    <li class="active">แก้ไขรายการพัสดุ</li>
			</ul>
		</div>
		</div>
		<br />
		<div class="row">
		<div class="col-lg-10 col-lg-offset-1">
			{!! Form::open( array('route' => ['supplier.update', e($data->id)], 'class' => 'form-horizontal', 'method' => 'PATCH') ) !!}

				@if($errors->has('type_code'))
				<div class="form-group has-error">
				@else
				<div class="form-group">
				@endif
					<label for="type_code" class="col-lg-2 control-label">ประเภท:</label>
					<div class="col-lg-10">
						{!! Form::select('type_code', [null=>'กรุณาเลือก'] + $type, $data->type_code, ['class'=> 'form-control', 'id' => 'type_code_i']) !!}
					</div>
				</div>

				@if($errors->has('sp_code'))
				<div class="form-group has-error">
				@else
				<div class="form-group">
				@endif
					<label for="sp_code" class="col-lg-2 control-label">รหัส</label>
					<div class="col-lg-10">
						<input type="text" class="form-control" name="sp_code" id="sp_code_i" placeholder="รหัส" value="{!! $data->sp_code !!}" />
					</div>
				</div>

				@if($errors->has('sp_name'))
				<div class="form-group has-error">
				@else
				<div class="form-group">
				@endif
					<label for="sp_name" class="col-lg-2 control-label">ชื่อพัสดุ</label>
					<div class="col-lg-10">
						<input type="text" class="form-control" name="sp_name" placeholder="ชื่อพัสดุ" value="{!! $data->sp_name !!}" />
					</div>
				</div>
				
				@if($errors->has('id_unit'))
				<div class="form-group has-error">
				@else
				<div class="form-group">
				@endif
					<label for="id_unit" class="col-lg-2 control-label">หน่วย:</label>
					<div class="col-lg-10">
						{!! Form::select('id_unit', [null=>'กรุณาเลือก'] + $unit, $data->id_unit, ['class'=> 'form-control']) !!}
					</div>
				</div>
				
				<div class="form-group">
					<div class="col-lg-10 col-lg-offset-2">
						<a href="{!! route('supplier.index') !!}" class="btn btn-default">ยกเลิก</a>
						<button type="submit" class="btn btn-success">บันทึก</button>
					</div>
				</div>
			{!! Form::close() !!}<!-- form -->
		</div>
		</div>
					
	</div>
</div>


@endsection