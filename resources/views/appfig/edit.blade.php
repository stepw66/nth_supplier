@extends('layouts.default')

@section('content')


<div class="row">
	<div class="col-lg-12">
		
		<div class="row">
		<div class="col-lg-12">
			<ul class="breadcrumb">
			    <li><a href="{!! url('/') !!}">หน้าหลัก</a></li>
			    <li class="active">ข้อมูลหน่วยงาน</li>
			</ul>
		</div>
		</div>
		<br />
		@if(Session::has('savedata'))
		<br />	
		<div class="row">
		<div class="col-lg-12">
			<div class="alert alert-dismissable alert-success">         			  
				<button type="button" class="close" data-dismiss="alert">×</button>	  
			    <span>{{ e(Session::get('savedata')) }}</span>
			</div>
		</div>
		</div>
		<br />
		@endif
		<div class="row">
		<div class="col-lg-10 col-lg-offset-1">
			{!! Form::open( array('route' => ['appfig.update', '1'], 'class' => 'form-horizontal', 'method' => 'PATCH') ) !!}
				@if($errors->has('address'))
				<div class="form-group has-error">
				@else
				<div class="form-group">
				@endif
					<label for="address" class="col-lg-2 control-label">ที่อยู่</label>
					<div class="col-lg-10">
						<input type="text" class="form-control" name="address" placeholder="ชื่อ-สกุล" value="{!! $data->address !!}" />
					</div>
				</div>
				<div class="form-group">
					<div class="col-lg-10 col-lg-offset-2">
						<button type="submit" class="btn btn-success">บันทึก</button>
					</div>
				</div>
			{!! Form::close() !!}<!-- form -->
		</div>
		</div>
					
	</div>
</div>


@endsection