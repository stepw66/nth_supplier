@extends('layouts.default')

@section('content')


<div class="row">
	<div class="col-lg-12">
		
		<div class="row">
		<div class="col-lg-12">
			<ul class="breadcrumb">
			    <li><a href="{!! url('/') !!}">หน้าหลัก</a></li>
			    <li><a href="{!! url('listReceive') !!}">รายการรับพัสดุ</a></li>
			    <li class="active">รายละเอียดการรับ</li>
			</ul>
		</div>
		</div>		

		<div class="row">
		<div class="col-lg-12">
			<div class="dataTables_wrapper no-footer">                
			<table id="listorderdetail-data" class="table table-responsive table-striped table-hover table-bordered dataTable no-footer" role="grid">
	        <thead>
	            <tr>
	                <th>ลำดับ</th>
	                <th>วันที่รับ(ว-ด-ป)</th>
	                <th>ประเภท</th>
	                <th>รหัส</th>
	                <th>รายการ</th>
	                <th>จำนวน</th>
	                <th>หน่วย</th>
	                <th>ราคา</th>	
	                <th>ราคารวม</th>   
	            </tr>
	        </thead>        
	        <tbody>           	
	            <?php $i=0; ?>              
	            @foreach($data as $key => $value)
	             <?php $i++;  ?>
	                <tr>
	                    <td>{{ $i }}</td>  
	                    <td><?php echo date("d-m", strtotime($value->receive_date)).'-'.(date("Y", strtotime($value->receive_date))+543); ?></td>  
	                    <td>{{ $value->type_name }}</td>                        
	                    <td>{{ $value->sp_code }}</td>
	                    <td>{{ $value->sp_name }}</td> 
	                    <td>{{ $value->qty }}</td> 
	                    <td>{{ $value->unit_name }}</td>                        
	                    <td>{{ $value->priceunit }}</td>
	                    <td>{{ $value->pricetotal }}</td>	                   
	                </tr>           
	            @endforeach
	        </tbody>
	        </table>
		    </div><!-- .dataTables_wrapper -->
		</div>
		</div>

		<a href="{!! url('listReceive') !!}" class="btn btn-success">กลับ</a>
				
	</div>
</div>


@endsection
