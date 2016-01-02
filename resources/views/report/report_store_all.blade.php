@extends('layouts.default')

@section('content')


<div class="row">
	<div class="col-lg-12">
		
		<div class="row">
		<div class="col-lg-12">
			<ul class="breadcrumb">
			    <li><a href="{!! url('/') !!}">หน้าหลัก</a></li>
			    <li><a href="#!">รายงาน</a></li>
			    <li class="active">สรุปรายการพัสดุคงคลัง</li>
			</ul>
		</div>
		</div>
		<br />
		<div class="row">
		<div class="col-lg-10 col-lg-offset-1">
			
            <form class="form-horizontal">
					<div class="form-group">
					  <div class="center">
						<input type="button" class="btn btn-info btn-sm" value="ออกรายงาน" />
					  </div>
					</div>	
            </form>
            
		</div>
		</div>
					
	</div>
</div>


@endsection