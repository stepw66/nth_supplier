<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\KbCard;
use App\Models\Supplier;
use Input;
use Request;
use Session;
use View;
use Redirect;
use DB;
use TCPDF;
use TCPDFBarcode;
use Response;
use File;

class KbCardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        if( Session::get('level') != '' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ){ 
             
             return View::make('kbcard.index');
        }
        else{
            return Redirect::to('/');
        }
       
    }





    public function listkbcard()
    {
        if( Session::get('level') != '' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ){ 
             
            $data = DB::table('sp_kumbuk_card')
                ->leftjoin('sp_department', 'sp_department.id', '=', 'sp_kumbuk_card.id_dep')
                ->join('sp_supplier', 'sp_supplier.id', '=', 'sp_kumbuk_card.supplier_id')
                ->select( 'sp_kumbuk_card.*', 'sp_supplier.sp_name', 'sp_supplier.sp_code', 'sp_department.dep_name' )
                ->orderby('sp_kumbuk_card.id_dep', 'desc')
                ->get();

            return view::make( 'kbcard.listkbcard', array('data' => $data) );
        }
        else{
            return Redirect::to('/');
        }
    }
    
    
    
    
    
    public function getspcode($id)
    {
         try{
            $d = DB::table('sp_supplier')        
                ->where('id', e($id))      
                ->select('sp_code')
                ->first();

            return $d->sp_code;
        }catch(\Exception $e){
            return 0;
        }
    }
    
    
    
    
    
     public function getspdep()
    {
         try{
             $data = DB::table('sp_department')
                        ->select( 'id', db::raw('dep_name as name') )
                        ->get();

             return $data;
        }catch(\Exception $e){
            return 0;
        }
    }


    
    
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store()
    {
       if( Session::get('level') != '' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ){                       
            $data = Request::input();    

            DB::transaction(function() use( $data) {
                    DB::table('sp_kumbuk_card')->insert([
                        'id_dep'        => $data['kc_sp_dep'],
                        'max_unit'      => $data['max_unit'],                        
                        'min_unit'      => $data['min_unit'],
                        'supplier_id'   => $data['supplier_id'],
                        'supplier_code' => $data['supplier_code'],
                        'created_date'  => date('Y-m-d H:i:s')
                    ]); 
            }); 
           
            $data_sp = Supplier::find($data['supplier_id']);
           
           //----------- create card --------------//
            $pagelayout = array(75, 188); //  or array($height, $width) 

            $pdf = new TCPDF('p', 'mm', $pagelayout, true, 'UTF-8', false);
			$pdf->SetPrintHeader(false);
		    $pdf->SetPrintFooter(false);	

		    $pdf->SetHeaderData('', '', '', '');			
			 		   
			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
			 
			// set margins
			$pdf->SetMargins(1, 1, 1);
            $pdf->SetDisplayMode('fullpage', 'SinglePage', 'UseNone');
			
			$pdf->AddPage('P');
           
            $pdf->SetFont('freeserif','B',12,'',true);
            $pdf->SetXY(1, 1);
            $pdf->MultiCell(75, 0, 'แผนก : '.$this->getsp_dep($data['kc_sp_dep']), 0, 'L', 0, 1, '', '', true);
           
           
            $pdf->SetFont('freeserif','',12,'',true);
            $pdf->SetXY(1, 12);
            $pdf->MultiCell(195, 0, 'เลขที่ : '.$data['supplier_code'], 0, 'L', 0, 1, '', '', true); 

            $pdf->SetFont('freeserif','B',13,'',true);
            $pdf->SetXY(1, 16);
            $pdf->MultiCell(75, 0, 'รายการ : '.$this->getsp_name($data['supplier_id']), 0, 'L', 0, 1, '', '', true); 
           
            $pdf->SetFont('freeserif','',12,'',true);       
            $pdf->SetXY(1, 26);
            $pdf->MultiCell(75, 0, 'จำนวนมากสุด : '.$data['max_unit']. ' จำนวนน้อยสุด : '.$data['min_unit'], 0, 'L', 0, 1, '', '', true); 

            $pdf->SetFont('freeserif','B',14,'',true);
            $pdf->SetXY(1, 31);
            $pdf->MultiCell(75, 0, 'จำนวนที่เบิก : '.($data['max_unit']-$data['min_unit']), 0, 'L', 0, 1, '', '', true);
           
           
           $style = array(
                'border' => 2,
                'vpadding' => 'auto',
                'hpadding' => 'auto',
                'fgcolor' => array(0,0,0),
                'bgcolor' => false, //array(255,255,255)
                'module_width' => 1, // width of a single module in points
                'module_height' => 1 // height of a single module in points
            );

            $pdf->SetFont('freeserif','',11,'',true);
            $pdf->SetXY(1, 50);          
            $pdf->write2DBarcode($data['id_dep'].'|'.$data['max_unit'].'|'.$data['min_unit'].'|'.$data['supplier_id'].'|'.$data['supplier_code'].'|'.$data_sp['sp_name'], 'QRCODE,Q', 18, 56, 38, 32, $style, 'N');
           
           
            $filename = storage_path() . '/report/kumbukcard.pdf';
		    $contents = $pdf->output($filename, 'D');
           
           
           //return Redirect::to('kbcard');
        }else{
            return Redirect::to('/');
        }
    }





    /**
    * print kb card
    */
    public function kbcardprint($id)
    {
        if( Session::get('level') != '' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ){ 
             $data = KbCard::find($id);
             $data_sp = Supplier::find($data->supplier_id);

             //----------- create card --------------//
            $pagelayout = array(75, 188); //  or array($height, $width) 

            $pdf = new TCPDF('p', 'mm', $pagelayout, true, 'UTF-8', false);
            //$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->SetPrintHeader(false);
            $pdf->SetPrintFooter(false);    

            $pdf->SetHeaderData('', '', '', '');            
                       
            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
             
            // set margins
            $pdf->SetMargins(1, 1, 1);
            $pdf->SetDisplayMode('fullpage', 'SinglePage', 'UseNone');
            
            $pdf->AddPage('P');       
           
            $pdf->SetFont('freeserif','B',12,'',true);
            $pdf->SetXY(1, 1);
            $pdf->MultiCell(75, 0, 'แผนก : '.$this->getsp_dep($data->id_dep), 0, 'L', 0, 1, '', '', true);
           
           
            $pdf->SetFont('freeserif','',12,'',true);
            $pdf->SetXY(1, 12);
            $pdf->MultiCell(75, 0, 'เลขที่ : '.$data['supplier_code'], 0, 'L', 0, 1, '', '', true); 
            
            $pdf->SetFont('freeserif','B',13,'',true);
            $pdf->SetXY(1, 16);
            $pdf->MultiCell(75, 0, 'รายการ : '.$this->getsp_name($data->supplier_id), 0, 'L', 0, 1, '', '', true); 

            $pdf->SetFont('freeserif','',12,'',true);       
            $pdf->SetXY(1, 26);
            $pdf->MultiCell(75, 0, 'จำนวนมากสุด : '.$data->max_unit. ' จำนวนน้อยสุด : '.$data->min_unit, 0, 'L', 0, 1, '', '', true); 

            $pdf->SetFont('freeserif','B',14,'',true);
            $pdf->SetXY(1, 31);
            $pdf->MultiCell(75, 0, 'จำนวนที่เบิก : '.($data->max_unit-$data->min_unit), 0, 'L', 0, 1, '', '', true);
           
           
           $style = array(
                'border' => 2,
                'vpadding' => 'auto',
                'hpadding' => 'auto',
                'fgcolor' => array(0,0,0),
                'bgcolor' => false, //array(255,255,255)
                'module_width' => 1, // width of a single module in points
                'module_height' => 1 // height of a single module in points
            );

            $pdf->SetFont('freeserif','',11,'',true);
            $pdf->SetXY(1, 50);          
            $pdf->write2DBarcode($data->id_dep.'|'.$data->max_unit.'|'.$data->min_unit.'|'.$data->supplier_id.'|'.$data->supplier_code.'|'.$data_sp->sp_name, 'QRCODE,Q', 18, 56, 38, 32, $style, 'N');
        
           
            $filename = storage_path() . '/report/kumbukcard.pdf';
            $contents = $pdf->output($filename, 'D');
            
        }else{
            return Redirect::to('/');
        }
    }




    /**
    * print kb card small
    */
    public function kbcardprint_small($id){
        if( Session::get('level') != '' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ){ 
             $data = KbCard::find($id);
             $data_sp = Supplier::find($data->supplier_id);

             //----------- create card --------------//
            $pagelayout = array(75, 188); //  or array($height, $width) 

            $pdf = new TCPDF('p', 'mm', $pagelayout, true, 'UTF-8', false);
            //$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->SetPrintHeader(false);
            $pdf->SetPrintFooter(false);    

            $pdf->SetHeaderData('', '', '', '');            
                       
            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
             
            // set margins
            $pdf->SetMargins(0, 0, 0);
            $pdf->SetDisplayMode('fullpage', 'SinglePage', 'UseNone');
            
            $pdf->AddPage('P');       

            $pdf->SetFont('freeserif','B',12,'',true);
            $pdf->SetXY(1, 1);
            $pdf->MultiCell(75, 0, 'แผนก : '.$this->getsp_dep($data->id_dep), 0, 'L', 0, 1, '', '', true);
           
           
            $pdf->SetFont('freeserif','',12,'',true);
            $pdf->SetXY(1, 8);
            $pdf->MultiCell(75, 0, 'เลขที่ : '.$data['supplier_code'], 0, 'L', 0, 1, '', '', true); 
            
            $pdf->SetFont('freeserif','B',12,'',true);
            $pdf->SetXY(1, 12);
            $pdf->MultiCell(75, 0, 'รายการ : '.$this->getsp_name($data->supplier_id), 0, 'L', 0, 1, '', '', true); 

            $pdf->SetFont('freeserif','',12,'',true);       
            $pdf->SetXY(1, 22);
            $pdf->MultiCell(75, 0, 'จำนวนมากสุด : '.$data->max_unit. ' จำนวนน้อยสุด : '.$data->min_unit, 0, 'L', 0, 1, '', '', true); 

            $pdf->SetFont('freeserif','B',13,'',true);
            $pdf->SetXY(1, 27);
            $pdf->MultiCell(75, 0, 'จำนวนที่เบิก : '.($data->max_unit-$data->min_unit), 0, 'L', 0, 1, '', '', true);
           
           
           $style = array(
                'border' => 2,
                'vpadding' => 'auto',
                'hpadding' => 'auto',
                'fgcolor' => array(0,0,0),
                'bgcolor' => false, //array(255,255,255)
                'module_width' => 1, // width of a single module in points
                'module_height' => 1 // height of a single module in points
            );

            $pdf->SetFont('freeserif','',11,'',true);
            $pdf->SetXY(1, 25);          
            $pdf->write2DBarcode($data->id_dep.'|'.$data->max_unit.'|'.$data->min_unit.'|'.$data->supplier_id.'|'.$data->supplier_code.'|'.$data_sp->sp_name, 'QRCODE,Q', 1, 35, 38, 32, $style, 'N');
        
           
            $filename = storage_path() . '/report/kumbukcard_small.pdf';
            $contents = $pdf->output($filename, 'D');
            
        }else{
            return Redirect::to('/');
        }
    }

    
    
    
    public function getsp_name($id)
    {
        try{
            $d = DB::table('sp_supplier')        
                ->where('id', e($id))      
                ->select('sp_name')
                ->first();

            return $d->sp_name;
        }catch(\Exception $e){
            return 0;
        }
    }
    
    
    
    
    public function getsp_dep($id)
    {
        try{
            $d = DB::table('sp_department')        
                ->where('id', e($id))      
                ->select('dep_name')
                ->first();

            return $d->dep_name;
        }catch(\Exception $e){
            return 0;
        }
    }

    
    
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    
    
    
    
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        if( Session::get('level') != '' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ){ 
             
            $data = DB::table('sp_kumbuk_card')
                ->leftjoin('sp_department', 'sp_department.id', '=', 'sp_kumbuk_card.id_dep')
                ->join('sp_supplier', 'sp_supplier.id', '=', 'sp_kumbuk_card.supplier_id')
                ->select( 'sp_kumbuk_card.*', 'sp_supplier.sp_name', 'sp_supplier.sp_code', 'sp_department.dep_name' )
                ->where('sp_kumbuk_card.id', $id)
                ->first();

            return view::make( 'kbcard.editkbcard', array('data' => $data) );
        }else{
            return Redirect::to('/');
        }
    }

    
    
    
    
    
    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        if( Session::get('level') == '1' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ){    
            $data = Request::all(); 

            $kb = KbCard::find( e($id) );
            $kb->max_unit     = $data['max_unit'];
            $kb->min_unit   = $data['min_unit'];

            DB::transaction(function() use ($kb) {
                $kb->save();  
            });      

            return Redirect::to('listkbcard');   
        }else{
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
        if( Session::get('level') == '1' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ){    
            $kb = KbCard::find( e($id) );  

            DB::transaction(function() use ($kb) {
                KbCard::find( $kb->id )->delete(); 
            });   

            return Redirect::to('listkbcard');   
        }else{
            return Redirect::to('/');
        }
    }


}
