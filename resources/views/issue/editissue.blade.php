@extends('layouts.default')

@section('content')


<div class="row">
	<div class="col-lg-12">
		
		<div class="row">
		<div class="col-lg-12">
			<ul class="breadcrumb">
			    <li><a href="{!! url('/') !!}">หน้าหลัก</a></li>			 
			    <li class="active">แก้ไขใบเบิกพัสดุ</li>
			</ul>
		</div>
		</div>
		<br />
		<div class="row">
		<div class="col-lg-12">
			
			<div class="row">
				<div class="col-lg-12">
							
				<form id="frmissue" name="frmissue" action="addEditIssue" class="form-horizontal boxreceive">
                    <input type="hidden" name="idissueedit" id="idissueedit" value="{{ $idissueedit }}" />
					<div class="form-group">
				 		<div class="col-lg-4">
							<label class="col-lg-4 control-label" for="approve_q">รอบที่จ่าย</label>
							<div class="col-lg-8">						
                                {!! Form::select('approve_q', $around24, $around, ['class'=> 'form-control', 'id' => 'approve_q']) !!}	
							</div>
						</div>
				 		<div class="col-lg-4">
							<label class="col-lg-3 control-label" for="issue_date">วันที่</label>
							<div class="col-lg-9">
								<input type="text" readonly="" class="form-control" name="issue_date" id="issue_date" placeholder="ว-ด-ป"/>
							</div>
						</div>
						<div class="col-lg-4">
							<label class="col-lg-4 control-label" >หน่วยที่เบิก</label>
							<div class="col-lg-8">
								<input id="dep" name="dep" class="form-control" type="text" readonly="" value="{{ $dep }}" >
							</div>
						</div>
					</div>
					<div class="form-group">				 		
				 		<div class="col-lg-4">
							<label class="col-lg-2 control-label" for="issue_supplier">รายการ</label>
							<div class="col-lg-10">
								<input id="issue_supplier_edit" name="issue_supplier_edit" class="form-control" type="text" placeholder="รายการ" autocomplete="off">
								<input type="hidden" name="issue_sp_id" id="issue_sp_id" />
								<input type="hidden" name="issue_sp_priceold" id="issue_sp_priceold" />
							</div>
						</div>
						<div class="col-lg-4">
							<label class="col-lg-2 control-label" for="issue_qty">เบิก</label>
							<div class="col-lg-10">
								<input id="issue_qty" name="issue_qty" class="form-control" type="text" placeholder="เบิก">								
							</div>
						</div>
						<div class="col-lg-4">
							<label class="col-lg-6 control-label" for="qty_on_hand">เหลือในจุดบริการ</label>
							<div class="col-lg-6">
								<input id="qty_on_hand" name="qty_on_hand" class="form-control" type="text" placeholder="เหลือ">								
							</div>
						</div>
					</div>
					<div class="form-group">				 		
				 		<div class="col-lg-4">
							<label class="col-lg-2 control-label" for="issue_price">มูลค่า</label>
							<div class="col-lg-10">
								<input id="issue_price" name="issue_price" class="form-control" type="text" placeholder="มูลค่า" readonly="">								
							</div>
						</div>
						<div class="col-lg-4">
							<label class="col-lg-2 control-label" for="issue_comment">หมายเหตุ</label>
							<div class="col-lg-10">
								<textarea id="issue_comment" name="issue_comment" class="form-control" rows="3"></textarea>			
							</div>
						</div>
					</div>
					<div class="form-group">
					  <div class="center">
						<input type="button" class="btn btn-info btn-sm" id="add-issue-list-detail" value="เพิ่ม" />
					  </div>
					</div>	

				</form>

				</div>
			</div>

			<div class="row">
				<div class="col-lg-12">
					
					<div class="re-content">
						<div id="listissueTemp">
							@if( isset($data) )
								<div class="row">
								<div class="col-lg-12">
									<div class="dataTables_wrapper no-footer">                
									<table id="listissueTemp-data" class="table table-responsive table-striped table-hover table-bordered dataTable no-footer" role="grid">
								    <thead>
								        <tr>
								            <th>ลำดับ</th>
								            <th>รายการ</th>
								            <th>เบิก</th>
								            <th>เหลือ</th>
								            <th>ราคา</th>
								            <th>หมายเหตุ</th>
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
								                <td>{{ $value->qty }}</td>                       
								                <td>{{ $value->qty_on_hand }}</td>
								                <td>{{ $value->price }}</td>  
								                <td>{{ $value->comment }}</td>                         
								                <td> 
                                                    <a class="" href="{{ url( 'editIssue/issueeditlist' ) }}/{{ $value->id }}/{{ $value->supplier_is_id }}">
                                                        <i class="mdi-content-create mdi-material-teal"></i>
                                                    </a>
								                    <a class="btn-supplier-delete" href="{{ url( 'editIssue/delete' ) }}/{{ $value->id }}/{{ $value->supplier_is_id }}"  data-confirm="ต้องการลบข้อมูล" data-remote="false" rel="nofollow">
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
										<a href="{{ url('listIssue') }}" class="btn btn-success" >กลับ</a>
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



