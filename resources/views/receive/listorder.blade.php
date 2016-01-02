@extends('layouts.default')

@section('content')


<div class="row">
	<div class="col-lg-12">
		
		<div class="row">
		<div class="col-lg-12">
			<ul class="breadcrumb">
			    <li><a href="{!! url('/') !!}">หน้าหลัก</a></li>
			    <li class="active">รายการรับพัสดุ</li>
			</ul>
		</div>
		</div>		

		<div class="row">
		<div class="col-lg-12">
			<div class="dataTables_wrapper no-footer">                
			<table id="listorder-data" class="table table-responsive table-striped table-hover table-bordered dataTable no-footer" role="grid">
	        <thead>
	            <tr>
	                <th>ลำดับ</th>
	                <th>วันที่รับ(ว-ด-ป)</th>
	                <th>ผู้รับ</th>
	                <th>ราคารวม</th>	               
	                <th>ดำเนินการ</th>
	            </tr>
	        </thead>        
	        <tbody>           	
	            <?php $i=0; ?>              
	            @foreach($data as $key => $value)
	             <?php $i++;  ?>
	                <tr>
	                    <td>{{ $i }}</td>  
	                    <td><?php echo date("d-m", strtotime($value->receive_date)).'-'.(date("Y", strtotime($value->receive_date))+543); ?></td>  
	                    <td>{{ $value->fullname }}</td>                        	                   
	                    <td>{{ $value->total_price }}</td>                          
	                    <td>                           	 
	                        <a class="" href="{{ url( 'showReceive', e($value->id) ) }}">
	                            ดูรายการ
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
