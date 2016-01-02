<?php
  $urlcheck =  explode("/", Request::path());
  //$activeurl = $urlcheck[0].'/'.$urlcheck[1];
  $activeurl = Request::path();

  if( count($urlcheck) == 1 ){
      $activeurl = Request::path();
  }
  if( count($urlcheck) > 1 ){
      $activeurl = $urlcheck[0].'/'.$urlcheck[1];
  }
?>
<div class="navbar navbar-success">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="javascript:void(0)">ระบบเบิกพัสดุ</a>
  </div>
  <div class="navbar-collapse collapse navbar-responsive-collapse">
    <ul class="nav navbar-nav">
      <li class="{{ $activeurl == '/' ? 'active' : '' }}"><a href="{!! url('/') !!}">Dashboard</a></li>
      
      @if( Session::get('level') == 1 || Session::get('level') == 2 )
      <li class="dropdown">
        <a href="#!" data-target="#" class="dropdown-toggle" data-toggle="dropdown">เบิกพัสดุ <b class="caret"></b></a>
        <ul class="dropdown-menu">  
          <li><a href="{!! route('issue.index') !!}">เบิกพัสดุ</a></li>  
          <li><a href="{!! url('listIssue') !!}">รายการเบิกพัสดุ</a></li>                                         
        </ul>
      </li>
      @endif
      @if( Session::get('level') == 3 )
        <li class="{{ $activeurl == 'issue' ? 'active' : '' }}"><a href="{!! route('issue.index') !!}">เบิกพัสดุ</a></li>  
        <li class="{{ $activeurl == 'listIssue' ? 'active' : '' }}"><a href="{!! url('listIssue') !!}">รายการเบิกพัสดุ</a></li>   
      @endif


      @if( Session::get('level') == 1 || Session::get('level') == 2 )
        <li class="dropdown">
          <a href="#!" data-target="#" class="dropdown-toggle" data-toggle="dropdown">รับพัสดุ <b class="caret"></b></a>
          <ul class="dropdown-menu">                      
            <li><a href="{!! route('receive.index') !!}">รับพัสดุ</a></li> 
            <li><a href="{!! url('listReceive') !!}">รายการรับพัสดุ</a></li> 
          </ul>
        </li>   
        <li class="{{ $activeurl == 'kbcard' ? 'active' : '' }}"><a href="{!! route('kbcard.index') !!}">Kumbuk Card</a></li>
        <li class="{{ $activeurl == 'store' ? 'active' : '' }}"><a href="{!! route('store.index') !!}">คลังพัสดุ</a></li>
        <li class="{{ $activeurl == 'supplier' ? 'active' : '' }}"><a href="{!! route('supplier.index') !!}">รายการพัสดุ</a></li>
      @endif  
        
       @if( Session::get('level') == 1 )    
        <li class="{{ $activeurl == 'user' ? 'active' : '' }}" ><a href="{!! route('user.index') !!}">จัดการผู้ใช้</a></li>
       @endif  
        
       @if( Session::get('level') == 1 || Session::get('level') == 2 ) 
        <li class="dropdown {{ $activeurl == 'unit' ? 'active' : '' }} {{ $activeurl == 'type' ? 'active' : '' }} {{ $activeurl == 'department' ? 'active' : '' }} {{ $activeurl == 'appfig' ? 'active' : '' }}">
          <a href="#!" data-target="#" class="dropdown-toggle" data-toggle="dropdown">ข้อมูลพื้นฐาน <b class="caret"></b></a>
          <ul class="dropdown-menu">  
            <li><a href="{!! route('around.index') !!}">รอบเบิกพัสดุ</a></li>  
            <li><a href="{!! route('unit.index') !!}">หน่วยนับพัสดุ</a></li>
            <li><a href="{!! route('type.index') !!}">ประเภทพัสดุ</a></li>               
            
             @if( Session::get('level') == 1 )    
            <li><a href="{!! route('department.index') !!}">แผนก</a></li>
            <li><a href="{!! route('appfig.index') !!}">หน่วยงาน</a></li>
            <li><a href="{!! route('company.index') !!}">บริษัท</a></li>
             @endif    
          </ul>
        </li>
        <li class="dropdown">
          <a href="#!" data-target="#" class="dropdown-toggle" data-toggle="dropdown">รายงาน <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li class="dropdown-header">รายงานการเบิก</li>
            <li><a href="{{ url('report/report_issuedep_round') }}">จำนวนเบิกรายการของแต่ละฝ่าย (รอบ)</a></li>
            <li><a href="{{ url('report/report_issue_year') }}">จำนวนเบิกรายการของแต่ละฝ่าย (ปีงบประมาณ)</a></li>
            <li class="divider"></li>
            <li class="dropdown-header">สรุปการใช้พัสดุ</li>
            <li><a href="{{ url('report/report_use_dep') }}">หน่วยงาน (ปีงบประมาณ)</a></li>
            <li><a href="{{ url('report/report_use_six') }}">รวม (6 เดือนแรก)</a></li>
            <li class="divider"></li>
            <li class="dropdown-header">รายการวัสดุ</li>
            <li><a href="{{ url('report/report_store_all') }}">รายการพัสดุคงคลัง</a></li>
            <li><a href="{{ url('report/report_store_all_2') }}">รายงานมูลค่าวัสดุคงคลัง</a></li>
            <li><a href="{{ url('report/report_store_all_3') }}">รายงานมูลค่าคงคลังและมูลค่าการใช้</a></li>
          </ul>
        </li>
       @endif

    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="#!"><span class="mdi-action-account-circle btn-xs" style="font-size: 11pt;">{!! Session::get('username') !!}</span></a></li>
      <li><a href="{!! url('logout') !!}">ออกจากระบบ</a></li>    
    </ul>
  </div>
</div>
