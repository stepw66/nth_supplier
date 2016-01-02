@extends('layouts.default')

@section('content')


<div class="row">
	<div class="col-lg-12">
		
		<div class="row">
		<div class="col-lg-12">
			<ul class="breadcrumb">
			    <li><a href="{!! url('/') !!}">หน้าหลัก</a></li>
			    <li class="active">รายการบเิกพัสดุ</li>
			</ul>
		</div>
		</div>		

		<div class="row">
		<div class="col-lg-12">
			<div class="dataTables_wrapper no-footer">                
			<table id="listissueorder-data" class="table table-responsive table-striped table-hover table-bordered dataTable no-footer" role="grid">
	        <thead>
	            <tr>
	                <th>ลำดับ</th>
	                <th>รอบ</th>
	                <th>วันที่เบิก(ว-ด-ป)</th>
                    <th>แผนก</th>
	                <th>ผู้เบิก</th>
	                <th>ราคารวม</th>	
	                <th>สถานะจ่าย</th> 					
	                <th>ดำเนินการ</th>					
	            </tr>
	        </thead>        
	        <tbody>           	
	            <?php $i=0; ?>              
	            @foreach($data as $key => $value)
	             <?php $i++;  ?>
	                <tr>
	                    <td>{{ $i }}</td>  
	                    <td>{{ $value->approve_q }}</td>
	                    <td><?php echo date("d-m", strtotime($value->issue_date)).'-'.(date("Y", strtotime($value->issue_date))+543); ?></td>  
	                    <td>{{ $value->dep_name }}</td>
                        <td>{{ $value->fullname }}</td>                        	                   
	                    <td>{{ $value->issue_total_price }}</td> 
	                    <td>
	                    	@if( $value->approve_date == '' )
								<span class="text-danger">ยังไม่จ่าย</span>
	                    	@endif
	                    	@if( $value->approve_date != '' )	                    		
								<span class="text-info">จ่ายแล้ว</span>
	                    	@endif
	                    </td> 						
	                    <td> 	                    	                        	 
	                        <a href="{{ url( 'showIssue', e($value->id) ) }}" >
                                <div class="icon-preview"><i class="mdi-action-search"></i></div>
	                        </a>
                            @if( $value->approve_date == '' )	
                            <a href="{{ url( 'editIssue/detail', e($value->id) ) }}">
                                <div class="icon-preview"><i class="mdi-editor-mode-edit"></i></div>
	                        </a>
                            @endif
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
