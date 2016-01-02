@extends('layouts.default')

@section('content')


<div class="row">
	<div class="col-lg-12">
		
		<div class="row">
		<div class="col-lg-12">
			<ul class="breadcrumb">
			    <li><a href="{!! url('/') !!}">หน้าหลัก</a></li>
			    <li><a href="{!! url('listIssue') !!}">รายการเบิกพัสดุ</a></li>
                <li><a href="javascript:void(0)">รายละเอียดการเบิก</a></li>
                <li class="active">{{ $dep }}</li>
                <li class="active">{{ $user }}</li>
			</ul>
		</div>
		</div>		

		<div class="row">
		<div class="col-lg-12">
			<form name="frmsupply" id="frmsupply">
			<div class="dataTables_wrapper no-footer">                
			<table id="listorderdetail-data" class="table table-responsive table-striped table-hover table-bordered dataTable no-footer" role="grid">
	        <thead>
	            <tr>
	                <th>ลำดับ</th>
	                <th>ประเภท</th>
	                <th>รหัส</th>
	                <th>รายการ</th>
	                <th>จำนวน</th>
	                <th>คงเหลือ</th>	
	                <th>ราคารวม</th>                
	                <th>หมายเหตุ</th> 
	                <th>store เหลือ</th>
	                <th>จ่าย</th>  
                    @if( Session::get('level') == 1 || Session::get('level') == 2 )
                        <th>#</th>
                    @endif
	            </tr>
	        </thead>        
	        <tbody>           	
	            <?php $i=0; $ckbtn=''; ?>              
	            @foreach($data as $key => $value)
	             <?php $i++; $ckbtn = $value->supply;  ?>
	                <tr>
	                	<input type="hidden" name="supply_user[]"  value="{{ $value->issue_user }}" />
	                	<input type="hidden" name="supply_issue[]"  value="{{ $value->id_issue }}" />
	                	<input type="hidden" name="supply_sp_id[]"  value="{{ $value->supplier_is_id }}" />	              	

	                    <td>{{ $i }}</td>  
	                    <td>{{ $value->type_name }}</td>                        
	                    <td>{{ $value->sp_code }}</td>
	                    <td>{{ $value->sp_name }}</td> 
	                    <td><span class="text-danger">{{ $value->qty }}</span></td> 
	                    <td>{{ $value->qty_on_hand }}</td>                        
	                    <td>{{ $value->price }}</td>
	                    <td>{{ $value->comment }}</td>
	                    <td>
	                    @if( $value->qtystore == 0 )
							<span class="text-danger">0</span>
	                    @endif
	                    @if( $value->qtystore != 0 )
							<span class="text-success">{{ $value->qtystore }}</span>
	                    @endif
	                    </td>
	                    @if( Session::get('level') == 1 || Session::get('level') == 2 )
	                    	@if( $value->approve_date == '' )
			                    <td>
			                    	<input maxlength="3" class="form-control" name="supply[]" value="{{ $value->supply }}" />
			                    </td>
                                <td>-</td>
		                    @endif
		                    @if( $value->approve_date != '' )
			                    <td>
			                    	<input  <?php echo (($value->supply == '')?'':'disabled=""'); ?>  class="form-control text-danger" value="{{ $value->supply }}" name="supply[]" />
			                    </td>
                                <td>
                                    @if( $value->supply != '' )
                                        <a href="javascript:void(0)" onclick="sp_restore({{ $value->id_issue }},{{ $value->supplier_is_id }},{{ $value->supply }})" class="text-info">คืนพัสดุ</a>
                                    @endif
                                    @if( $value->supply == '' )
                                     <a href="javascript:void(0)" onclick="sp_issue_bg({{ $value->id_issue }},{{ $value->supplier_is_id }})" class="text-danger">เบิกพัสดุ</a>
                                    @endif
                                </td>
	                    	@endif
	                    @endif
	                   @if( Session::get('level') == 3 )
		                    <td>
		                    	<input disabled="" class="form-control text-danger" value="{{ $value->supply }}" />
		                    </td>
	                    @endif
	                </tr>           
	            @endforeach
	        </tbody>
	        </table>
		    </div><!-- .dataTables_wrapper -->
		    </form>
            <input type="hidden" value="{{ $sp_issue_id }}" id="print_sp_issue_id" />
            <div class="center">
                <button class="btn btn-material-brown" id="printsupply">พิมพ์</button>    

              <?php if( (Session::get('level') == 1 || Session::get('level') == 2)  && ($ckbtn == '') ) { ?>
                <input type="button" class="btn btn-info" id="addsupply" value="จ่าย" />
               <?php } ?>
            </div>
		</div>
		</div>

		<a href="{!! url('listIssue') !!}" class="btn btn-success">กลับ</a>
				
	</div>
</div>


@endsection
