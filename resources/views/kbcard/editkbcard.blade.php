@extends('layouts.default')

@section('content')


<div class="row">
	<div class="col-lg-12">
		
		<div class="row">
		<div class="col-lg-12">
			<ul class="breadcrumb">
			    <li><a href="{!! url('/') !!}">หน้าหลัก</a></li>			 
			    <li class="active">แก้ไข Kumbuk Card</li>
			</ul>
		</div>
		</div>
		<br />
        
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1">
                {!! Form::open( array('route' => ['kbcard.update', e($data->id)], 'class' => 'form-horizontal', 'method' => 'PATCH') ) !!}  
					<div class="form-group">
                        <div class="col-lg-12">
							{{ $data->dep_name }}
						</div>				 		
					</div>
					<div class="form-group">
						 <div class="col-lg-12">
							{{ $data->sp_name }}
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-12">
							<input type="text" class="form-control" name="max_unit" value="{{ $data->max_unit }}" placeholder="จำนวนสูงสุด"/>
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-12">
							<input type="text" class="form-control" name="min_unit" value="{{ $data->min_unit }}" placeholder="จำนวนต่ำสุด"/>
						</div>
					</div>
					
					<div class="form-group">
					  <div class="center">
						<input type="submit" class="btn btn-info btn-sm" value="บันทึก" />
						<a href="{!! url('listkbcard') !!}" class="btn btn-success btn-sm">กลับ</a>
					  </div>
					</div>	

				{!! Form::close() !!}<!-- form -->
            </div>
        </div>
				
	</div>
</div>


@endsection
