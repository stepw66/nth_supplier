@extends('layouts.default')

@section('content')


<div class="row">
	<div class="col-lg-12">
		
		<div class="row">
		<div class="col-lg-12">
			<ul class="breadcrumb">
			    <li><a href="{!! url('/') !!}">หน้าหลัก</a></li>
			    <li class="active">จัดการผู้ใช้</li>
			</ul>
		</div>
		</div>

		<div class="row">
		<div class="col-lg-12">
			<a href="{!! route('user.create') !!}" class="btn btn-success btn-fab btn-raised mdi-content-add"></a>
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
			<table id="user-data" class="table table-responsive table-striped table-hover table-bordered dataTable no-footer" role="grid">
	        <thead>
	            <tr>
	                <th>ลำดับ</th>
	                <th>ชื่อผู้ใช้</th>
	                <th>ชื่อ-สกุล</th>
	                <th>แผนก</th>
	                <th>ระดับ</th>
	                <th>สถานะ</th>
	                <th>ดำเนินการ</th>
	            </tr>
	        </thead>        
	        <tbody>           	
	            <?php $i=0; ?>              
	            @foreach($data as $key => $value)
	             <?php $i++;  ?>
	                <tr>
	                    <td>{{ $i }}</td>   
	                    <td>{{ $value->username }}</td>                        
	                    <td>{{ $value->fullname }}</td>
	                    <td>{{ $value->dep_name }}</td>                          
	                    <td>
	                    	<?php
	                    		if( $value->level == '1' ){
	                    			echo 'ผู้ดูแลระบบ';
	                    		}else if( $value->level == '2' ){
	                    			echo 'เจ้าหน้าที่พัสดุ';
	                    		}else{
	                    			echo 'ผู้ใช้ทั่วไป';
	                    		}
	                    	?>
	                    </td>   
	                    <td>
	                    	<?php
	                    		if( $value->activated == '1' ){
	                    			echo'<span class="label label-primary">เปิด</span>';
	                    		}else{
	                    			echo'<span class="label label-danger">ปิด</span>';
	                    		}
	                    	?>
	                    </td>                       
	                    <td>                           	 
	                        <a class="" href="{{ route( 'user.edit', e($value->id) ) }}">
	                            <i class="mdi-content-create mdi-material-teal"></i>
	                        </a>
	                        <a class="btn-user-delete" href="{{ route( 'user.destroy', e($value->id) ) }}" data-method="delete" data-confirm="ต้องการลบผู้ใช้ {{ e($value->username) }}" data-remote="false" rel="nofollow">
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