@extends('layouts.default')

@section('content')


<div class="row">
	<div class="col-lg-12">
		
		<div class="row">
		<div class="col-lg-12">
			<ul class="breadcrumb">
			    <li><a href="{!! url('/') !!}">หน้าหลัก</a></li>
			    <li><a href="{!! url('type') !!}">จัดการรอบเบิกพัสดุ</a></li>
			    <li class="active">เพิ่มรอบ</li>
			</ul>
		</div>
		</div>
		<br />
		<div class="row">
		<div class="col-lg-10 col-lg-offset-1">
			{!! Form::open( array('route' => 'around.store', 'class' => 'form-horizontal') ) !!}
				@if($errors->has('around'))
				<div class="form-group has-error">
				@else
				<div class="form-group">
				@endif
					<label for="around" class="col-lg-2 control-label">รอบ</label>
					<div class="col-lg-10">
						<input type="text" class="form-control" name="around" placeholder="รอบ"/>
					</div>
				</div>
                @if($errors->has('around'))
				<div class="form-group has-error">
				@else
				<div class="form-group">
				@endif
					<label for="around_date" class="col-lg-2 control-label">วันที่เบิก(ว-ด-ป)</label>
					<div class="col-lg-10">
						<input type="text" class="form-control" id="around_date" name="around_date" placeholder="วันที่เบิก"/>
					</div>
				</div>
				<div class="form-group">
					<div class="col-lg-10 col-lg-offset-2">
						<a href="{!! route('around.index') !!}" class="btn btn-default">ยกเลิก</a>
						<button type="submit" class="btn btn-success">บันทึก</button>
					</div>
				</div>
			{!! Form::close() !!}<!-- form -->
		</div>
		</div>
					
	</div>
</div>


@endsection