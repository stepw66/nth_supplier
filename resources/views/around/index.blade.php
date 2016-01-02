@extends('layouts.default')

@section('content')


<div class="row">
	<div class="col-lg-12">
		
		<div class="row">
		<div class="col-lg-12">
			<ul class="breadcrumb">
			    <li><a href="{!! url('/') !!}">หน้าหลัก</a></li>
			    <li class="active">จัดการรอบเบิกพัสดุ</li>
			</ul>
		</div>
		</div>

		<div class="row">
		<div class="col-lg-12">
			<a href="{!! route('around.create') !!}" class="btn btn-success btn-fab btn-raised mdi-content-add"></a>
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
			<table id="around-data" class="table table-responsive table-striped table-hover table-bordered dataTable no-footer" role="grid">
	        <thead>
	            <tr>
	                <th>ลำดับ</th>
	                <th>รอบ</th>
                    <th>วันที่เบิก</th>
	                <th>ดำเนินการ</th>
	            </tr>
	        </thead>        
	        <tbody>           	
	            <?php $i=0; ?>              
	            @foreach($data as $key => $value)
	             <?php $i++;  ?>
	                <tr>
	                    <td>{{ $i }}</td>   
	                    <td>{{ $value->around }}</td> 
                        <td><?php echo date("d-m", strtotime($value->around_date)).'-'.(date("Y", strtotime($value->around_date))+543); ?></td> 
	                    <td>                           	 
	                        <a class="" href="{{ route( 'around.edit', e($value->id) ) }}">
	                            <i class="mdi-content-create mdi-material-teal"></i>
	                        </a>
	                        <a class="btn-unit-delete" href="{{ route( 'around.destroy', e($value->id) ) }}" data-method="delete" data-confirm="ต้องการลบ {{ e($value->around) }}" data-remote="false" rel="nofollow">
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