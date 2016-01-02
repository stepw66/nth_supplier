(function(){

	/**
	 * รวม Data-Table
	 */
	

	




    /**
     * [storeTable]
     */
    var storeTable = $('#store-data').dataTable( {
        "iDisplayLength": 50,
        "bLengthChange": false,
        "language": {
            "lengthMenu": "_MENU_",
            "zeroRecords": "ไม่มีข้อมูล",
            "info": "หน้า _PAGE_ จาก _PAGES_",
            "infoEmpty": "ไม่มีข้อมูล",
            "sSearch": "ค้นหา: "            
        }
    } );
     






     /**
     * [listissueTempTable]
     */
    var listissueTempTable = $('#listissueTemp-data').dataTable( {
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




     /**
     * [listissueorderTable]
     */
    var listissueorderTable = $('#listissueorder-data').dataTable( {
        "iDisplayLength": 50,
        "bLengthChange": false,
        "language": {
            "lengthMenu": "_MENU_ แถวต่อหน้า",
            "zeroRecords": "ไม่มีข้อมูล",
            "info": "หน้า _PAGE_ จาก _PAGES_",
            "infoEmpty": "ไม่มีข้อมูล",
            "sSearch": "ค้นหา: "            
        }
    } );





    /**
     * [listorderdetailTable]
     */
    var listissueorderdetailTable = $('#listissueorderdetail-data').dataTable( {
        "iDisplayLength": 50,
        "bLengthChange": false,
        "language": {
            "lengthMenu": "_MENU_ แถวต่อหน้า",
            "zeroRecords": "ไม่มีข้อมูล",
            "info": "หน้า _PAGE_ จาก _PAGES_",
            "infoEmpty": "ไม่มีข้อมูล",
            "sSearch": "ค้นหา: "            
        }
    } );

 





     /**
     * [listTempTable]
     */
    var listTempTable = $('#listTemp-data').dataTable( {
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






    /**
     * [listorderTable]
     */
    var listorderTable = $('#listorder-data').dataTable( {
        "iDisplayLength": 50,
        "bLengthChange": false,
        "language": {
            "lengthMenu": "_MENU_ แถวต่อหน้า",
            "zeroRecords": "ไม่มีข้อมูล",
            "info": "หน้า _PAGE_ จาก _PAGES_",
            "infoEmpty": "ไม่มีข้อมูล",
            "sSearch": "ค้นหา: "            
        }
    } );





     /**
     * [listorderdetailTable]
     */
    var listorderdetailTable = $('#listorderdetail-data').dataTable( {
        "iDisplayLength": 50,
        "bLengthChange": false,
        "language": {
            "lengthMenu": "_MENU_ แถวต่อหน้า",
            "zeroRecords": "ไม่มีข้อมูล",
            "info": "หน้า _PAGE_ จาก _PAGES_",
            "infoEmpty": "ไม่มีข้อมูล",
            "sSearch": "ค้นหา: "            
        }
    } );
   
   





	/**
     * [supplierTable]
     */
    var supplierTable = $('#supplier-data').dataTable( {
        "iDisplayLength": 50,
        "bLengthChange": false,
        "language": {
            "lengthMenu": "_MENU_ แถวต่อหน้า",
            "zeroRecords": "ไม่มีข้อมูล",
            "info": "หน้า _PAGE_ จาก _PAGES_",
            "infoEmpty": "ไม่มีข้อมูล",
            "sSearch": "ค้นหา: "            
        }
    } );







	/**
	 * [userTable]
	 */
	var userTable = $('#user-data').dataTable( {
        "iDisplayLength": 10,
        "bLengthChange": false,
        "language": {
            "lengthMenu": "_MENU_ แถวต่อหน้า",
            "zeroRecords": "ไม่มีข้อมูล",
            "info": "หน้า _PAGE_ จาก _PAGES_",
            "infoEmpty": "ไม่มีข้อมูล",
            "sSearch": "ค้นหา: "            
        }
    } );





    /**
	 * [depTable]
	 */
	var depTable = $('#department-data').dataTable( {
        "iDisplayLength": 10,
        "bLengthChange": false,
        "language": {
            "lengthMenu": "_MENU_ แถวต่อหน้า",
            "zeroRecords": "ไม่มีข้อมูล",
            "info": "หน้า _PAGE_ จาก _PAGES_",
            "infoEmpty": "ไม่มีข้อมูล",
            "sSearch": "ค้นหา: "            
        },
        "columns": [
		    { "width": "10%" },		    
		    { "width": "80%" },
		    { "width": "10%" }
		]
    } );



    
    
     /**
     * [aroundTable]
     */
    var aroundTable = $('#around-data').dataTable( {
        "iDisplayLength": 30,
        "bLengthChange": false,
        "language": {
            "lengthMenu": "_MENU_ แถวต่อหน้า",
            "zeroRecords": "ไม่มีข้อมูล",
            "info": "หน้า _PAGE_ จาก _PAGES_",
            "infoEmpty": "ไม่มีข้อมูล",
            "sSearch": "ค้นหา: "            
        },
        "columns": [
            { "width": "10%" },
            { "width": "20%" },
            { "width": "50%" },
            { "width": "10%" }
        ]
    } );
    
    
    


    /**
     * [unitTable]
     */
    var unitTable = $('#unit-data').dataTable( {
        "iDisplayLength": 10,
        "bLengthChange": false,
        "language": {
            "lengthMenu": "_MENU_ แถวต่อหน้า",
            "zeroRecords": "ไม่มีข้อมูล",
            "info": "หน้า _PAGE_ จาก _PAGES_",
            "infoEmpty": "ไม่มีข้อมูล",
            "sSearch": "ค้นหา: "            
        },
        "columns": [
            { "width": "10%" },
            { "width": "80%" },
            { "width": "10%" }
        ]
    } );





    /**
     * [typeTable]
     */
    var typeTable = $('#type-data').dataTable( {
        "iDisplayLength": 10,
        "bLengthChange": false,
        "language": {
            "lengthMenu": "_MENU_ แถวต่อหน้า",
            "zeroRecords": "ไม่มีข้อมูล",
            "info": "หน้า _PAGE_ จาก _PAGES_",
            "infoEmpty": "ไม่มีข้อมูล",
            "sSearch": "ค้นหา: "            
        },
        "columns": [
            { "width": "10%" },
            { "width": "20%" },         
            { "width": "60%" },
            { "width": "10%" }
        ]
    } );
    
    
    
    
    /**
	 * [Table Calss all]
	 */
	var userTable = $('.tableall').dataTable( {
        "iDisplayLength": 10,
        "bLengthChange": false,
        "language": {
            "lengthMenu": "_MENU_ แถวต่อหน้า",
            "zeroRecords": "ไม่มีข้อมูล",
            "info": "หน้า _PAGE_ จาก _PAGES_",
            "infoEmpty": "ไม่มีข้อมูล",
            "sSearch": "ค้นหา: "            
        }
    } );



})();