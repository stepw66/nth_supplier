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
use DateTime;

class IssueController extends Controller
{





    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        if( Session::get('level') != '' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ){    
            $dep = DB::table('sp_department')->where('id', Session::get('dep'))->select('dep_name')->first();
          
            if( Session::get('level') == 1 || Session::get('level') == 2 ){
                $data = DB::table('sp_issue_temp')
                    ->join('sp_supplier', 'sp_supplier.id', '=', 'sp_issue_temp.supplier_is_id')
                    ->where('issue_user', e(Session::get('uid')))
                    ->select( 'sp_issue_temp.*', 'sp_supplier.sp_name' )
                    ->get();
            }
            else{
                $data = DB::table('sp_issue_temp')
                    ->join('sp_supplier', 'sp_supplier.id', '=', 'sp_issue_temp.supplier_is_id')
                    ->where('issue_user', e(Session::get('uid')))
                    ->select( 'sp_issue_temp.*', 'sp_supplier.sp_name' )
                    ->get();
            }
            
            $dc = DB::table('sp_around')
                ->where( DB::raw('year(around_date)'), date('Y') )
                ->where( DB::raw('month(around_date)'), date('m') )
                ->where( 'around_date', '>', date('Y-m-d') )
                ->get();
            
            $datenow = date('N');
                                    
            $status = '';
            $around = '';
           
            date_default_timezone_set('Asia/Bangkok');
            
            if( ($datenow == 2) && (date('Hi') > '1030') ){
                $status = 'close';
            }else{
                $status = 'open';              
            }
            
            $r=0;
            foreach( $dc as $k=>$v ){
                
               //return $v->around_date;
                if( count($dc) == 2 && $r==0 ){
                   $around =  $v->around;
                }
                
                if( count($dc) == 1 ){
                    $around =  $v->around;
                }
                
                $r++;
            }


            if( count($data) > 0 ){              
                return View::make( 'issue.index', array('data' => $data, 'dep' => $dep->dep_name, 'status' => $status, 'around24' => $this->around24(), 'around' => $around) );
            }else{               
                return View::make( 'issue.index', array('dep' => $dep->dep_name, 'status' => $status, 'around24' => $this->around24() , 'around' => $around) );
            }                            
        }
        else{
            return Redirect::to('/');
        }
    }
    
    
    
    
    
    /**
    * รอบเบิก
    */
    public function around24()
    {
         $around = array(
             '1'    =>  'รอบที่ 1' ,
             '2'    =>  'รอบที่ 2' ,
             '3'    =>  'รอบที่ 3' ,
             '4'    =>  'รอบที่ 4' ,
             '5'    =>  'รอบที่ 5' ,
             '6'    =>  'รอบที่ 6' ,
             '7'    =>  'รอบที่ 7' ,
             '8'    =>  'รอบที่ 8' ,
             '9'    =>  'รอบที่ 9' ,
             '10'    =>  'รอบที่ 10' ,
             '11'    =>  'รอบที่ 11' ,
             '12'    =>  'รอบที่ 12' ,
             '13'    =>  'รอบที่ 13' ,
             '14'    =>  'รอบที่ 14' ,
             '15'    =>  'รอบที่ 15' ,
             '16'    =>  'รอบที่ 16' ,
             '17'    =>  'รอบที่ 17' ,
             '18'    =>  'รอบที่ 18' ,
             '19'    =>  'รอบที่ 19' ,
             '20'    =>  'รอบที่ 20' ,
             '21'    =>  'รอบที่ 21' ,
             '22'    =>  'รอบที่ 22' ,
             '23'    =>  'รอบที่ 23' ,
             '24'    =>  'รอบที่ 24' 
         );

        return $around;
    }






    /**
     * addissueTemp add a new resource.
     *
     * @return Response
     */
    public function addissueTemp()
    {
        if( Session::get('level') != '' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) )
        {                       
            $data = Request::input();   
            
            $ck = DB::table('sp_issue_temp')->where('supplier_is_id', $data['issue_sp_id'])->where('issue_user', Session::get('uid'))->count();
            
            if( $ck == 0 ){
                DB::transaction(function() use( $data) {
                        DB::table('sp_issue_temp')->insert([
                            'issue_user'        => Session::get('uid'),
                            'supplier_is_id'    => $data['issue_sp_id'],                        
                            'qty'               => $data['issue_qty'],
                            'qty_on_hand'       => $data['qty_on_hand'],
                            'price'             => $data['issue_price'],
                            'comment'           => $data['issue_comment']
                        ]); 
                }); 
            }

            return Session::get('uid');
        }
        else
        {
            return Redirect::to('/');
        }
    }




    /**
     * [listissueTemp description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function listissueTemp($id)
    {
        $data = DB::table('sp_issue_temp')
                ->join('sp_supplier', 'sp_supplier.id', '=', 'sp_issue_temp.supplier_is_id')
                ->where('issue_user', e($id))
                ->select( 'sp_issue_temp.*', 'sp_supplier.sp_name' )
                ->get();

        return view::make( 'issue.listIssueTemp', array('data' => $data) );
    }





     /**
     * [addIssue description]
     */
    public function addIssue()
    {
       if( Session::get('level') != '' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) )
        {                                  
            $date = Request::all();
            $d = explode("-", $date['d']);
            $date_issue = ($d[2]-543).'-'.$d[1].'-'.$d[0];
            $q = $date['q'];

            $p = DB::table('sp_issue_temp')
                     ->where('issue_user', Session::get('uid'))
                     ->select( DB::raw('sum(price) as price') )
                     ->first();

            DB::transaction(function() use( $date_issue, $p, $q ) {
                    DB::table('sp_issue')->insert([
                        'issue_date'        => $date_issue,
                        'issue_user'        => Session::get('uid'),
                        'issue_total_price' => $p->price,
                        'approve_q'         => $q
                    ]); 
            }); 

            $max_id = DB::table('sp_issue')->select( DB::raw('max(id) as max_id') )->first();

            $temp = DB::table('sp_issue_temp')
                     ->where('issue_user', Session::get('uid'))
                     ->get();

            foreach ($temp as $key => $value) 
            {
                DB::transaction(function() use( $max_id, $value ) {
                    DB::table('sp_issue_detail')->insert([
                        'id_issue'          => $max_id->max_id,
                        'supplier_is_id'    => $value->supplier_is_id,
                        'qty'               => $value->qty,
                        'qty_on_hand'       => $value->qty_on_hand,
                        'price'             => $value->price,
                        'comment'           => $value->comment
                    ]); 
                });                
            }        

            $this->clearissueTemp(Session::get('uid'));

            return Redirect::to('issue');
        }
        else
        {
            return Redirect::to('/');
        } 
    }





   /**
     * [listIssue description]
     * @return [type] [description]
     */
    public function listIssue()
    {
        if( Session::get('level') != ''  && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) )
        {                                  
           

            if( Session::get('level') == 1 || Session::get('level') == 2 )
            {
                $data = DB::table('sp_issue')
                    ->leftjoin('sp_user', 'sp_user.id', '=', 'sp_issue.issue_user')
                    ->leftjoin('sp_department', 'sp_department.id', '=', 'sp_user.id_dep')
                    ->select('sp_issue.*', 'sp_user.fullname', 'sp_department.dep_name')
                    ->orderby('issue_date', 'desc')
                    ->orderby('approve_q', 'desc')
                    ->get();
            }
            else
            {
                $data = DB::table('sp_issue')
                    ->leftjoin('sp_user', 'sp_user.id', '=', 'sp_issue.issue_user')
                    ->leftjoin('sp_department', 'sp_department.id', '=', 'sp_user.id_dep')
                    ->where('issue_user', e(Session::get('uid')))
                    ->select('sp_issue.*', 'sp_user.fullname', 'sp_department.dep_name')
                    ->orderby('issue_date', 'desc')
                    ->orderby('approve_q', 'desc')
                    ->get();
            }
            
            return view::make('issue.listissueorder', array('data' => $data));
        }
        else
        {
            return Redirect::to('/');
        }
    }







     /* Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function showIssue($id)
    {
        if( Session::get('level') != '' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) )
        {                                  
            $data = DB::table('sp_issue')                    
                    ->leftjoin('sp_issue_detail', 'sp_issue_detail.id_issue', '=', 'sp_issue.id')
                    ->leftjoin('sp_supplier', 'sp_supplier.id', '=', 'sp_issue_detail.supplier_is_id') 
                    ->leftjoin('sp_unit', 'sp_unit.id', '=', 'sp_supplier.id_unit')  
                    ->leftjoin('sp_type', 'sp_type.type_code', '=', 'sp_supplier.type_code') 
                    ->where('sp_issue.id', e($id))  
                    ->select('sp_issue.issue_user', 'sp_issue.approve_date', 'sp_issue.issue_date', 'sp_issue_detail.*', 'sp_supplier.sp_code', 'sp_supplier.sp_name', 'sp_unit.unit_name', 'sp_type.type_name', DB::raw('(select sum(qty) from sp_store where supplier_re_id=sp_supplier.id) as qtystore ') )
                    ->orderby('sp_supplier.sp_code', 'asc')
                    ->get();
            
            $u = DB::table('sp_issue')
                ->leftjoin('sp_user', 'sp_user.id', '=', 'sp_issue.issue_user')
                ->leftjoin('sp_department', 'sp_department.id', '=', 'sp_user.id_dep')
                ->where('sp_issue.id', e($id)) 
                ->first();
            
            $dep = $u->dep_name;
            $user = $u->fullname;
            
            return view::make('issue.listissueorderdetail', array('data' => $data, 'sp_issue_id' => $id, 'dep' => $dep, 'user' => $user));
        }
        else
        {
            return Redirect::to('/');
        }
    }
    
      
    
    
    
    
    /**
     * [oksupply พิมพ์ใบ จ่ายของเบิก]
     * @return [type] [description]
     */
    public function printissue($id)
    {
        if( Session::get('level') != '' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) )
        {                                  
            $result = DB::table('sp_issue')                    
                    ->leftjoin('sp_issue_detail', 'sp_issue_detail.id_issue', '=', 'sp_issue.id')
                    ->leftjoin('sp_supplier', 'sp_supplier.id', '=', 'sp_issue_detail.supplier_is_id') 
                    ->leftjoin('sp_unit', 'sp_unit.id', '=', 'sp_supplier.id_unit')  
                    ->leftjoin('sp_type', 'sp_type.type_code', '=', 'sp_supplier.type_code') 
                    
                    ->leftjoin('sp_user', 'sp_user.id', '=', 'sp_issue.issue_user') 
                    ->leftjoin('sp_department', 'sp_department.id', '=', 'sp_user.id_dep') 
                
                    ->where('sp_issue.id', e($id))  
                    ->select('sp_issue.issue_user', 'sp_issue.approve_date', 'sp_issue.approve_q', 'sp_issue.issue_date', 'sp_issue_detail.*', 'sp_supplier.sp_code', 'sp_supplier.sp_name', 'sp_unit.unit_name', 'sp_type.type_name', 'sp_department.dep_name', DB::raw('(select sum(qty) from sp_store where supplier_re_id=sp_supplier.id) as qtystore ') )
                    ->orderby('sp_supplier.sp_code', 'asc')
                    ->get();
            
             foreach ($result as $depname) 
             {
                $dep_name = $depname->dep_name;
                $approve_q = $depname->approve_q;
                $approve_date = $depname->approve_date;
                $issue_date = $depname->issue_date;
             }
            
            
            $pdf = new TCPDF();
			$pdf->SetPrintHeader(false);
		    $pdf->SetPrintFooter(false);	

		    $pdf->setHeaderFont(array('freeserif','B',13));
			$pdf->setFooterFont(array('freeserif','B',PDF_FONT_SIZE_DATA));

		    $pdf->SetHeaderData('', '', '' , '');			
			 		   
			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
			 
			// set margins
			$pdf->SetMargins(5, 5, 5,5);

			$pdf->SetFont('freeserif','',12,'',true);

			$pdf->AddPage('P', 'A4');

			$tbl  = ' <style> ';
			$tbl .= '  table.table-report tr td{ border:1px solid #000; height:25px; line-height: 25px; } ';	
			$tbl .= ' .text-bold { font-weight: bold; } ';	
            $tbl .= ' table.table-cent tr td{ height:30px; line-height: 30px; } ';	
			$tbl .= ' </style> ';

            
            $tbl  .= '<h2 align="center">โรงพยาบาลโนนไทย จังหวัดนครราชสีมา</h2> <br /><h2 align="center">ใบเบิกพัสดุ</h2>  <h4>  รอบที่: '.$approve_q.'  วันที่: '. date("d-m", strtotime($issue_date)).'-'.(date("Y", strtotime($issue_date))+543).'  หน่วยงานที่เบิก: '.$dep_name.'</h4>';
            
			$tbl .= '<br /><br /> <table class="table-report"> ';	
            
            $tbl .= '<tr> <td width="30" align="center">ลำดับ</td> <td width="220" align="center">รายการ</td> <td width="50" align="center" >เบิก</td> <td width="50" align="center">เหลือ</td> <td width="70" align="center">มูลค่า</td> <td width="150" align="center">หมายเหตุ</td> </tr>';
			 
			$r=0;
		    foreach ($result as $key) 		    
		    {	
		       $r++;
		      
		    	$tbl .= ' <tr>';

			    $tbl .= ' <td width="30" align="center">';
			    $tbl .= $r;
			    $tbl .= ' </td>';
			    
                $tbl .= ' <td width="220" align="left"> ';
			    $tbl .= $key->sp_name;
			    $tbl .= ' </td>';
                
                $tbl .= ' <td width="50" align="center">';
			    $tbl .= $key->qty;
			    $tbl .= ' </td>';
                
                $tbl .= ' <td width="50" align="center">';
			    $tbl .= (($key->qty_on_hand != '')?$key->qty_on_hand:'0');
			    $tbl .= ' </td>';
                
                $tbl .= ' <td width="70" align="center">';
			    $tbl .= (($key->price != '')?$key->price:'0');
			    $tbl .= ' </td>';
                
                $tbl .= ' <td width="150" align="left" >   ';
			    $tbl .= (($key->comment != '')?' '.$key->comment:'');
			    $tbl .= ' </td>';   	      


			    $tbl .= ' </tr>';			    
		   				    	
			}
			
			$tbl .='</table>';
            
            $tbl .='<br /><br /> <table class="table-cent">';
            $tbl .='<tr> <td>ชื่อผู้อนุมัติ..............................................(หัวหน้าบริหาร)</td> <td>ชื่อผู้จ่าย..............................................(เจ้าหน้าที่บริหาร)</td> </tr>';
            $tbl .='<tr> <td>ชื่อผู้เบิก..............................................(หน่วยงานที่เบิก)</td> <td>ชื่อผู้รับ..............................................(หน่วยงานที่เบิก)</td> </tr>';
            $tbl .='</table>';
		   
			$pdf->writeHTML( $tbl, true, false, false, false, '' );

		    $filename = storage_path() . '/report/report_issue.pdf';
		    $contents = $pdf->output($filename, 'F');
			 
            return 'report_issue.pdf';
            
        }
        else
        {
            return Redirect::to('/');
        }
    }
    
    
    
    
    public function loadfileprint($id)
    {
        $filename = storage_path() . '/report/'.$id;
        $file = File::get($filename);
        $response = Response::make($file, 200);
        $content_types = [
            'application/octet-stream', // txt etc
            'application/msword', // doc
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document', //docx
            'application/vnd.ms-excel', // xls
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // xlsx
            'application/pdf', // pdf
        ];
        // using this will allow you to do some checks on it (if pdf/docx/doc/xls/xlsx)
        $response->header('Content-Type', $content_types);

        return $response;
    }






    /**
     * [oksupply จ่ายของเบิก]
     * @return [type] [description]
     */
    public function oksupply()
    {       
        if( Session::get('level') != '' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) )
        {                                  
            $issueuser  = $_POST['issueuser'];
            $issueid    = $_POST['issueid'];
            $spid       = $_POST['spid'];
            $issuenum   = $_POST['issuenum'];          

            try
            {
                $spall = DB::table('sp_store')
                        ->where('qty', '<>', 0) 
                        ->where('supplier_re_id', e($spid))
                        ->select(DB::raw('sum(qty) as spall '))
                        ->groupby('supplier_re_id')
                        ->first();
                              
                
                if( $spall->spall >= $issuenum ){
                    
                    //--ดึงรายการมาตัด
                    $sp = $this->getspcutstock($spid);

                    //--ถ้าจำนวนที่เบิกมา น้อย กว่าที่มีใน stock ตัวแรก ตัดได้เลย
                    if( $issuenum <= $sp->qty ){   
                        $storeid = $sp->id;
                        $newqty =  $sp->qty - $issuenum;   
                        $newpricetotal = $sp->priceunit * $newqty;            
                        
                        $this->cutstock_spstroe($storeid, $newqty, $newpricetotal);
                        
                        $this->cutstock_sp_issue_detail($issueid, $issuenum, $spid);

                    }
                    
                     //--ถ้าจำนวนที่เบิกมา มาก กว่าที่มีใน stock ตัวแรก
                    if( $issuenum > $sp->qty ){
                        
                         $this->cutstock_spstroe($sp->id, 0, 0);
                         $sp2 = $this->getspcutstock($spid);
                        
                         //ตัวที่ 2
                         $remain = $issuenum - $sp->qty;
                         if( $remain <= $sp2->qty ){ 
                            $this->cutstock_spstroe($sp2->id, ($sp2->qty - $remain), ($sp2->priceunit * ($sp2->qty - $remain)));
                            $this->cutstock_sp_issue_detail($issueid, $issuenum, $spid); 
                         }
                        
                         if( $remain > $sp2->qty ){ 
                              $this->cutstock_spstroe($sp2->id, 0, 0);  
                              $sp3 = $this->getspcutstock($spid);
                             
                              //ตัวที่ 3
                              $remain2 = $remain - $sp3->qty;
                              if( $remain2 <= $sp3->qty ){ 
                                $this->cutstock_spstroe($sp3->id, ($sp3->qty - $remain2), ($sp3->priceunit * ($sp3->qty - $remain2)));
                              }
                         }
                         
                    }
                    
                    
                }//--เช็คจำนวนทั้งหมดก่อน
                
                

                return 'ok';

            }
            catch(\Exception $e){
                return 'no';
            }    
        }
        else
        {
            return Redirect::to('/');
        }
    }
    
    
    
    
    
    /**
     * [oksupply จ่ายของเบิก]
     * เป็นรายการ
     */
    public function sp_issue_bg($id_issue, $spid, $supply)
    {
        $issueid    = $id_issue;
        $spid       = $spid;
        $issuenum   = $supply; 
        
        try
            {
                $spall = DB::table('sp_store')
                        ->where('qty', '<>', 0) 
                        ->where('supplier_re_id', e($spid))
                        ->select(DB::raw('sum(qty) as spall '))
                        ->groupby('supplier_re_id')
                        ->first();
                              
                
                if( $spall->spall >= $issuenum ){
                    
                    //--ดึงรายการมาตัด
                    $sp = $this->getspcutstock($spid);

                    //--ถ้าจำนวนที่เบิกมา น้อย กว่าที่มีใน stock ตัวแรก ตัดได้เลย
                    if( $issuenum <= $sp->qty ){   
                        $storeid = $sp->id;
                        $newqty =  $sp->qty - $issuenum;   
                        $newpricetotal = $sp->priceunit * $newqty;            
                        
                        $this->cutstock_spstroe($storeid, $newqty, $newpricetotal);
                        
                        $this->cutstock_sp_issue_detail($issueid, $issuenum, $spid);

                    }
                    
                     //--ถ้าจำนวนที่เบิกมา มาก กว่าที่มีใน stock ตัวแรก
                    if( $issuenum > $sp->qty ){
                        
                         $this->cutstock_spstroe($sp->id, 0, 0);
                         $sp2 = $this->getspcutstock($spid);
                        
                         //ตัวที่ 2
                         $remain = $issuenum - $sp->qty;
                         if( $remain <= $sp2->qty ){ 
                            $this->cutstock_spstroe($sp2->id, ($sp2->qty - $remain), ($sp2->priceunit * ($sp2->qty - $remain)));
                            $this->cutstock_sp_issue_detail($issueid, $issuenum, $spid); 
                         }
                        
                         if( $remain > $sp2->qty ){ 
                              $this->cutstock_spstroe($sp2->id, 0, 0);  
                              $sp3 = $this->getspcutstock($spid);
                             
                              //ตัวที่ 3
                              $remain2 = $remain - $sp3->qty;
                              if( $remain2 <= $sp3->qty ){ 
                                $this->cutstock_spstroe($sp3->id, ($sp3->qty - $remain2), ($sp3->priceunit * ($sp3->qty - $remain2)));
                              }
                         }
                         
                    }
                    
                    
                }//--เช็คจำนวนทั้งหมดก่อน
                
                
                return 'ok';

            }
            catch(\Exception $e){
                return 'no';
            } 
    }
    
    
    
    
    
    /**
    * ดึงรายการมาตัด first in first out
    */
    public function getspcutstock($id)
    {
        $sp = DB::table('sp_store')        
            ->where('qty', '<>', 0) 
            ->where('supplier_re_id', e($id))      
            ->select('id', 'qty', 'priceunit')
            ->orderby('receive_date', 'asc')
            ->limit(1)
            ->first();
        
        return $sp;
    }
    
    
    
    
    /**
    * update data in table sp_staor
    */
    public function cutstock_spstroe($storeid, $newqty, $newpricetotal)
    {
        DB::transaction(function() use ($storeid, $newqty, $newpricetotal) {
            DB::table('sp_store')
                ->where('id', $storeid)
                ->update(['qty' => $newqty, 'pricetotal' => $newpricetotal]);
        });
    }
    
    
    
    
    
    /**
    * update data in table sp_issue_detail
    */
    public function cutstock_sp_issue_detail($issueid, $issuenum, $spid)
    {
        DB::transaction(function() use ($issueid, $issuenum, $spid) {
            DB::table('sp_issue_detail')
                ->where('id_issue', $issueid)
                ->where('supplier_is_id', $spid)
                ->update(['supply' => $issuenum]);    
        });
    }
    




    /**
    * update data วันที่ตัดจ่าย
    */
    public function updateapprove()
    {
        if( Session::get('level') != '' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) )
        { 
            $approveid  = $_POST['approvekey'];

            DB::transaction(function() use ($approveid) {
                DB::table('sp_issue')
                    ->where('id', $approveid)
                    ->update(['approve_date' => date('Y-m-d H:i:s'), 'approve_user' => Session::get('uid')]);
            });
        }
        else
        {
            return Redirect::to('/');
        }
    }
    





    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        if( Session::get('level') != '' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) )
        {                                  
            DB::transaction(function() use ($id) {
                DB::table('sp_issue_temp')->where('id', '=', e($id) )->delete();
            });              
            return Redirect::to('issue');     
        }
        else
        {
            return Redirect::to('/');
        }
    }
    
    
    
    
    
    
       
    /**
    *
    * แก้ไข issue deatil
    */
    public function editIssue($id)
    {
         if( Session::get('level') != '' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) )
        {
            $dep = DB::table('sp_department')->where('id', Session::get('dep'))->select('dep_name')->first();
             
            $data = DB::table('sp_issue')
                    ->join('sp_issue_detail', 'sp_issue_detail.id_issue', '=', 'sp_issue.id')
                    ->join('sp_supplier', 'sp_supplier.id', '=', 'sp_issue_detail.supplier_is_id')
                    ->where('sp_issue.id', e($id))
                    ->select( 'sp_issue.*', 'sp_issue_detail.*' , 'sp_supplier.sp_name' )
                    ->get();
             
             $ar = DB::table('sp_issue')->where('id', e($id))->first();
                                   
             return View::make('issue.editissue', array('data' => $data, 'dep' => $dep->dep_name, 'idissueedit' => $id, 'around24' => $this->around24(), 'around' => $ar->approve_q ));
         }
        else
        {
            return Redirect::to('/');
        }
    }
    
    
    
    
    
    public function getissuelistedit($id, $spid)
    {
        $dep = DB::table('sp_department')->where('id', Session::get('dep'))->select('dep_name')->first();
        $data = DB::table('sp_issue_detail')->where('id_issue', $id)->where('supplier_is_id', $spid)->first();
        $spissue = DB::table('sp_issue')->where('id', e($id))->first();
        $spname = DB::table('sp_supplier')->where('id', $spid)->first();
        
         return View::make('issue.editform', array('data' => $data, 'dep' => $dep->dep_name, 'idissueedit' => $id, 'around24' => $this->around24(), 'spname' => $spname->sp_name ));
    }
    
    
    
    
    
    /**
    *
    * เพิ่มลงใน issue deatil โดยตรง
    */
    public function addEditIssue()
    {
        if( Session::get('level') != '' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) )
        {                                  
            $data = Request::all();       
           
            DB::transaction(function() use( $data ) {
                DB::table('sp_issue_detail')->insert([
                    'id_issue'          => $data['idissueedit'],
                    'supplier_is_id'    => $data['issue_sp_id'],
                    'qty'               => $data['issue_qty'],
                    'qty_on_hand'       => $data['qty_on_hand'],
                    'price'             => $data['issue_price'],
                    'comment'           => $data['issue_comment']
                ]); 
            });                                       

            return Redirect::to('issue');
        }
        else
        {
            return Redirect::to('/');
        } 
    }
    
    
    
    
     /**
    *
    * แ้ไขรายการเบิก
    */
    public function editIssueList()
    {
       $data = Request::all();  
        
       DB::transaction(function() use( $data ) {
               DB::table('sp_issue_detail')
                ->where('id_issue', $data['idissueedit'])
                ->where('supplier_is_id', $data['issue_sp_id'])
                ->update([
                    'supplier_is_id'    => $data['issue_sp_id'],
                    'qty'               => $data['issue_qty'],
                    'qty_on_hand'       => $data['qty_on_hand'],
                    'price'             => $data['issue_price'],
                    'comment'           => $data['issue_comment']
                ]);
        });  
        
       return Redirect::to('editIssue/detail/'.$data['idissueedit']); 
    }
    
    
    
    
    
     /**
    *
    * คืนของเข้า store
    */
    public function sp_restore($id_issue ,$spid, $supply)
    {
       $old = DB::table('sp_store')
           ->where('supplier_re_id', $spid)
           ->where('qty', '<>', 0)
           ->orderby('id', 'asc')
           ->limit(1)
           ->first();
        
        $id = $old->id;
        $newqty = ($old->qty)+($supply);
        $newprice = ($newqty)*($old->priceunit);
        
        //set store คืนค่าเข้าไป
        DB::transaction(function() use( $id, $newqty, $newprice ) {
               DB::table('sp_store')
                ->where('id', $id)
                ->update([
                    'qty'           => $newqty,
                    'pricetotal'    => $newprice
                ]);
        });  
        
        //set update supply เป็น null
        DB::transaction(function() use( $id_issue ,$spid ) {
               DB::table('sp_issue_detail')
                ->where('id_issue', $id_issue)
                ->where('supplier_is_id', $spid)
                ->update([
                    'supply' => null
                ]);
        });  
    }
    
    
    
    
    
    
    /**
    *
    *ลบ issue detail 
    */
    public function deleteIssueDetail($id, $spid)
    {
        if( Session::get('level') != '' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) )
        {                                  
            DB::transaction(function() use ($id, $spid) {
                DB::table('sp_issue_detail')->where('id_issue', '=', e($id) )->where('supplier_is_id', e($spid))->delete();
            });              
            return Redirect::to('listIssue');     
        }
        else
        {
            return Redirect::to('/');
        } 
    }






    /**
     * [clearissueTemp description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function clearissueTemp($id)
    {
        if( Session::get('level') != '' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) )
        {                                  
            DB::transaction(function() use ($id) {
                DB::table('sp_issue_temp')->where('issue_user', '=', e($id) )->delete();
            });              
            return Redirect::to('issue');     
        }
        else
        {
            return Redirect::to('/');
        }
    }






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





}
