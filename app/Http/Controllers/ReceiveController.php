<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Input;
use Request;
use Session;
use View;
use Redirect;
use Validator;
use DB;

class ReceiveController extends Controller
{





    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        if( Session::get('level') == '1' || Session::get('level') == '2' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) )
        {    
            $data = DB::table('sp_receive_temp')
                ->join('sp_supplier', 'sp_supplier.id', '=', 'sp_receive_temp.supplier_re_id')
                ->leftjoin('sp_company', 'sp_receive_temp.company_id', '=', 'sp_company.id')
                ->where('created_by', Session::get('uid'))
                ->select( 'sp_receive_temp.*', 'sp_supplier.sp_name', 'sp_company.company' )
                ->get();
            
            $company = DB::table('sp_company')
                            ->select('id', 'company')
                            ->get();
            
             $company_list=[];
                foreach ($company as $key => $value) {                    
                   $company_list[$value->id] = $value->company;
                }   

            if( count($data) > 0 ){
                return View::make( 'receive.index', array('data' => $data, 'company_list' => $company_list) );
            }else{
                return View::make( 'receive.index', array('company_list' => $company_list) );
            }        
        }
        else
        {
            return Redirect::to('/');
        }
    }





    /**
     * [addSpTemp description]
     */
    public function addSpTemp()
    {
       if( Session::get('level') == '1' || Session::get('level') == '2' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) )
        {                       
            $data = Request::input();    

            DB::transaction(function() use( $data) {
                    if( $data['ckedit'] == '' ){
                        DB::table('sp_receive_temp')->insert([
                            'created_by'        => Session::get('uid'),
                            'supplier_re_id'    => $data['srid'],
                            'supplier_name'     =>  $data['supplier_re_id'],
                            'barcode'           => $data['barcode'],
                            'priceunit'         => $data['priceunit'],
                            'qty'               => $data['qty'],
                            'pricetotal'        => $data['pricetotal'],
                            'comment'           => $data['comment'],
                            'company_id'        =>  $data['company']
                        ]); 
                    }else{
                       DB::table('sp_receive_temp')
                           ->where('id', $data['ckedit'])
                           ->update([
                            'created_by'        => Session::get('uid'),
                            'supplier_re_id'    => $data['srid'],
                            'supplier_name'     =>  $data['supplier_re_id'],
                            'barcode'           => $data['barcode'],
                            'priceunit'         => $data['priceunit'],
                            'qty'               => $data['qty'],
                            'pricetotal'        => $data['pricetotal'],
                            'comment'           => $data['comment'],
                            'company_id'        =>  $data['company']
                        ]);  
                    }
            }); 

            return Session::get('uid');
        }
        else
        {
            return Redirect::to('/');
        }
    }





    /**
     * [destroy description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function destroy($id)
    {
        if( Session::get('level') == '1' || Session::get('level') == '2' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) )
        {                                  
            DB::transaction(function() use ($id) {
                DB::table('sp_receive_temp')->where('id', '=', e($id) )->delete();
            });              
            return Redirect::to('receive');     
        }
        else
        {
            return Redirect::to('/');
        }
    }





    /**
     * [clearTemp description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function clearTemp($id)
    {
        if( Session::get('level') == '1' || Session::get('level') == '2' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) )
        {                                  
            DB::transaction(function() use ($id) {
                DB::table('sp_receive_temp')->where('created_by', '=', e($id) )->delete();
            });              
            return Redirect::to('receive');     
        }
        else
        {
            return Redirect::to('/');
        }
    }
    
    
    
    
    public function gettempedit($id)
    {
        $temp = DB::table('sp_receive_temp')->where('id', $id)->first();
        return response()->json($temp);
    }





    /**
     * [listTemp description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function listTemp($id)
    {
        $data = DB::table('sp_receive_temp')
                ->join('sp_supplier', 'sp_supplier.id', '=', 'sp_receive_temp.supplier_re_id')
                ->leftjoin('sp_company', 'sp_receive_temp.company_id', '=', 'sp_company.id')
                ->where('created_by', e($id))
                ->select( 'sp_receive_temp.*', 'sp_supplier.sp_name', 'sp_company.company' )
                ->get();

        return view::make( 'receive.list', array('data' => $data) );
    }






    /**
     * [addReceive description]
     */
    public function addReceive()
    {
       if( Session::get('level') == '1' || Session::get('level') == '2' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) )
        {                                  
            $date = Request::all();
            $d = explode("-", $date['d']);
            $date_receive = ($d[2]-543).'-'.$d[1].'-'.$d[0];

            $p = DB::table('sp_receive_temp')
                     ->where('created_by', Session::get('uid'))
                     ->select( DB::raw('sum(pricetotal) as price') )
                     ->first();

            DB::transaction(function() use( $date_receive, $p ) {
                    DB::table('sp_receive')->insert([
                        'receive_date'      => $date_receive,
                        'created_by'        => Session::get('uid'),
                        'total_price'       => $p->price
                    ]); 
            }); 

            $max_id = DB::table('sp_receive')->select( DB::raw('max(id) as max_id') )->first();

            $temp = DB::table('sp_receive_temp')
                     ->where('created_by', Session::get('uid'))
                     ->get();

            foreach ($temp as $key => $value) 
            {
                DB::transaction(function() use( $max_id, $value ) {
                    DB::table('sp_receive_detail')->insert([
                        'id_receive'        => $max_id->max_id,
                        'supplier_re_id'    => $value->supplier_re_id,
                        'barcode'           => $value->barcode,
                        'priceunit'         => $value->priceunit,
                        'qty'               => $value->qty,
                        'pricetotal'        => $value->pricetotal,
                        'comment'           => $value->comment,
                        'company_id'        => $value->company_id
                    ]); 
                });  

                DB::transaction(function() use( $date_receive, $value ) {
                    DB::table('sp_store')->insert([
                        'receive_date'      => $date_receive,
                        'supplier_re_id'    => $value->supplier_re_id,
                        'barcode'           => $value->barcode,
                        'priceunit'         => $value->priceunit,
                        'qty'               => $value->qty,
                        'pricetotal'        => $value->pricetotal,
                        'created_by'        => Session::get('uid')
                    ]); 
                });           
            }        

            $this->clearTemp(Session::get('uid'));

            return Redirect::to('receive');
        }
        else
        {
            return Redirect::to('/');
        } 
    }






    /**
     * [listReceive description]
     * @return [type] [description]
     */
    public function listReceive()
    {
        if( Session::get('level') == '1' || Session::get('level') == '2' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) )
        {                                  
            $data = DB::table('sp_receive')
                    ->leftjoin('sp_user', 'sp_user.id', '=', 'sp_receive.created_by')
                    ->select('sp_receive.*', 'sp_user.fullname')
                    ->orderby('receive_date', 'desc')
                    ->get();
            
            return view::make('receive.listorder', array('data' => $data));
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
    public function showReceive($id)
    {
        if( Session::get('level') == '1' || Session::get('level') == '2' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) )
        {                                  
            $data = DB::table('sp_receive')                    
                    ->leftjoin('sp_receive_detail', 'sp_receive_detail.id_receive', '=', 'sp_receive.id')
                    ->leftjoin('sp_supplier', 'sp_supplier.id', '=', 'sp_receive_detail.supplier_re_id') 
                    ->leftjoin('sp_unit', 'sp_unit.id', '=', 'sp_supplier.id_unit')  
                    ->leftjoin('sp_type', 'sp_type.type_code', '=', 'sp_supplier.type_code') 
                    ->where('sp_receive.id', e($id))  
                    ->select('sp_receive.receive_date', 'sp_receive_detail.*', 'sp_supplier.sp_code', 'sp_supplier.sp_name', 'sp_unit.unit_name', 'sp_type.type_name')
                    ->orderby('receive_date', 'desc')
                    ->get();
            
            return view::make('receive.listorderdetail', array('data' => $data));
        }
        else
        {
            return Redirect::to('/');
        }
    }







    /**
     * [getsupplier description]
     * @return [type] [description]
     */
    public function getsupplier()
    {
        $data = DB::table('sp_supplier')
                        ->select( 'id', db::raw('sp_name as name') )
                        ->get();

        return $data;
    }


}
