@extends('layouts.default')

@section('content')


<div class="row">
	<div class="col-lg-12">
		
		<div class="row">
		<div class="col-lg-12">
			<ul class="breadcrumb">
			    <li><a href="{!! url('/') !!}">หน้าหลัก</a></li>
			    <li class="active">จัดการหน่วยนับพัสดุ</li>
			</ul>
		</div>
		</div>

		<div class="row">
		<div class="col-lg-12">
			<a href="{!! route('unit.create') !!}" class="btn btn-success btn-fab btn-raised mdi-content-add"></a>
		</div>
		</div>

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
		@endif

		<div class="row">
		<div class="col-lg-12">
			<div class="dataTables_wrapper no-footer">                
			<table id="unit-data" class="table table-responsive table-striped table-hover table-bordered dataTable no-footer" role="grid">
	        <thead>
	            <tr>
	                <th>ลำดับ</th>
	                <th>ชื่อหน่วยนับ</th>
	                <th>ดำเนินการ</th>
	            </tr>
	        </thead>        
	        <tbody>           	
	            <?php $i=0; ?>              
	            @foreach($data as $key => $value)
	             <?php $i++;  ?>
	                <tr>
	                    <td>{{ $i }}</td>   
	                    <td>{{ $value->unit_name }}</td>                        
	                    <td>                           	 
	                        <a class="" href="{{ route( 'unit.edit', e($value->id) ) }}">
	                            <i class="mdi-content-create mdi-material-teal"></i>
	                        </a>
	                        <a class="btn-unit-delete" href="{{ route( 'unit.destroy', e($value->id) ) }}" data-method="delete" data-confirm="ต้องการลบ {{ e($value->unit_name) }}" data-remote="false" rel="nofollow">
	                            <i class="mdi-action-delete mdi-material-red"></i>
	                        </a>
	                    </td>
	                </tr>           
	            @endforeach
	        </tbody>
	        </table>
		    </div><!-- .dataTables_wrapper -->
		</div>
		</div>
				
	</div>
</div>


@endsection