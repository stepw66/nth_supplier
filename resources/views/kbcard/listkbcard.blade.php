@extends('layouts.default')

@section('content')


<div class="row">
	<div class="col-lg-12">
		
		<div class="row">
		<div class="col-lg-12">
			<ul class="breadcrumb">
			    <li><a href="{!! url('/') !!}">หน้าหลัก</a></li>			 
			    <li class="active">รายการ Kumbuk Card</li>
			</ul>
		</div>
		</div>
		<br />
        
        <div class="row">
            <div class="col-lg-12">
                
				<div class="dataTables_wrapper no-footer">                
				<table id="listkbcard-data" class="table table-responsive tableall table-striped table-hover table-bordered dataTable no-footer" role="grid">
		        <thead>
		            <tr>
		                <th>ลำดับ</th>
		                <th>แผนก</th>
		                <th>รายการ</th>
		                <th>จำนวนมากสุด</th>	               
		                <th>จำนวนต่ำสุด</th>
		                <th>#</th>
		            </tr>
		        </thead>        
		        <tbody>           	
		            <?php $i=0; ?>              
		            @foreach($data as $key => $value)
		             <?php $i++;  ?>
		                <tr>
		                    <td>{{ $i }}</td>  
		                    <td>{{ $value->dep_name }}</td>  
		                    <td>{{ $value->sp_name }}</td>                        	                   
		                    <td>{{ $value->max_unit }}</td>  
		                    <td>{{ $value->min_unit }}</td>                         
		                    <td>  
		                    	<a class="" href="{{ url( 'kbcardprint', e($value->id) ) }}" title="พิมพ์ใบใหญ่">
	                            	<i class="mdi-action-print mdi-material-blue"></i>
		                        </a> 
								<a class="" href="{{ url( 'kbcardprint_small', e($value->id) ) }}" title="พิมพ์ใบเล็ก">
	                            	<i class="mdi-action-print mdi-material-pink"></i>
		                        </a>                          	 
		                        <a class="" href="{{ route( 'kbcard.edit', e($value->id) ) }}" title="แก้ไข">
	                            	<i class="mdi-content-create mdi-material-teal"></i>
		                        </a>
		                        <a class="btn-supplier-delete" href="{{ route( 'kbcard.destroy', e($value->id) ) }}" title="ลบ" data-method="delete" data-confirm="ต้องการลบ {{ e($value->sp_name) }}" data-remote="false" rel="nofollow">
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
