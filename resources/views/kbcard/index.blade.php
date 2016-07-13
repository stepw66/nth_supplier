@extends('layouts.default')

@section('content')


<div class="row">
	<div class="col-lg-12">
		
		<div class="row">
		<div class="col-lg-12">
			<ul class="breadcrumb">
			    <li><a href="{!! url('/') !!}">หน้าหลัก</a></li>			 
			    <li class="active">Kumbuk Card</li>
			</ul>
		</div>
		</div>
		<br />
        
        <div class="row">
            <div class="col-lg-12">
                {!! Form::open( array('route' => 'kbcard.store', 'class' => 'form-horizontal boxreceive', 'id'=>'') ) !!}

					<div class="form-group">
                        <div class="col-lg-3">
							<input type="text" class="form-control" name="id_dep" id="id_dep" placeholder="แผนก"/>
                            <input type="hidden" name="kc_sp_dep" id="kc_sp_dep" />
						</div>
                        <div class="col-lg-3">
							<input type="text" class="form-control" id="kc_supplier" name="kc_supplier" placeholder="พัสดุ"/>
                            <input type="hidden" name="supplier_id" id="kc_sp_id" />
                            <input type="hidden" name="supplier_code" id="kc_sp_code" />
						</div>
				 		<div class="col-lg-3">
							<input type="text" class="form-control" name="max_unit" placeholder="จำนวนสูงสุด"/>
						</div>
				 		<div class="col-lg-3">
							<input type="text" class="form-control" name="min_unit" placeholder="จำนวนต่ำสุด"/>
						</div>
					</div>
					
					<div class="form-group">
					  <div class="center">
						<input type="submit" class="btn btn-info btn-sm" value="พิมพ์ Kumbuk Card" />
					  </div>
					</div>	

				{!! Form::close() !!}<!-- form -->
            </div>
        </div>
				
	</div>
</div>


@endsection
