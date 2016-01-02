@extends('layouts.default')

@section('content')


<div class="row">
	<div class="col-lg-12">
		
		<div class="row">
		<div class="col-lg-12">
			<ul class="breadcrumb">
			    <li><a href="{!! url('/') !!}">หน้าหลัก</a></li>			 
			    <li class="active">แก้ไขคลังพัสดุ</li>
			</ul>
		</div>
		</div>
		<br />
		<div class="row">
		<div class="col-lg-12">
			
			<div class="row">
				<div class="col-lg-12">
							
                {!! Form::open( array('route' => ['store.update', e($data->id)], 'class' => 'form-horizontal boxreceive', 'method' => 'PATCH') ) !!}
										
				 	<div class="form-group">
				 		<div class="col-lg-4">
							<label class="col-lg-2 control-label" for="receive_date">วันที่</label>
							<div class="col-lg-10">
								<input type="text" readonly="" class="form-control" name="receive_date" id="receive_date"/>
							</div>
						</div>
				 		<div class="col-lg-4">
							<label class="col-lg-2 control-label" for="supplier_re_id">รายการ</label>
							<div class="col-lg-10">
                                <input class="form-control" type="text" readonly value="{{ $data->sp_name }}">
							</div>
						</div>
						<div class="col-lg-4">
							<label class="col-lg-2 control-label" for="supplier_re_id">barcode</label>
							<div class="col-lg-10">
								<input id="barcode" name="barcode" class="form-control" type="text" value="{{ $data->barcode }}">
							</div>
						</div>
					</div>
				 	<div class="form-group">
				 		<div class="col-lg-4">
							<label class="col-lg-2 control-label" for="priceunit">ราคา</label>
							<div class="col-lg-10">
								<input id="priceunit" name="priceunit" class="form-control" type="text" value="{{ $data->priceunit }}">
							</div>
						</div>
				 		<div class="col-lg-4">
							<label class="col-lg-2 control-label" for="qty">จำนวน</label>
							<div class="col-lg-10">
								<input id="qty" name="qty" class="form-control" type="text" value="{{ $data->qty }}">
							</div>
						</div>
						<div class="col-lg-4">
							<label class="col-lg-2 control-label" for="pricetotal">รวม</label>
							<div class="col-lg-10">
								<input id="pricetotal" readonly="" name="pricetotal" class="form-control" type="text" value="{{ $data->pricetotal }}">
							</div>
						</div>
					</div>
					
					<div class="form-group">
					  <div class="center">
                        <a href="{!! route('store.index') !!}" class="btn btn-default">ยกเลิก</a>  
						<input type="submit" class="btn btn-info btn-sm" value="ตกลง" />
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



