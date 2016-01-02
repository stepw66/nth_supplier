(function(){


    $.ajaxSetup({
       headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
    });


    /**
	 * check ie
	 */
	check_ie();

    
    
    
     /**
	 * Model page issue
	 */
    $('#myModal').modal('show');
   
    
    
    
    /**
     * page dashboard
     *
     */ 
    $.getJSON("graphgroup", function (json) { 
        if( json.length > 0){
            Morris.Bar({
                  element: 'graph',
                  data: json,
                  xkey: 'around',
                  ykeys: ['totalqty'],
                  labels: ['จำนวนที่เบิก']
            });
        }else{
             Morris.Bar({
                  element: 'graph',
                   data: [
                    {x: 'No Data.', y: 0},
                  ],
                  xkey: 'x',
                  ykeys: 'y',
                  labels: ['จำนวนที่เบิก']
            });
        }
    });
    
     



     /**
     * page issue
     *
     */  
    $('#approve_q').focus();

    function displayResultissue(item) {     
        $('#issue_sp_id').val(item.value);

        $.ajax({
            type: 'GET',
            url: 'getprice/'+$('#issue_sp_id').val(),
            data: '',
            success: function(data) {   
                if( data == 0 ){
                    alert('ไม่มีรายการนี้ใน คลังพัสดุ');
                    $('#issue_supplier').val('');
                    $('#issue_sp_id').val('');
                }else{
                    $('#issue_sp_priceold').val(data);  
                }                   
            }
        });
    } 
    $('#issue_supplier').typeahead({
       ajax: { 
                url: 'getsupplier',
                method: 'post',
                triggerLength: 2 
            },
        onSelect: displayResultissue
    });
    $('#issue_qty').keyup(function(){
        if( $('#issue_qty').val() != '' )
        {           
            $('#issue_price').val( eval($('#issue_qty').val())*eval($('#issue_sp_priceold').val()) );           
        }
    });
    $('#add-issue-list').click(function(){
        if( $('#issue_supplier').val() == '' || $('#issue_sp_id').val() == '' || $('#issue_qty').val() == '' || $('#qty_on_hand').val() == '' )
        {
            if( $('#issue_supplier').val() == '' || $('#issue_sp_id').val() == '' ){
                $('#issue_supplier').focus();
            }
            else if( $('#issue_qty').val() == '' ){
                $('#issue_qty').focus();
            }else if( $('#qty_on_hand').val() == '' ){
                $('#qty_on_hand').focus();
            }          
        }
        else
        {
            var form = jQuery(this).parents("form:first");
            var dataString = form.serialize();

            var formAction = form.attr('action');

            $.ajax({
                type: "POST",
                url : formAction,
                data : dataString,
                success : function(data){
                    if( data != '' ){
                        $.ajax({
                            type: 'GET',
                            url: 'listissueTemp/'+data,
                            data: '',
                            success: function(data) {         
                                $('#listissueTemp').html(data);  

                                $('#issue_supplier, #issue_qty, #qty_on_hand, #issue_price, #issue_comment').val(''); 
                                $('#issue_supplier').focus();    
                            }
                        });
                    }
                }
            },"json");
        }
    });
    
    
    
    
    
     /**
     * แก้ไขเบิกพัสดุ
     */
    function displayResultissueEdit(item) {     
        $('#issue_sp_id').val(item.value);

        $.ajax({
            type: 'GET',
            url: 'getprice/'+$('#issue_sp_id').val(),
            data: '',
            success: function(data) {   
                if( data == 0 ){
                    alert('ไม่มีรายการนี้ใน คลังพัสดุ');
                    $('#issue_supplier').val('');
                    $('#issue_sp_id').val('');
                }else{
                    $('#issue_sp_priceold').val(data);  
                }                   
            }
        });
    } 
     $('#issue_supplier_edit').typeahead({
       ajax: { 
                url: 'getsupplier',
                method: 'post',
                triggerLength: 2 
            },
        onSelect: displayResultissueEdit
    });
    $('#add-issue-list-detail').click(function(){
    
         if( $('#issue_supplier').val() == '' || $('#issue_sp_id').val() == '' || $('#issue_qty').val() == '' || $('#qty_on_hand').val() =='' )
        {
            if( $('#issue_supplier').val() == '' || $('#issue_sp_id').val() == '' ){
                $('#issue_supplier').focus();
            }
            else if( $('#issue_qty').val() == '' ){
                $('#issue_qty').focus();
            }else if( $('#qty_on_hand').val() == '' ){
                $('#qty_on_hand').focus();
            }            
        }
        else
        {
            var form = jQuery(this).parents("form:first");
            var dataString = form.serialize();

            var formAction = form.attr('action');

            $.ajax({
                type: "POST",
                url : formAction,
                data : dataString,
                success : function(data){
                     location.reload(); 
                }
            },"json");
        }
        
    });
    
    
    

    /**
     * จ่ายพัสดุ
     */
    $('#addsupply').click(function(){

        var supply_user     = document.querySelectorAll("#frmsupply input[name='supply_user[]']");
        var supply_issue    = document.querySelectorAll("#frmsupply input[name='supply_issue[]']");
        var supply_sp_id    = document.querySelectorAll("#frmsupply input[name='supply_sp_id[]']");
        var supply          = document.querySelectorAll("#frmsupply input[name='supply[]']");
        var i = 0;
        var c = 0;      

        for(i=0;i<supply.length;i++)
        {             
            if(supply[i].value == ''){
                c++;
            }
        }     
 
        if( c == 0 )
        {
            var approvekey; 
            var ck;                    
            for(i=0;i<supply.length;i++)
            {    
                approvekey =  supply_issue[i].value;          
                var issueuser = supply_user[i].value;//คนเบิก
                var issueid = supply_issue[i].value;//รหัสใบเบิก
                var spid = supply_sp_id[i].value;//รหัสพัสดุ
                var issuenum = supply[i].value;//จำนวน

                $.ajax({
                    type: 'POST',
                    url: 'oksupply',
                    data: { issueuser: issueuser, issueid: issueid, spid: spid, issuenum: issuenum },
                    success: function(data) {   
                                     
                    }
                });
            }

            $.ajax({
                    type: 'POST',
                    url: 'updateapprove',
                    data: { approvekey: approvekey },
                    success: function(data) {  
                        window.history.back(-1); 
                        location.reload();  
                    }
            });       
        }
        else
        {
            alert('กรุณากรอกจำนวนที่จ่าย');
        }

    });
    
    /**
     *พิมพ์จ่ายพัสดุ
     */
    $('#printsupply').click(function(){
        
        var sp_id = $('#print_sp_issue_id').val();
        $.ajax({
            type: 'GET',
            url: 'printissue/'+sp_id,
            data: '',
            success: function(data) {         
                //window.location = 'loadfileprint/'+data;
                window.open('loadfileprint/'+data, '_blank');
            }
        });
        
    });




    
    

    /**
     * page receive
     *
     */  
    function displayResult(item) {     
        $('#srid').val(item.value);
    } 
    $('#supplier_re_id').typeahead({
       ajax: { 
                url: 'getsupplier',
                method: 'post',
                triggerLength: 2 
            },
        onSelect: displayResult
    });


    $("#qty, #priceunit, #pricetotal, #approve_q, #issue_qty, #qty_on_hand, input[name='supply[]'] ").on("keypress", function(e) {
       
        var allowedEng = false; //อนุญาตให้คีย์อังกฤษ
        var allowedThai = false; //อนุญาตให้คีย์ไทย
        var allowedNum = true; //อนุญาตให้คีย์ตัวเลข
        
        var k = e.keyCode || e.which;
        
        /* เช็คตัวเลข 0-9 */
        if (k>=48 && k<=57) { return allowedNum; }

        /* เช็คคีย์อังกฤษ a-z, A-Z */
        if ((k>=65 && k<=90) || (k>=97 && k<=122)) { return allowedEng; }

        /* เช็คคีย์ไทย ทั้งแบบ non-unicode และ unicode */
        if ((k>=161 && k<=255) || (k>=3585 && k<=3675)) { return allowedThai; }
        
    }); 

    $("#receive_date, #issue_date, #around_date").mask("99-99-9999",{placeholder:"__-__-____"});    
    var d = new Date();
    var month = d.getMonth() + 1;
    var day = d.getDate();
    var year = d.getFullYear()+543;
    var today = (day<10?'0':'')+ day + '-' +(month<10?'0':'')+ month + '-' + year;
    $("#receive_date, #issue_date").val(today);

    $('#supplier_re_id').focus(); 

    $('#priceunit').keyup(function(){
        if( $('#priceunit').val() != '' )
        {
            if( $('#qty').val() != '' ){
                $('#pricetotal').val( eval($('#priceunit').val())*eval($('#qty').val()) );
            }
        }
    });

    $('#qty').keyup(function(){
        if( $('#qty').val() != '' )
        {
            if( $('#priceunit').val() != '' ){
                $('#pricetotal').val( eval($('#priceunit').val())*eval($('#qty').val()) );
            }
        }
    });

    $('#add-sp-list').click(function(){

        if( $('#receive_date').val() == '' || $('#supplier_re_id').val() == '' || $('#qty').val() == '' || $('#priceunit').val() == '' )
        {
            if( $('#receive_date').val() == '' ){
                $('#receive_date').focus();
            }
            else if( $('#supplier_re_id').val() == '' ){
                $('#supplier_re_id').focus();
            }
            else if( $('#priceunit').val() == '' ){
                $('#priceunit').focus();
            }
            else if( $('#qty').val() == '' ){
                $('#qty').focus();
            }
            
        }
        else 
        {              
            var form = jQuery(this).parents("form:first");
            var dataString = form.serialize();

            var formAction = form.attr('action');

            $.ajax({
                type: "POST",
                url : formAction,
                data : dataString,
                success : function(data){
                    if( data != '' ){
                        $.ajax({
                            type: 'GET',
                            url: 'listTemp/'+data,
                            data: '',
                            success: function(data) {         
                                $('#listTemp').html(data);  

                                $('#supplier_re_id, #barcode, #qty, #priceunit, #pricetotal, #comment, #companytemp, #ckedit').val(''); 
                                $('#supplier_re_id').focus();    
                            }
                        });
                    }
                }
            },"json");
        }
        
    });



    
    
    
    
    /**
    * page kumbuk_card
    */
     function displayResultspdep(item) {     
        $('#kc_sp_dep').val(item.value);
    } 
    $('#id_dep').typeahead({
       ajax: { 
                url: 'getspdep',
                method: 'post',
                triggerLength: 2 
            },
        onSelect: displayResultspdep
    });
    function displayResultspkc(item) {     
        $('#kc_sp_id').val(item.value);
        
        $.ajax({
            type: 'GET',
            url: 'getspcode/'+$('#kc_sp_id').val(),
            data: '',
            success: function(data) {   
                $('#kc_sp_code').val(data);                 
            }
        });
    } 
    $('#kc_supplier').typeahead({
       ajax: { 
                url: 'getsupplier',
                method: 'post',
                triggerLength: 2 
            },
        onSelect: displayResultspkc
    });



    
    

    /**
     * page Supplier
     */
    $('#type_code_i').change(function(){
        var d = $('#type_code_i').val();

        $.ajax({
            type: 'GET',
            url: 'getcode/'+d,
            data: '',
            success: function(data) {         
                $('#sp_code_i').val(data.code);        
            }
        });
    });
 
    

    
    
    
    
    /**
    *   page report
    */
    $('#reportissuedep').click(function(){
        var l = $('#supplyloop').val();
        var y = $('#yearloop').val();
        
        window.open('reportissuedep/'+l+'/'+y);
        
        /*$.ajax({
            type: 'GET',
            url: 'reportissuedep/'+l+'/'+y,
            data: '',
            success: function(data) {         
                //window.open('loadfileprint/'+data, '_blank');
            }
        });*/
    });
    
    $('#reportissueyear').click(function(){
        var y = $('#issueyear').val();
        
        $.ajax({
            type: 'GET',
            url: 'reportissueyear/'+y,
            data: '',
            success: function(data) {         
                window.open('loadfileprint/'+data, '_blank');
            }
        });
    });
    
     $('#reportusedep').click(function(){
        var d = $('#deplist').val();
        var y = $('#yearusedep').val();
        
        window.open('reportusedep/'+d+'/'+y);
        
    });
    
     $('#reportsixyear').click(function(){
        var y = $('#sixyear').val();
        
        window.open('reportusesix/'+y);
        
    });
    
    $('#vstore2').click(function(){
        var m = $('#mstore2').val();
        var y = $('#ystore2').val();
        
        window.open('reportstoreall2/'+m+'/'+y);
    });
    
    $('#vstore3').click(function(){
        var m = $('#mstore3').val();
        var y = $('#ystore3').val();
        
        window.open('reportstoreall3/'+m+'/'+y);
    });
    




    
    

})();






