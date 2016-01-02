<div class="row">
<div class="col-lg-12">
	<div class="dataTables_wrapper no-footer">                
	<table id="listTemp-ajax-data" class="table table-responsive table-striped table-hover table-bordered dataTable no-footer" role="grid">
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
		<a href="#" onclick="return clearTemp({{ Session::get('uid') }})" class="btn btn-default" >ยกเลิก</a>
        <a href="#" onclick="addReceive()" class="btn btn-success">บันทึก</a>
	</div>
    </div>		
</div>
</div>

<script>
	var listTempAjaxTable = $('#listTemp-ajax-data').dataTable( {
        "iDisplayLength": 100,
        "bLengthChange": false,
        "language": {
            "lengthMenu": "_MENU_ แถวต่อหน้า",
            "zeroRecords": "ไม่มีข้อมูล",
            "info": "หน้า _PAGE_ จาก _PAGES_",
            "infoEmpty": "ไม่มีข้อมูล",
            "sSearch": "ค้นหา: "            
        }
    } );
</script>