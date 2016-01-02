@extends('layouts.default')

@section('content')


<div class="row">
	<div class="col-lg-12">
		
		<div class="row">
		<div class="col-lg-12">
			<ul class="breadcrumb">
			    <li><a href="{!! url('/') !!}">หน้าหลัก</a></li>
			    <li><a href="{!! url('company') !!}">จัดการบริษัท</a></li>
			    <li class="active">เพิ่มบริษัท</li>
			</ul>
		</div>
		</div>
		<br />
		<div class="row">
		<div class="col-lg-10 col-lg-offset-1">
			{!! Form::open( array('route' => ['company.update', e($data->id)], 'class' => 'form-horizontal', 'method' => 'PATCH') ) !!}
				@if($errors->has('company'))
				<div class="form-group has-error">
				@else
				<div class="form-group">
				@endif
					<label for="company" class="col-lg-2 control-label">บริษัท</label>
					<div class="col-lg-10">
						<input type="text" class="form-control" name="company" placeholder="ชื่อบริษัท" value="{{ $data->company }}" />
					</div>
				</div>
				<div class="form-group">
					<label for="address" class="col-lg-2 control-label">ที่อยู่</label>
					<div class="col-lg-10">
						<input type="text" class="form-control" name="address" placeholder="ที่อยู่" value="{{ $data->address }}"/>
					</div>
				</div>
                <div class="form-group">
					<label for="mobile" class="col-lg-2 control-label">เบอร์โทร</label>
					<div class="col-lg-10">
						<input type="text" class="form-control" name="mobile" placeholder="เบอร์โทร" value="{{ $data->mobile }}"/>
					</div>
				</div>
                <div class="form-group">
					<label for="email" class="col-lg-2 control-label">Email</label>
					<div class="col-lg-10">
						<input type="text" class="form-control" name="email" placeholder="Email" value="{{ $data->email }}"/>
					</div>
				</div>
				<div class="form-group">
					<div class="col-lg-10 col-lg-offset-2">
						<a href="{!! route('company.index') !!}" class="btn btn-default">ยกเลิก</a>
						<button type="submit" class="btn btn-success">บันทึก</button>
					</div>
				</div>
			{!! Form::close() !!}<!-- form -->
		</div>
		</div>
					
	</div>
</div>


@endsection