/* แก้ไขการรับ */
function recevie_edittemp(id)
{
   $.ajax({
            type: 'GET',
            url: 'gettempedit/'+id,
            data: '',
            success: function(data) {
                $('#ckedit').val(data.id);
                $('#supplier_re_id').val(data.supplier_name);
                $('#srid').val(data.supplier_re_id);
                $('#barcode').val(data.barcode);
                $('#priceunit').val(data.priceunit);
                $('#qty').val(data.qty);
                $('#pricetotal').val(data.pricetotal);
                $('#comment').val(data.comment);         
                $('#companytemp').val(data.company_id).prop('selected', true);
            }
    }); 
}








/**
 * [addReceive description]
 */
function addReceive()
{
    if( $('#receive_date').val() == '' )
    {
        alert('กรุณาลงวันที่รับ');
        $('#receive_date').focus();
    }
    else
    {
        $.ajax({
                type: 'POST',
                url: 'addReceive',
                data: 'd='+$('#receive_date').val(),
                success: function(data) {         
                    window.location.reload(true);
                }
        });
    }
}





/**
 * [clearTemp description]
 */
function clearTemp(id)
{
    if (confirm("ต้องการยกเลิกการบันทึกข้อมูล")) {
        $.ajax({
                type: 'GET',
                url: 'clearTemp/'+id,
                data: '',
                success: function(data) {         
                    window.location.reload(true);
                }
        });
    } else {
        return false;
    }  
}








