<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Input;
use Request;
use Session;
use View;
use Redirect;
use DB;

class StoreController extends Controller
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
            $data = DB::table('sp_store')                
                ->leftjoin('sp_supplier', 'sp_supplier.id', '=', 'sp_store.supplier_re_id') 
                ->leftjoin('sp_unit', 'sp_unit.id', '=', 'sp_supplier.id_unit')  
                ->leftjoin('sp_type', 'sp_type.type_code', '=', 'sp_supplier.type_code')              
                ->select( 'sp_store.*', 'sp_supplier.sp_code', 'sp_supplier.sp_name', 'sp_unit.unit_name', 'sp_type.type_name' )
                ->orderby('sp_supplier.sp_code', 'asc')
                ->orderby('sp_store.receive_date', 'asc')
                ->get();
            
            return View::make( 'storecenter.index', array('data' => $data) );
        }
        else
        {
            return Redirect::to('/');
        }
    }







    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }






    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
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
        if( Session::get('level') == '1' || Session::get('level') == '2' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) )
        {    
           
            $data = DB::table('sp_store')
                    ->join('sp_supplier', 'sp_supplier.id', '=', 'sp_store.supplier_re_id')
                    ->where('sp_store.id', e($id))
                    ->select('sp_store.*', 'sp_supplier.sp_name')
                    ->first();
            return View::make( 'storecenter.edit', array('data' => $data) );
        }
        else
        {
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
    public function update($id)
    {
        if( Session::get('level') == '1' || Session::get('level') == '2' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) )
        {    
            $data = Input::All();            

            DB::transaction(function() use ($data, $id) {
                 DB::table('sp_store')
                           ->where('id', e($id))
                           ->update([
                            'barcode'           => $data['barcode'],
                            'priceunit'         => $data['priceunit'],
                            'qty'               => $data['qty'],
                            'pricetotal'        => $data['pricetotal']
                        ]);  
            }); 

            Session::flash( 'savedata', save_data );

            return Redirect::to('store');
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
        //
    }
}
