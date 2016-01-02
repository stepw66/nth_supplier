@extends('layouts.default')
<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <!--<h4 class="modal-title">ตารางการเบิกพัสดุ</h4>-->
            </div>
            <div class="modal-body">

                <img src="assets/images/dd.jpg" alt="" />
               
            </div>
        </div>
    </div>
</div>
@section('content')



<h3>จำนวนเบิกพัสดุต่อรอบ</h3>
<div id="graph"></div>



@endsection