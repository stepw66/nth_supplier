@extends('layouts.default')

@section('content')


<div class="row">
	<div class="col-lg-12">
		
		<div class="row">
		<div class="col-lg-12">
			<ul class="breadcrumb">
			    <li><a href="{!! url('/') !!}">หน้าหลัก</a></li>			 
			    <li class="active">รับพัสดุ</li>
			</ul>
		</div>
		</div>
		<br />
		<div class="row">
		<div class="col-lg-12">
			
			<div class="row">
				<div class="col-lg-12">
							
				<form id="frm" name="frm" action="addSpTemp" class="form-horizontal boxreceive">
                    
                    <input type="hidden" id="ckedit" name="ckedit" />
										
				 	<div class="form-group">
				 		<div class="col-lg-4">
							<label class="col-lg-2 control-label" for="receive_date">วันที่</label>
							<div class="col-lg-10">
								<input type="text" readonly="" class="form-control" name="receive_date" id="receive_date" placeholder="ว-ด-ป"/>
							</div>
						</div>
				 		<div class="col-lg-4">
							<label class="col-lg-2 control-label" for="supplier_re_id">รายการ</label>
							<div class="col-lg-10">
								<input id="supplier_re_id" name="supplier_re_id" class="form-control" type="text" placeholder="รายการ" autocomplete="off">
								<input type="hidden" name="srid" id="srid" />
							</div>
						</div>
						<div class="col-lg-4">
							<label class="col-lg-2 control-label" for="supplier_re_id">barcode</label>
							<div class="col-lg-10">
								<input id="barcode" name="barcode" class="form-control" type="text" placeholder="barcode">
							</div>
						</div>
					</div>
				 	<div class="form-group">
				 		<div class="col-lg-4">
							<label class="col-lg-2 control-label" for="priceunit">ราคา</label>
							<div class="col-lg-10">
								<input id="priceunit" name="priceunit" class="form-control" type="text" placeholder="ราคา">
							</div>
						</div>
				 		<div class="col-lg-4">
							<label class="col-lg-2 control-label" for="qty">จำนวน</label>
							<div class="col-lg-10">
								<input id="qty" name="qty" class="form-control" type="text" placeholder="จำนวน">
							</div>
						</div>
						<div class="col-lg-4">
							<label class="col-lg-2 control-label" for="pricetotal">รวม</label>
							<div class="col-lg-10">
								<input id="pricetotal" readonly="" name="pricetotal" class="form-control" type="text" placeholder="ราคา">
							</div>
						</div>
					</div>
					<div class="form-group">
				 		<div class="col-lg-4">
							<label class="col-lg-2 control-label" for="comment">หมายเหตุ</label>
							<div class="col-lg-10">
								<textarea id="comment" name="comment" class="form-control" rows="3"></textarea>			
							</div>
						</div>
						<div class="col-lg-4">
                            <label class="col-lg-2 control-label" for="company">บริษัท</label>
                            <div class="col-lg-10">
							{!! Form::select('company', ['' => '-']+$company_list, null, ['class'=> 'form-control', 'id'=>'companytemp']) !!}
                            </div>
						</div>
					</div>	

					<div class="form-group">
					  <div class="center">
						<input type="button" class="btn btn-info btn-sm" id="add-sp-list" value="เพิ่ม" />
					  </div>
					</div>				 
				
				</form><!-- form -->

				</div>
			</div>

			<div class="row">
				<div class="col-lg-12">
					<div class="re-content">
						<div id="listTemp">
							@if( isset($data) )
								<div class="row">
								<div class="col-lg-12">
									<div class="dataTables_wrapper no-footer">                
									<table id="listTemp-data" class="table table-responsive table-striped table-hover table-bordered dataTable no-footer" role="grid">
								    <thead>
								        <tr>
								            <th>ลำดับ</th>
								            <th>รายการ</th>
								            <th>barcode</th>
								            <th>ราคา</th>
								            <th>จำนวน</th>
								            <th>ราคารวม</th>
								            <th>หมายเหตุ</th>
                                            <th>บริษัท</th>
								            <th>ดำเนินการ</th>
								        </tr>
								    </thead>        
								    <tbody>           	
								        <?php $i=0; ?>              
								        @foreach($data as $key => $value)
								         <?php $i++;  ?>
								            <tr>
								                <td>{{ $i }}</td>  
								                <td>{{ $value->sp_name }}</td>  
								                <td>{{ $value->barcode }}</td> 
								                <td>{{ $value->priceunit }}</td>                       
								                <td>{{ $value->qty }}</td>
								                <td>{{ $value->pricetotal }}</td>  
								                <td>{{ $value->comment }}</td>                         
                                                <td>{{ $value->company }}</td>
								                <td>    
                                                    <a class="" onclick="recevie_edittemp({{ $value->id }})" href="javascript:void(0)">
	                            <i class="mdi-content-create mdi-material-teal"></i>
	                        </a>
								                    <a class="btn-supplier-delete" href="{{ url('receive') }}/{{ $value->id }}" data-method="delete" data-confirm="ต้องการลบข้อมูล" data-remote="false" rel="nofollow">
								                        <i class="mdi-action-delete mdi-material-red"></i>
								                    </a>
								                </td>
								            </tr>           
								        @endforeach
								    </tbody>
								    </table>
								    </div><!-- .dataTables_wrapper -->

								    <div class="right">
									<div class="form-group">
										<a href="#" onclick="clearTemp({{ Session::get('uid') }})" class="btn btn-default" >ยกเลิก</a>
										<a href="#" onclick="addReceive()" class="btn btn-success">บันทึก</a>
									</div>
								    </div>		
								</div>
								</div>
							@else
								ยังไม่มีข้อมูล
							@endif							
						</div>
					</div>
				</div>
			</div>
									

		</div>
		</div>
					
	</div>
</div>


@endsection



