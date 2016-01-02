<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Input;
use Request;
use Session;
use View;
use Redirect;
use Validator;
use DB;
use TCPDF;
use Response;
use File;
use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Style_NumberFormat;

class ReportController extends Controller
{
    
    
    
    
    /**
    * จำนวนเบิกรายการของแต่ละฝ่าย (รอบ)
    */
    public function report_issuedep_round() {
        if( Session::get('level') != '' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ) {              
            $year = DB::table('sp_issue')
                    ->select(DB::raw('year(issue_date) as y'))
                    ->groupby(DB::raw('year(issue_date)'))
                    ->get();
            
            $yearlist=[];
            foreach($year as $key=>$value) {
               $yearlist[$value->y] = ($value->y)+543; 
               $yaddk = ($value->y)+1;
               $yaddt = (($value->y)+543)+1; 
            }
            $yearlist[$yaddk] = $yaddt; 
            
            return View::make('report.report_issuedep_round', array('year' => $yearlist));
        }
        else {
            return Redirect::to('/');
        }
    }
    
    
    
    
    
    /**
    * จำนวนเบิกรายการของแต่ละฝ่าย (รอบ)
    */
    public function reportissuedep($l, $y) {
    
        if( Session::get('level') != '' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ) {                     
            $y = e($y);
            
            $y1 = ($y-1).'-10-01';
            $y2 = $y.'-09-30';

        	$dep = DB::table('sp_department')->orderby('id', 'asc')->get();
            $resultsp = DB::select('select * from sp_supplier order by sp_code asc');  
            
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial'); 
            $objPHPExcel->getActiveSheet()->setTitle('Sheet1');
            $objPHPExcel->setActiveSheetIndex(0);
            
            $objPHPExcel->getActiveSheet()->setCellValue('A1', 'ลำดับ');	
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);	
            $objPHPExcel->getActiveSheet()->setCellValue('B1', 'รายการ');
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);	
            
            $c = 'C';
            foreach ($dep as $key2 => $value2) {
                $objPHPExcel->getActiveSheet()->setCellValue($c.'1', $value2->dep_name);
                $objPHPExcel->getActiveSheet()->getStyle($c)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $objPHPExcel->getActiveSheet()->getColumnDimension($c)->setWidth(20);	
                $c++;
            }
            
