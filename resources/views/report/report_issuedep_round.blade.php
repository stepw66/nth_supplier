@extends('layouts.default')

@section('content')


<div class="row">
	<div class="col-lg-12">
		
		<div class="row">
		<div class="col-lg-12">
			<ul class="breadcrumb">
			    <li><a href="{!! url('/') !!}">หน้าหลัก</a></li>
			    <li><a href="#!">รายงาน</a></li>
			    <li class="active">จำนวนเบิกรายการของแต่ละฝ่าย (รอบ)</li>
			</ul>
		</div>
		</div>
		<br />
		<div class="row">
		<div class="col-lg-10 col-lg-offset-1">
			
            <form class="form-horizontal">

					<div class="form-group">
				 		<div class="col-lg-6">
							<label class="col-lg-4 control-label" for="approve_q">รอบที่จ่าย</label>
							<div class="col-lg-8">						
								<select name="supplyloop" id="supplyloop" class="form-control">
									@for( $i = 1; $i <= 24; $i++ )
										<option value="{{ $i }}">{{ $i }}</option>
									@endfor
								</select>
							</div>
						</div>
						<div class="col-lg-6">
							<label class="col-lg-4 control-label" for="approve_q">ปีงบประมาณ</label>
							<div class="col-lg-8">						
								 {!! Form::select('year', $year, null, ['class' => 'form-control', 'id' => 'yearloop']) !!}
							</div>
						</div>
					</div>
					<div class="form-group">
					  <div class="center">
						<input type="button" class="btn btn-info btn-sm" id="reportissuedep" value="ตกลง" />
					  </div>
					</div>	

            </form>
            
		</div>
		</div>
					
	</div>
</div>


@endsection