/**
 * [addIssue description]
 */
function addIssue()
{
    if( $('#issue_date').val() == '' )
    {
        alert('กรุณาลงวันที่เบิก');
        $('#issue_date').focus();
    }
     if( $('#approve_q').val() == '' )
    {
        alert('กรุณาลงรอบที่จ่าย');
        $('#approve_q').focus();
    }
    else
    {
        $.ajax({
                type: 'POST',
                url: 'addIssue',
                data: 'd='+$('#issue_date').val()+'&q='+$('#approve_q').val(),
                success: function(data) {         
                    window.location.reload(true);
                }
        });
    }
}






/**
 * [clearissueTemp description]
 */
function clearissueTemp(id)
{
    if (confirm("ต้องการยกเลิกการบันทึกข้อมูล")) {
        $.ajax({
                type: 'GET',
                url: 'clearissueTemp/'+id,
                data: '',
                success: function(data) {         
                    window.location.reload(true);
                }
        });
    } else {
        return false;
    }  
}






/**
 * [sp_restore คืนพัสดุ]
 */
function sp_restore(id_issue, spid, supply)
{
    if (confirm("ต้องการคืนพัสดุเข้าคลัง")) {
        $.ajax({
                type: 'GET',
                url: 'sp_restore/'+id_issue+'/'+spid+'/'+supply,
                data: '',
                success: function(data) {         
                    window.location.reload(true);
                }
        });
    } else {
        return false;
    }  
}




/**
 * [sp_issue_bg เบิกพัสดุ เป็นรายการ]
 */
function sp_issue_bg(id_issue, spid)
{
    if (confirm("ต้องกาเบิกพัสดุ")) {
        
        var supply          = document.querySelectorAll("#frmsupply input[name='supply[]']");
             
        $.ajax({
                type: 'GET',
                url: 'sp_issue_bg/'+id_issue+'/'+spid+'/'+supply[0].value,
                data: '',
                success: function(data) {         
                    window.location.reload(true);
                }
        });
    } else {
        return false;
    }  
}








/**
 * check ie
 */
function check_ie()
{
	var isIE8 = false;
    var isIE9 = false;
    var isIE10 = false;

    isIE8 = !!navigator.userAgent.match(/MSIE 8.0/);
    isIE9 = !!navigator.userAgent.match(/MSIE 9.0/);
    isIE10 = !!navigator.userAgent.match(/MSIE 10.0/);

    if (isIE10) {
        $('html').addClass('ie10'); // detect IE10 version       
    }

    if (isIE10 || isIE9 || isIE8) {
       $('html').addClass('ie'); // detect IE10 version    
    }
}