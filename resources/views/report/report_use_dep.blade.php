@extends('layouts.default')

@section('content')


<div class="row">
	<div class="col-lg-12">
		
		<div class="row">
		<div class="col-lg-12">
			<ul class="breadcrumb">
			    <li><a href="{!! url('/') !!}">หน้าหลัก</a></li>
			    <li><a href="#!">รายงาน</a></li>
			    <li class="active">จำนวนใช้พัสดุประจำ(ปีงบประมาณ) หน่วยงาน</li>
			</ul>
		</div>
		</div>
		<br />
		<div class="row">
		<div class="col-lg-10 col-lg-offset-1">
			
            <form class="form-horizontal">

					<div class="form-group">
						<div class="col-lg-6">
							<label class="col-lg-4 control-label" for="approve_q">ปีงบประมาณ</label>
							<div class="col-lg-8">						
								 {!! Form::select('year', $year, null, ['class' => 'form-control', 'id' => 'yearusedep']) !!}
							</div>
						</div>
                        <div class="col-lg-6">
							<label class="col-lg-4 control-label" for="approve_q">แผนก</label>
							<div class="col-lg-8">						
								 {!! Form::select('dep', $deplist, null, ['class' => 'form-control', 'id' => 'deplist']) !!}
							</div>
						</div>
					</div>
					<div class="form-group">
					  <div class="center">
						<input type="button" class="btn btn-info btn-sm" id="reportusedep" value="ตกลง" />
					  </div>
					</div>	

            </form>
            
		</div>
		</div>
					
	</div>
</div>


@endsection