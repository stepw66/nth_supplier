<div class="row">
<div class="col-lg-12">
	<div class="dataTables_wrapper no-footer">                
    <table id="listissueTemp-ajax-data" class="table table-responsive table-striped table-hover table-bordered dataTable no-footer" role="grid">
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
                    <a class="btn-supplier-delete" href="{{ url('issue') }}/{{ $value->id }}" data-method="delete" data-confirm="ต้องการลบข้อมูล" data-remote="false" rel="nofollow">
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
		<a href="#" onclick="return clearissueTemp({{ Session::get('uid') }})" class="btn btn-default" >ยกเลิก</a>
        <a href="#" onclick="addIssue()" class="btn btn-success">บันทึก</a>
	</div>
    </div>		
</div>
</div>

<script>
	var listissueTempAjaxTable = $('#listissueTemp-ajax-data').dataTable( {
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