            $objPHPExcel->getActiveSheet()->setCellValue($c.'1', 'รวม');
            $objPHPExcel->getActiveSheet()->getStyle($c)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
            $objPHPExcel->getActiveSheet()->getColumnDimension($c)->setWidth(20);	
  
            
			$row = 0;
		    foreach ($resultsp as $keysp) 		    
		    {	
		        $s=0;
                
		    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (0, $row+2, $keysp->sp_code);
			    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (1, $row+2, $keysp->sp_name);
                
                $sql  = ' select s1.id';
            
                $r=0;
                foreach ($dep as $key => $value) {
                    $r++;
                    $sql .= ' ,( select sum(d'.$r.'2.qty) from sp_issue d'.$r.' left join sp_issue_detail d'.$r.'2 on d'.$r.'2.id_issue=d'.$r.'.id left join sp_user d'.$r.'3 on d'.$r.'3.id=d'.$r.'.issue_user where d'.$r.'.approve_q='.e($l).' and d'.$r.'.issue_date between "'.$y1.'" and "'.$y2.'" and d'.$r.'3.id_dep='.$value->id.' and d'.$r.'2.supplier_is_id='.$keysp->id.' ) as dep'.$r.' ';
                }

                $sql .= ' from sp_issue s1';
                $sql .= ' left join sp_issue_detail s2 on s2.id_issue=s1.id';
                $sql .= ' where s1.approve_q='.e($l);
                $sql .= ' and s1.issue_date between "'.$y1.'" and "'.$y2.'" ';
                $sql .= ' and s2.supplier_is_id='.$keysp->id;
                $sql .= ' group by s2.supplier_is_id ';
                                
                $result = DB::select($sql); 
                            
                foreach ($result as $key){ 	
                
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (2, $row+2, $key->dep1);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (3, $row+2, $key->dep2);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (4, $row+2, $key->dep3);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (5, $row+2, $key->dep4);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (6, $row+2, $key->dep5);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (7, $row+2, $key->dep6);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (8, $row+2, $key->dep7);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (9, $row+2, $key->dep8);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (10, $row+2, $key->dep9);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (11, $row+2, $key->dep10);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (12, $row+2, $key->dep11);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (13, $row+2, $key->dep12);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (14, $row+2, $key->dep13);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (15, $row+2, $key->dep14);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (16, $row+2, $key->dep15);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (17, $row+2, $key->dep16);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (18, $row+2, $key->dep17);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (19, $row+2, $key->dep18);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (20, $row+2, $key->dep19);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (21, $row+2, $key->dep20);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (22, $row+2, $key->dep21);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (23, $row+2, $key->dep22);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (24, $row+2, $key->dep23);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (25, $row+2, $key->dep24);

                    $s += ($key->dep1)+($key->dep2)+($key->dep3)+($key->dep4)+($key->dep5)+($key->dep6)+($key->dep7)+($key->dep8)+($key->dep9)+($key->dep10);	
                    $s += ($key->dep11)+($key->dep12)+($key->dep13)+($key->dep14)+($key->dep15)+($key->dep16)+($key->dep17)+($key->dep18)+($key->dep19)+($key->dep20);
                    $s += ($key->dep21)+($key->dep22)+($key->dep23)+($key->dep24);

                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (26, $row+2, $s);       
                
                }
                
                $row++;	
                
			}
           
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); // Set excel version 2007	  		
            $objWriter->save(storage_path()."/report/report_issuedep.xls");

            return Response::download( storage_path()."/report/report_issuedep.xls", "report_issuedep.xls");	
			            
        }
        else {
            return Redirect::to('/');
        }
    
    }
    
    
    
    
    
    /**
    * จำนวนเบิกรายการของแต่ละฝ่าย (ปีงบประมาณ)
    */
    public function report_issue_year()
    {
       if( Session::get('level') != '' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ) {              
            $year = DB::table('sp_issue')
                    ->select(DB::raw('year(issue_date) as y'))
                    ->groupby(DB::raw('year(issue_date)'))
                    ->get();
            
            $yearlist=[];
            foreach($year as $key=>$value) {
               $yearlist[$value->y] = ($value->y)+543; 
               $yaddk = ($value->y)+1;
               $yaddt = (($value->y)+543)+1; 
            }
            $yearlist[$yaddk] = $yaddt; 
            
            return View::make('report.report_issue_year', array('year' => $yearlist));
        }
        else {
            return Redirect::to('/');
        }
    }
    
    
    
    
    
    /**
    * จำนวนเบิกรายการของแต่ละฝ่าย (ปีงบประมาณ)
    */
    public function reportissueyear($id)
    {
        if( Session::get('level') != '' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ) {                   
            $y = e($id);
            
            $y1 = ($y-1).'-10-01';
            $y2 = $y.'-09-30';

            $sql  = ' select sp.sp_code, sp.sp_name ';
            
            $sql .= ' ,( select sum(p12.qty) from sp_receive p11 left join sp_receive_detail p12 on p11.id=p12.id_receive where p12.supplier_re_id=sp.id and p11.receive_date between "'.$y1.'" and "'.$y2.'"  ) as total_receive ';
            
            $sql .= ' ,( select sum(p22.supply) from sp_issue p21 left join sp_issue_detail p22 on p21.id=p22.id_issue where p22.supplier_is_id=sp.id and p21.issue_date between "'.$y1.'" and "'.$y2.'"  ) as totalissue  ';
        
            $sql .= ' from sp_supplier sp';
            $sql .= ' order by sp.sp_code asc';
           
            $result = DB::select($sql);         
            
            $pdf = new TCPDF();
			$pdf->SetPrintHeader(false);
		    $pdf->SetPrintFooter(true);	

		    $pdf->setHeaderFont(array('freeserif','B',13));
			$pdf->setFooterFont(array('freeserif','B',PDF_FONT_SIZE_DATA));

		    $pdf->SetHeaderData('', '', '', '');			
			 		   
			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
			 
			// set margins
			$pdf->SetMargins(5, 5, 5, 5);

			$pdf->SetFont('freeserif','',10,'',true);
			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, 5);

			$pdf->AddPage('P', 'A4');

			$tbl  = ' <style> ';
			$tbl .= '  table.table-report tr td{ border:1px solid #000; height:20px; line-height: 20px; } ';	
			$tbl .= ' .text-bold { font-weight: bold; } ';		
			$tbl .= ' </style> ';

			 
			$r=0;
		    foreach ($result as $key) 		    
		    {	
		       $r++;
		       $s=0;
                
                if( $r == 1 ){
                    $tbl  .= '<h3>จำนวนเบิกรายการวัสดุของแต่ละฝ่าย ปีงบประมาณ '.($y+543).' </h3><br /> <table class="table-report"> ';

                    $tbl  .='<tr>';
                    $tbl  .='<td width="30" align="center">ลำดับ</td>';
                    $tbl  .='<td width="200" align="center">รายการ</td>';	
                    $tbl  .='<td align="center">รวมรับ</td>';	
                    $tbl  .='<td align="center">รวมเบิก</td>';
                    $tbl  .='<td align="center">คงเหลือ</td>';
                    $tbl  .='</tr>';	
                }
		      
		    	$tbl .= ' <tr>';

			    $tbl .= ' <td width="30" align="center">';
			    $tbl .= $key->sp_code;
			    $tbl .= ' </td>';
			    
			    $tbl .= ' <td width="200" align="left"> ';
			    $tbl .= $key->sp_name;
			    $tbl .= ' </td>';
				
                
                $tbl  .='<td align="center">'.$key->total_receive.'</td>';   
                
                $tbl  .='<td align="center">'.$key->totalissue.'</td>';
                
                $tbl  .='<td align="center">'.(($key->total_receive)-($key->totalissue)).'</td>';

			    $tbl .= ' </tr>';	
                
              
                if( $r == 38 ){
                   $tbl .='</table>';
                   $r=0;
                }
		   				    	
			}
            
            if( count($result) == 0 ){
                $tbl = '<table><tr><td> ไม่มีข้อมูล. </td></tr>';
            }
            
            $tbl .='</table>';
			
			$pdf->writeHTML( $tbl, true, false, false, false, '' );

		    $filename = storage_path() . '/report/report_issueyear.pdf';
		    $contents = $pdf->output($filename, 'F');
			 
            return 'report_issueyear.pdf';
        }
        else {
            return Redirect::to('/');
        }
    }
    
    
    
    
    
    
    /**
    * จำนวนใช้พัสดุประจำปี(ปีงบประมาณ) หน่วยงาน
    */
    public function report_use_dep()
    {
        if( Session::get('level') != '' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ) {              
            $year = DB::table('sp_issue')
                    ->select(DB::raw('year(issue_date) as y'))
                    ->groupby(DB::raw('year(issue_date)'))
                    ->get();
            
            $yearlist=[];
            foreach($year as $key=>$value) {
               $yearlist[$value->y] = ($value->y)+543; 
               $yaddk = ($value->y)+1;
               $yaddt = (($value->y)+543)+1; 
            }
            $yearlist[$yaddk] = $yaddt; 
            
            $dep = DB::table('sp_department')->get();
            
            $deplist=[];
            foreach($dep as $key=>$value) {
               $deplist[$value->id] = $value->dep_name; 
            }
            
            
            
            return View::make('report.report_use_dep', array('year' => $yearlist, 'deplist' => $deplist));
        }
        else {
            return Redirect::to('/');
        }
    }
    
    
    
    
    
    
     /**
    * จำนวนใช้พัสดุประจำปี(ปีงบประมาณ) หน่วยงาน
    */
    public function reportusedep($dep, $y)
    {
        if( Session::get('level') != '' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ) {              
          $around = DB::table('sp_around')->orderby('id', 'asc')->get();
          $resultsp = DB::select('select s1.id, s1.sp_code, s1.sp_name, s2.type_name from sp_supplier s1 left join sp_type s2 on s2.type_code=s1.type_code order by s1.sp_code asc');  
            
          $y1 = ($y-1).'-10-01';
          $y2 = $y.'-09-30';    
                                                                    
            
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial'); 
            $objPHPExcel->getActiveSheet()->setTitle('Sheet1');
            $objPHPExcel->setActiveSheetIndex(0);
            
            $objPHPExcel->getActiveSheet()->setCellValue('A1', 'ลำดับ');	
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);	
            $objPHPExcel->getActiveSheet()->setCellValue('B1', 'รายการ');
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
            $objPHPExcel->getActiveSheet()->setCellValue('C1', 'ประเภท');
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);	
            
            $d = 'D';
            foreach ($around as $key2 => $value2) {
                $objPHPExcel->getActiveSheet()->setCellValue($d.'1', 'รอบ '.$value2->around);	
                $objPHPExcel->getActiveSheet()->getStyle($d)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER); 
                $objPHPExcel->getActiveSheet()->getColumnDimension($d)->setWidth(20);	
                $d++;
            }
            
            $objPHPExcel->getActiveSheet()->setCellValue($d++.'1', 'รวมเบิก');	
            $objPHPExcel->getActiveSheet()->getStyle($d)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
            $objPHPExcel->getActiveSheet()->getColumnDimension($d)->setWidth(20);	
            
            $objPHPExcel->getActiveSheet()->setCellValue($d++.'1', 'เป็นเงิน');	
            $objPHPExcel->getActiveSheet()->getStyle($d++)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
            $objPHPExcel->getActiveSheet()->getColumnDimension($d++)->setWidth(20);	
  
            
			$row = 0;
		    foreach ($resultsp as $keysp) 		    
		    {	
		        
                
		    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (0, $row+2, $keysp->sp_code);
			    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (1, $row+2, $keysp->sp_name);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (2, $row+2, $keysp->type_name);
                
                $sql  = ' select s2.price ';
            
                $r=0;
                foreach ($around as $key => $value) {
                    $r++;
                    $sql .= ' ,( select sum(d'.$r.'2.qty) from sp_issue d'.$r.' left join sp_issue_detail d'.$r.'2 on d'.$r.'2.id_issue=d'.$r.'.id left join sp_user d'.$r.'3 on d'.$r.'3.id=d'.$r.'.issue_user where d'.$r.'.approve_q='.$value->around.'  and d'.$r.'.issue_date between "'.$y1.'" and "'.$y2.'" and d'.$r.'3.id_dep='.$dep.' and d'.$r.'2.supplier_is_id= '.$keysp->id.' ) as r'.$r.' ';
                }

                $sql .= ' from sp_around a';
                $sql .= ' left join sp_issue s1 on s1.approve_q = a.around';
                $sql .= ' left join sp_issue_detail s2 on s2.id_issue=s1.id';
                $sql .= ' left join sp_user s4 on s4.id=s1.issue_user';
                $sql .= ' where s4.id_dep='.e($dep);
                $sql .= ' and s1.issue_date between "'.$y1.'" and "'.$y2.'" ';
                $sql .= ' and s2.supplier_is_id='.$keysp->id;
                $sql .= ' group by s2.supplier_is_id';
                
                $result = DB::select($sql); 
                              
                foreach ($result as $key) {	
                    
                    $sumissue=0;
                    $sumprice=0;
                
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (3, $row+2, $key->r1);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (4, $row+2, $key->r2);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (5, $row+2, $key->r3);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (6, $row+2, $key->r4);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (7, $row+2, $key->r5);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (8, $row+2, $key->r6);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (9, $row+2, $key->r7);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (10, $row+2, $key->r8);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (11, $row+2, $key->r9);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (12, $row+2, $key->r10);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (13, $row+2, $key->r11);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (14, $row+2, $key->r12);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (15, $row+2, $key->r13);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (16, $row+2, $key->r14);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (17, $row+2, $key->r15);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (18, $row+2, $key->r16);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (19, $row+2, $key->r17);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (20, $row+2, $key->r18);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (21, $row+2, $key->r19);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (22, $row+2, $key->r20);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (23, $row+2, $key->r21);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (24, $row+2, $key->r22);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (25, $row+2, $key->r23);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (26, $row+2, $key->r24);


                    $sumissue += ($key->r1)+($key->r2)+($key->r3)+($key->r4)+($key->r5)+($key->r6)+($key->r7)+($key->r8)+($key->r9)+($key->r10);	
                    $sumissue += ($key->r11)+($key->r12)+($key->r13)+($key->r14)+($key->r15)+($key->r16)+($key->r17)+($key->r18)+($key->r19)+($key->r20);
                    $sumissue += ($key->r21)+($key->r22)+($key->r23)+($key->r24);


                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (27, $row+2, $sumissue);
                    
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (28, $row+2, ($this->getprice($keysp->id)*$sumissue) );
                
                }
                
		   		$row++;			    	
			}
           
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); // Set excel version 2007	  		
            $objWriter->save(storage_path()."/report/report_usedep.xls");

            return Response::download( storage_path()."/report/report_usedep.xls", "report_usedep.xls");
           
        }
        else {
            return Redirect::to('/');
        }
    }
    
    
    
    
    
    
    /**
    * สรุปการใช้พัสดุ (ปีงบประมาณ) 6 เดือนแรก
    */
    public function report_use_six()
    {
        if( Session::get('level') != '' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ) {              
            $year = DB::table('sp_issue')
                    ->select(DB::raw('year(issue_date) as y'))
                    ->groupby(DB::raw('year(issue_date)'))
                    ->get();
            
            $yearlist=[];
            foreach($year as $key=>$value) {
               $yearlist[$value->y] = ($value->y)+543; 
               $yaddk = ($value->y)+1;
               $yaddt = (($value->y)+543)+1; 
            }
            $yearlist[$yaddk] = $yaddt; 
            
            return View::make('report.report_use_six', array('year' => $yearlist));
        }
        else {
            return Redirect::to('/');
        }
    }
    
    
    
    
    /**
    * สรุปการใช้พัสดุ (ปีงบประมาณ) 6 เดือนแรก
    */
     public function reportusesix($y)
    {
        if( Session::get('level') != '' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ) {                                	

        	$dep = DB::table('sp_department')->orderby('id', 'asc')->get();
            
            $d1 = ($y-1).'-10-01';
            $d2 = $y.'-03-31';

            $sql  = ' select s3.sp_code, s3.sp_name, s2.price ';
            
            $r=0;
            foreach ($dep as $key => $value) {
            	$r++;
            	$sql .= ' ,( select sum(d'.$r.'2.qty) from sp_issue d'.$r.' left join sp_issue_detail d'.$r.'2 on d'.$r.'2.id_issue=d'.$r.'.id left join sp_user d'.$r.'3 on d'.$r.'3.id=d'.$r.'.issue_user where d'.$r.'.issue_date between "'.$d1.'" and "'.$d2.'" and d'.$r.'3.id_dep='.$value->id.' and d'.$r.'2.supplier_is_id=s3.id ) as dep'.$r.' ';
            }

            $sql .= ' from sp_issue s1';
            $sql .= ' left join sp_issue_detail s2 on s2.id_issue=s1.id';
            $sql .= ' left join sp_supplier s3 on s3.id=s2.supplier_is_id';
            $sql .= ' where';
            $sql .= ' s1.issue_date  between "'.$d1.'" and "'.$d2.'" ';
            $sql .= ' group by s3.sp_code order by s3.sp_code asc ';  

            $result = DB::select($sql);  
            
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial'); 
            $objPHPExcel->getActiveSheet()->setTitle('Sheet1');
            $objPHPExcel->setActiveSheetIndex(0);
            
            $objPHPExcel->getActiveSheet()->setCellValue('A1', 'ลำดับ');	
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);	
            $objPHPExcel->getActiveSheet()->setCellValue('B1', 'รายการ');
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);	
            
            $c = 'C';
            foreach ($dep as $key2 => $value2) {
                $objPHPExcel->getActiveSheet()->setCellValue($c.'1', $value2->dep_name);
                $objPHPExcel->getActiveSheet()->getStyle($c)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
                $objPHPExcel->getActiveSheet()->getColumnDimension($c)->setWidth(20);	
                $c++;
            }
            
            $objPHPExcel->getActiveSheet()->setCellValue($c.'1', 'รวม');
            $objPHPExcel->getActiveSheet()->getStyle($c)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
            $objPHPExcel->getActiveSheet()->getColumnDimension($c)->setWidth(20);
            
            $objPHPExcel->getActiveSheet()->setCellValue($c++.'1', 'เป็นเงิน');	
            $objPHPExcel->getActiveSheet()->getStyle($c++)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
            $objPHPExcel->getActiveSheet()->getColumnDimension($c++)->setWidth(20); 
            
			$row = 0;
		    foreach ($result as $key) 		    
		    {	
		       $s=0;
               $sumprice=0;
                
		    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (0, $row+2, $key->sp_code);
			    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (1, $row+2, $key->sp_name);
                
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (2, $row+2, $key->dep1);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (3, $row+2, $key->dep2);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (4, $row+2, $key->dep3);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (5, $row+2, $key->dep4);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (6, $row+2, $key->dep5);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (7, $row+2, $key->dep6);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (8, $row+2, $key->dep7);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (9, $row+2, $key->dep8);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (10, $row+2, $key->dep9);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (11, $row+2, $key->dep10);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (12, $row+2, $key->dep11);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (13, $row+2, $key->dep12);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (14, $row+2, $key->dep13);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (15, $row+2, $key->dep14);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (16, $row+2, $key->dep15);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (17, $row+2, $key->dep16);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (18, $row+2, $key->dep17);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (19, $row+2, $key->dep18);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (20, $row+2, $key->dep19);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (21, $row+2, $key->dep20);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (22, $row+2, $key->dep21);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (23, $row+2, $key->dep22);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (24, $row+2, $key->dep23);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (25, $row+2, $key->dep24);
                
                $s += ($key->dep1)+($key->dep2)+($key->dep3)+($key->dep4)+($key->dep5)+($key->dep6)+($key->dep7)+($key->dep8)+($key->dep9)+($key->dep10);	
				$s += ($key->dep11)+($key->dep12)+($key->dep13)+($key->dep14)+($key->dep15)+($key->dep16)+($key->dep17)+($key->dep18)+($key->dep19)+($key->dep20);
				$s += ($key->dep21)+($key->dep22)+($key->dep23)+($key->dep24);
                
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (26, $row+2, $s);
                
                $sumprice += $key->price;
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (27, $row+2, $sumprice);
               
		   		$row++;			    	
			}
           
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); // Set excel version 2007	  		
            $objWriter->save(storage_path()."/report/report_usesix.xls");

            return Response::download( storage_path()."/report/report_usesix.xls", "report_usesix.xls");	
			            
        }
        else {
            return Redirect::to('/');
        }
    }
    
    
    
    
    
    
    /**
    * รายการพัสดุคงคลัง
    */
    public function report_store_all()
    {
        if( Session::get('level') != '' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ) {                         
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial'); 
            $objPHPExcel->getActiveSheet()->setTitle('Sheet1');
            $objPHPExcel->setActiveSheetIndex(0);
            
            $objPHPExcel->getActiveSheet()->setCellValue('A1', 'รายการพัสดุคงคลัง');	
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(50);	
            
            $objPHPExcel->getActiveSheet()->setCellValue('A2', 'ลำดับ');	
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);	
            $objPHPExcel->getActiveSheet()->setCellValue('B2', 'รายการ');
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);	
            $objPHPExcel->getActiveSheet()->setCellValue('C2', 'ประเภท');
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
            
            $objPHPExcel->getActiveSheet()->setCellValue('D2', 'ราคา');
            $objPHPExcel->getActiveSheet()->getStyle('D2')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);	
            
            $objPHPExcel->getActiveSheet()->setCellValue('E2', 'คงเหลือ');
            $objPHPExcel->getActiveSheet()->getStyle('E2')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);	
            
            $objPHPExcel->getActiveSheet()->setCellValue('F2', 'มูลค่าคงคลัง');
            $objPHPExcel->getActiveSheet()->getStyle('F2')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);	
            
			$row = 2;
            
            $sql  = ' select s1.id, s1.sp_name, s1.sp_code, s2.type_name, s0.priceunit, sum(s0.qty) as totalsp, s0.priceunit*sum(s0.qty) as totalprice';
            $sql .= ' from sp_store s0';
            $sql .= ' left join sp_supplier s1 on s1.id = s0.supplier_re_id';
            $sql .= ' left join sp_type s2 on s2.type_code=s1.type_code';
            $sql .= ' where s1.sp_code not like "%D%" ';
            $sql .= ' group by s1.sp_code, s0.priceunit';
            $sql .= ' order by s1.sp_code asc';
            
            $resultsp = DB::select($sql);  
            
		    foreach ($resultsp as $keysp) 		    
		    {	
		      
		    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (0, $row+2, $keysp->sp_code);
			    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (1, $row+2, $keysp->sp_name);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (2, $row+2, $keysp->type_name);
                                
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (3, $row+2, $keysp->priceunit);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (4, $row+2, $keysp->totalsp);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (5, $row+2, $keysp->totalprice);
                
                $row++;	
                
			}
           
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); // Set excel version 2007	  		
            $objWriter->save(storage_path()."/report/report_storeall.xls");

            return Response::download( storage_path()."/report/report_storeall.xls", "report_storeall.xls");	
			            
        }
        else {
            return Redirect::to('/');
        }
    }
    
    
    
    
    
     /**
    * แบบรายงานมูลค่าวัสดุคงคลัง
    */
    public function report_store_all_2()
    {
         $year = DB::table('sp_issue')
                    ->select(DB::raw('year(issue_date) as y'))
                    ->groupby(DB::raw('year(issue_date)'))
                    ->get();
            
            $yearlist=[];
            foreach($year as $key=>$value) {
               $yearlist[$value->y] = ($value->y)+543; 
               $yaddk = ($value->y)+1;
               $yaddt = (($value->y)+543)+1; 
            }
            $yearlist[$yaddk] = $yaddt; 
            
            return View::make('report.report_store_all_2', array('year' => $yearlist, 'month' => $this->get_month()));
    }
    
    
    
    
     /**
    * แบบรายงานมูลค่าวัสดุคงคลัง
    */
    public function reportstoreall2($m, $y)
    {      
            $pdf = new TCPDF();
			$pdf->SetPrintHeader(false);
		    $pdf->SetPrintFooter(true);	

		    $pdf->setHeaderFont(array('angsanaupc','B',13));
			$pdf->setFooterFont(array('angsanaupc','B',PDF_FONT_SIZE_DATA));

		    $pdf->SetHeaderData('', '', '', '');			
			 		   
			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
			 
			// set margins
			$pdf->SetMargins(5, 5, 5, 5);

			$pdf->SetFont('angsanaupc','',14,'',true);
			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, 5);

			$pdf->AddPage('P', 'A4');

            $pdf->SetXY(10, 15);
		    $pdf->MultiCell(190, 5, 'แบบรายงานมูลค่าวัสดุคงคลัง', 0, 'C', 0, 1, '', '', true);  
            $pdf->SetXY(10, 20);
            $pdf->MultiCell(190, 5, 'โรงพยาบาลโนนไทย จังหวัดนครราชสีมา', 0, 'C', 0, 1, '', '', true); 
            $pdf->SetXY(10, 25);
            $pdf->MultiCell(190, 5, 'ประจำเดือน '.$m.'/'.($y+543), 0, 'C', 0, 1, '', '', true); 
        
            $pdf->SetXY(10, 35);
            $pdf->MultiCell(190, 5, 'ประเภทวัสดุ', 0, 'L', 0, 1, '', '', true); 
        
            $pdf->SetXY(10, 45);
            $pdf->MultiCell(70, 5, '1 วัสดุสำนักงาน', 0, 'L', 0, 1, '', '', true); 
            $pdf->SetXY(80, 45);
            $pdf->MultiCell(70, 5, 'มูลค่าคงเหลือ     '.number_format($this->gettotaltype_A(), 2).'  บาท', 0, 'L', 0, 1, '', '', true); 
        
            $pdf->SetXY(10, 50);
            $pdf->MultiCell(70, 5, '2 วัสดุคอมพิวเตอร์', 0, 'L', 0, 1, '', '', true); 
            $pdf->SetXY(80, 50);
            $pdf->MultiCell(70, 5, 'มูลค่าคงเหลือ     '.number_format($this->gettotaltype_B(), 2).'  บาท', 0, 'L', 0, 1, '', '', true); 
        
            $pdf->SetXY(10, 55);
            $pdf->MultiCell(70, 5, '3 วัสดุงานบ้านงานครัว', 0, 'L', 0, 1, '', '', true); 
            $pdf->SetXY(80, 55);
            $pdf->MultiCell(70, 5, 'มูลค่าคงเหลือ     '.number_format($this->gettotaltype_C(), 2).'  บาท', 0, 'L', 0, 1, '', '', true);
        
            $pdf->SetXY(10, 60);
            $pdf->MultiCell(70, 5, '4 วัสดุไฟฟ้าและวิทยุ', 0, 'L', 0, 1, '', '', true); 
            $pdf->SetXY(80, 60);
            $pdf->MultiCell(70, 5, 'มูลค่าคงเหลือ     '.'-'.'  บาท', 0, 'L', 0, 1, '', '', true);
        
            $pdf->SetXY(10, 65);
            $pdf->MultiCell(70, 5, '5 วัสดุบริโภค', 0, 'L', 0, 1, '', '', true); 
            $pdf->SetXY(80, 65);
            $pdf->MultiCell(70, 5, 'มูลค่าคงเหลือ     '.'-'.'  บาท', 0, 'L', 0, 1, '', '', true);
        
            $pdf->SetXY(10, 70);
            $pdf->MultiCell(70, 5, '6 วัสดุเชื่อเพลิงและหล่อลื่น', 0, 'L', 0, 1, '', '', true); 
            $pdf->SetXY(80, 70);
            $pdf->MultiCell(70, 5, 'มูลค่าคงเหลือ     '.'-'.'  บาท', 0, 'L', 0, 1, '', '', true);
        
            $pdf->SetXY(10, 75);
            $pdf->MultiCell(70, 5, '7 วัสดุเครื่องแต่งกาย', 0, 'L', 0, 1, '', '', true); 
            $pdf->SetXY(80, 75);
            $pdf->MultiCell(70, 5, 'มูลค่าคงเหลือ     '.'-'.'  บาท', 0, 'L', 0, 1, '', '', true);
        
            $pdf->SetXY(10, 80);
            $pdf->MultiCell(70, 5, '8 วัสดุยานพาหนะและขนส่ง', 0, 'L', 0, 1, '', '', true); 
            $pdf->SetXY(80, 80);
            $pdf->MultiCell(70, 5, 'มูลค่าคงเหลือ     '.'-'.'  บาท', 0, 'L', 0, 1, '', '', true);
        
            $pdf->SetXY(10, 85);
            $pdf->MultiCell(70, 5, '9 วัสดุก่อสร้าง', 0, 'L', 0, 1, '', '', true); 
            $pdf->SetXY(80, 85);
            $pdf->MultiCell(70, 5, 'มูลค่าคงเหลือ     '.'-'.'  บาท', 0, 'L', 0, 1, '', '', true);
        
            $pdf->SetXY(10, 90);
            $pdf->MultiCell(70, 5, '10 วัสดุโฆษณาและเผยแพร่', 0, 'L', 0, 1, '', '', true); 
            $pdf->SetXY(80, 90);
            $pdf->MultiCell(70, 5, 'มูลค่าคงเหลือ     '.'-'.'  บาท', 0, 'L', 0, 1, '', '', true);
        
            $pdf->SetXY(10, 95);
            $pdf->MultiCell(70, 5, '11 วัสดุอื่น ๆ', 0, 'L', 0, 1, '', '', true); 
            $pdf->SetXY(80, 95);
            $pdf->MultiCell(70, 5, 'มูลค่าคงเหลือ     '.'-'.'  บาท', 0, 'L', 0, 1, '', '', true);
                
            $pdf->SetXY(75, 105);
            $pdf->MultiCell(70, 5, 'รวมมูลค่าคงเหลือ     '.number_format(($this->gettotaltype_A()+$this->gettotaltype_B()+$this->gettotaltype_C()), 2).'  บาท', 0, 'L', 0, 1, '', '', true);
        
        
            $pdf->SetXY(75, 125);
            $pdf->MultiCell(100, 5, 'ลงชื่อ...................................................ผู้รายงาน', 0, 'L', 0, 1, '', '', true);
            $pdf->SetXY(78, 132);
            $pdf->MultiCell(100, 5, '(นางสาวเสาวนีย์ สมัครณรงค์)', 0, 'L', 0, 1, '', '', true);
            $pdf->SetXY(78, 139);
            $pdf->MultiCell(100, 5, 'วันที่............./......................../...............', 0, 'L', 0, 1, '', '', true);
        
        
            $pdf->SetXY(75, 155);
            $pdf->MultiCell(100, 5, 'ลงชื่อ...................................................ผู้รับรองรายงาน', 0, 'L', 0, 1, '', '', true);
            $pdf->SetXY(78, 162);
            $pdf->MultiCell(100, 5, '(นางปรานอม คากลาง)', 0, 'L', 0, 1, '', '', true);
            $pdf->SetXY(78, 169);
            $pdf->MultiCell(100, 5, 'วันที่............./......................../...............', 0, 'L', 0, 1, '', '', true);
           
            $pdf->SetXY(10, 190);
            $pdf->MultiCell(170, 5, 'หมายเหตุ ส่งรายงานนี้ภายในวันที่ 7 ของทุกเดือนที่งานการเงินและบัญชี / ฝ่ายบริหารงานทั่วไป', 0, 'L', 0, 1, '', '', true); 
                    

		    $filename = storage_path() . '/report/reportstoreall.pdf';
		    $contents = $pdf->output($filename, 'I');
			 
            return storage_path().'/report/reportstoreall.pdf';
    }
    
    
    
    
    
    
    
     /**
    * รายงานมูลค่าคงคลังและมูลค่าการใช้
    */
    public function report_store_all_3()
    {
         $year = DB::table('sp_issue')
                    ->select(DB::raw('year(issue_date) as y'))
                    ->groupby(DB::raw('year(issue_date)'))
                    ->get();
            
            $yearlist=[];
            foreach($year as $key=>$value) {
               $yearlist[$value->y] = ($value->y)+543; 
               $yaddk = ($value->y)+1;
               $yaddt = (($value->y)+543)+1; 
            }
            $yearlist[$yaddk] = $yaddt; 
            
            return View::make('report.report_store_all_3', array('year' => $yearlist, 'month' => $this->get_month()));
    }
    
    
    
    
    
    
     /**
    * รายงานมูลค่าคงคลังและมูลค่าการใช้
    */
    public function reportstoreall3($m, $y)
    {
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial'); 
            $objPHPExcel->getActiveSheet()->setTitle('Sheet1');
            $objPHPExcel->setActiveSheetIndex(0);
            
            $objPHPExcel->getActiveSheet()->setCellValue('A1', 'รายงานมูลค่าคงคลังและมูลค่าการใช้');	
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(50);	
            
            $objPHPExcel->getActiveSheet()->setCellValue('A2', 'รายการ');	
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(50);	
            
            $objPHPExcel->getActiveSheet()->setCellValue('B2', 'เดือน '.$m.'/'.($y+543) );
            $objPHPExcel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode("#,##0.00");
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);	
           
        
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (0, 4, 'มูลค่าคงคลัง');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (0, 5, 'มูลค่าการเบิก');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (0, 6, 'อัตราของคงคลัง');
        
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (1, 4, ($this->gettotaltype_A()+$this->gettotaltype_B()+$this->gettotaltype_C()));
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (1, 5, $this->gettotalissuemoney($m, $y));
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (1, 6, ($this->gettotaltype_A()+$this->gettotaltype_B()+$this->gettotaltype_C())/($this->gettotalissuemoney($m, $y)) );
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (1, 7, ($this->gettotaltype_A()+$this->gettotaltype_B()+$this->gettotaltype_C())-($this->gettotalissuemoney($m, $y)) );
            

            
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (0, 9, 'มูลค่าการใช้งาน');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (0, 10, 'สำนักงาน');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (0, 11, 'คอมพิวเตอร์');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (0, 12, 'งานบ้าน-งานครัว');
        
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (1, 10, $this->gettotalissuemoney_A($m, $y) );
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (1, 11, $this->gettotalissuemoney_B($m, $y) );
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (1, 12, $this->gettotalissuemoney_C($m, $y) );
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (1, 13, ($this->gettotalissuemoney_A($m, $y)+ $this->gettotalissuemoney_B($m, $y)+$this->gettotalissuemoney_C($m, $y)) );
        
		   
           
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); // Set excel version 2007	  		
            $objWriter->save(storage_path()."/report/reportstoreall3.xls");

            return Response::download( storage_path()."/report/reportstoreall3.xls", "reportstoreall3.xls");	
    }
    
    
    
    
    
    
    
    //คงคลัง Type A
    public function gettotaltype_A()
    {
        $data = DB::table('sp_store')
                ->leftjoin('sp_supplier', 'sp_supplier.id', '=', 'sp_store.supplier_re_id')
                ->where('sp_supplier.type_code', 'A')
                ->select(DB::raw('sum(sp_store.pricetotal) as totalmoney'))
                ->groupby('sp_supplier.type_code')
                ->first();
        
        return $data->totalmoney;  
    }
    
     //คงคลัง Type B
    public function gettotaltype_B()
    {
        $data = DB::table('sp_store')
                ->leftjoin('sp_supplier', 'sp_supplier.id', '=', 'sp_store.supplier_re_id')
                ->where('sp_supplier.type_code', 'B')
                ->select(DB::raw('sum(sp_store.pricetotal) as totalmoney'))
                ->groupby('sp_supplier.type_code')
                ->first();
        
        return $data->totalmoney;  
    }
    
     //คงคลัง Type C
    public function gettotaltype_C()
    {
        $data = DB::table('sp_store')
                ->leftjoin('sp_supplier', 'sp_supplier.id', '=', 'sp_store.supplier_re_id')
                ->where('sp_supplier.type_code', 'C')
                ->select(DB::raw('sum(sp_store.pricetotal) as totalmoney'))
                ->groupby('sp_supplier.type_code')
                ->first();
        
        return $data->totalmoney;  
    }
    
    //มูลค่าการเบิก
    public function gettotalissuemoney($m, $y)
    {
        $sql = ' select sum((supply*(select st.priceunit from sp_store st where st.supplier_re_id=s1.supplier_is_id order by st.id desc limit 1 ))) as totalprice';
        $sql .= ' from sp_issue s0';
        $sql .= ' left join sp_issue_detail s1 on s1.id_issue=s0.id';
        $sql .= ' where year(s0.issue_date)='.$y.' and month(s0.issue_date)='.$m.' ';
        
        $data = DB::select($sql);
        
        foreach($data as $value){
            return $value->totalprice;
        }
    }
    
     //มูลค่าการเบิก Type A
    public function gettotalissuemoney_A($m, $y)
    {
        $sql = ' select sum((supply*(select st.priceunit from sp_store st where st.supplier_re_id=s1.supplier_is_id order by st.id desc limit 1 ))) as totalprice';
        $sql .= ' from sp_issue s0';
        $sql .= ' left join sp_issue_detail s1 on s1.id_issue=s0.id';
        $sql .= ' where year(s0.issue_date)='.$y.' and month(s0.issue_date)='.$m.' and s1.supplier_is_id in (select id from sp_supplier where type_code="A") ';
        
        $data = DB::select($sql);
        
        foreach($data as $value){
            return $value->totalprice;
        }
    }
    
     //มูลค่าการเบิก Type B
    public function gettotalissuemoney_B($m, $y)
    {
        $sql = ' select sum((supply*(select st.priceunit from sp_store st where st.supplier_re_id=s1.supplier_is_id order by st.id desc limit 1 ))) as totalprice';
        $sql .= ' from sp_issue s0';
        $sql .= ' left join sp_issue_detail s1 on s1.id_issue=s0.id';
        $sql .= ' where year(s0.issue_date)='.$y.' and month(s0.issue_date)='.$m.' and s1.supplier_is_id in (select id from sp_supplier where type_code="B") ';
        
        $data = DB::select($sql);
        
        foreach($data as $value){
            return $value->totalprice;
        }
    }
    
     //มูลค่าการเบิก Type C
    public function gettotalissuemoney_C($m, $y)
    {
        $sql = ' select sum((supply*(select st.priceunit from sp_store st where st.supplier_re_id=s1.supplier_is_id order by st.id desc limit 1 ))) as totalprice';
        $sql .= ' from sp_issue s0';
        $sql .= ' left join sp_issue_detail s1 on s1.id_issue=s0.id';
        $sql .= ' where year(s0.issue_date)='.$y.' and month(s0.issue_date)='.$m.' and s1.supplier_is_id in (select id from sp_supplier where type_code="C") ';
        
        $data = DB::select($sql);
        
        foreach($data as $value){
            return $value->totalprice;
        }
    }
    
    
    
    
    
    //ราคาล่าสุด
    public function getprice($id)
    {
        try
        {
            $d = DB::table('sp_store')        
                ->where('qty', '<>', 0) 
                ->where('supplier_re_id', e($id))      
                ->select('priceunit')
                ->orderby('id', 'asc')
                ->limit(1)
                ->first();

            return $d->priceunit;
        }
        catch(\Exception $e){
            return 0;
        }
    }
    
    
    
    
    //เดือน ปีงบ
	public function get_month()
	{
		$data = array(
			'10' => 'ต.ค.',
			'11' => 'พ.ย.',
			'12' => 'ธ.ค.',
			'01' => 'ม.ค.',
			'02' => 'ก.พ.',
			'03' => 'มี.ค.',
			'04' => 'เม.ย.',
			'05' => 'พ.ค.',
			'06' => 'มิ.ย.',
			'07' => 'ก.ค.',
			'08' => 'ส.ค.',
			'09' => 'ก.ย.'
		);

		return $data;
	}

    
}
