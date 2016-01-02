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
							
                {!! Form::open( array('url' => 'editIssueList', 'class' => 'form-horizontal boxreceive') ) !!}
                    <input type="hidden" name="idissueedit" id="idissueedit" value="{{ $idissueedit }}" />
					<div class="form-group">
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
								<input id="issue_supplier_edit" name="issue_supplier_edit" class="form-control" type="text" placeholder="รายการ" autocomplete="off" value="{{ $spname }}">
								<input type="hidden" name="issue_sp_id" id="issue_sp_id" value="{{ $data->supplier_is_id }}" />
								<input type="hidden" name="issue_sp_priceold" id="issue_sp_priceold" value="{{ $data->price/$data->qty }}" />
							</div>
						</div>
						<div class="col-lg-4">
							<label class="col-lg-2 control-label" for="issue_qty">เบิก</label>
							<div class="col-lg-10">
								<input id="issue_qty" name="issue_qty" class="form-control" type="text" placeholder="เบิก" value="{{ $data->qty }}">								
							</div>
						</div>
						<div class="col-lg-4">
							<label class="col-lg-6 control-label" for="qty_on_hand">เหลือในจุดบริการ</label>
							<div class="col-lg-6">
								<input id="qty_on_hand" name="qty_on_hand" class="form-control" type="text" placeholder="เหลือ" value="{{ $data->qty_on_hand }}">								
							</div>
						</div>
					</div>
					<div class="form-group">				 		
				 		<div class="col-lg-4">
							<label class="col-lg-2 control-label" for="issue_price">มูลค่า</label>
							<div class="col-lg-10">
								<input id="issue_price" name="issue_price" class="form-control" type="text" placeholder="มูลค่า" readonly="" value="{{ $data->price }}">								
							</div>
						</div>
						<div class="col-lg-4">
							<label class="col-lg-2 control-label" for="issue_comment">หมายเหตุ</label>
							<div class="col-lg-10">
								<textarea id="issue_comment" name="issue_comment" class="form-control" rows="3">{{ $data->comment }}</textarea>			
							</div>
						</div>
					</div>
					<div class="form-group">
					  <div class="center">
                        <a class="btn btn-success btn-sm" href="{{ url( 'editIssue/detail', $idissueedit ) }}">
                            กลับ
                        </a>
						<input class="btn btn-info btn-sm"  type="submit" value="บันทึก" />
					  </div>
					</div>	

				{!! Form::close() !!}<!-- form -->

				</div>
			</div>
									
		</div>
		</div>
					
	</div>
</div>


@endsection



