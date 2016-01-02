<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Models\Type;
use App\Models\Unit;
use Input;
use Request;
use Session;
use View;
use Redirect;
use Validator;
use DB;

class SupplierController extends Controller
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
            $data = DB::table('sp_supplier')
                    ->leftjoin('sp_type', 'sp_type.type_code', '=', 'sp_supplier.type_code')
                    ->leftjoin('sp_unit', 'sp_unit.id', '=', 'sp_supplier.id_unit')
                    ->select('sp_supplier.id', 'sp_supplier.sp_code', 'sp_supplier.sp_name', 'sp_supplier.id_unit', 'sp_supplier.type_code', 'sp_type.type_name', 'sp_unit.unit_name')
                    ->orderby('sp_supplier.sp_code', 'asc')
                    ->get();

            return View::make( 'supplier.index', array( 'data' => $data ) );
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
        if( Session::get('level') == '1' || Session::get('level') == '2' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) )
        {    
            $data = Supplier::all();

            $type = DB::table( 'sp_type' )->select( DB::raw('type_code, type_name') )->get();
            $type_name=[];
            foreach ($type as $key => $value) {                    
               $type_name[$value->type_code] = $value->type_name;
            }

            $unit = DB::table( 'sp_unit' )->select( DB::raw('id, unit_name') )->get();
            $unit_name=[];
            foreach ($unit as $key => $value) {                    
               $unit_name[$value->id] = $value->unit_name;
            }

            return View::make( 'supplier.create', array( 'data' => $data, 'type' => $type_name, 'unit' => $unit_name ) );
        }
        else
        {
            return Redirect::to('/');
        }
    }






    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        if( Session::get('level') == '1' || Session::get('level') == '2' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) )
        {    
            $postData = Input::All();

            $messages = [
                'sp_code.required'      => 'กรุณากรอก', 
                'sp_name.required'      => 'กรุณากรอก', 
                'id_unit.required'      => 'กรุณากรอก',
                'type_code.required'    => 'กรุณากรอก'                 
            ];

             $rules = [
                'sp_code'     => 'required', 
                'sp_name'     => 'required',
                'id_unit'     => 'required',
                'type_code'   => 'required'
             ];

            $validator = Validator::make($postData, $rules, $messages);
            if ($validator->fails()) {               
                return Redirect::route('supplier.create')->withInput()->withErrors($validator);
            }
            else
            {
                $data = Request::all(); 

                $Supplier = new Supplier();
                $Supplier->sp_code     = $data['sp_code'];
                $Supplier->sp_name     = $data['sp_name'];
                $Supplier->id_unit     = $data['id_unit'];
                $Supplier->type_code   = $data['type_code'];

                DB::transaction(function() use ($Supplier) {
                    $Supplier->save();  
                }); 

                Session::flash( 'savedata', save_data );

                return Redirect::to('supplier');
            }
        }
        else
        {
            return Redirect::to('/');
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
        if( Session::get('level') == '1' || Session::get('level') == '2' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) )
        {    
            $data = Supplier::find( e($id) );

            $type = DB::table( 'sp_type' )->select( DB::raw('type_code, type_name') )->get();
            $type_name=[];
            foreach ($type as $key => $value) {                    
               $type_name[$value->type_code] = $value->type_name;
            }

            $unit = DB::table( 'sp_unit' )->select( DB::raw('id, unit_name') )->get();
            $unit_name=[];
            foreach ($unit as $key => $value) {                    
               $unit_name[$value->id] = $value->unit_name;
            }

            return View::make( 'supplier.edit', array( 'data' => $data, 'type' => $type_name, 'unit' => $unit_name ) );
        }
        else
        {
            return Redirect::to('/');
        }
    }






    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        if( Session::get('level') == '1' || Session::get('level') == '2' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) )
        {    
            $postData = Input::All();

            $messages = [
                'sp_code.required'      => 'กรุณากรอก', 
                'sp_name.required'      => 'กรุณากรอก', 
                'id_unit.required'      => 'กรุณากรอก',
                'type_code.required'    => 'กรุณากรอก'                 
            ];

             $rules = [
                'sp_code'     => 'required', 
                'sp_name'     => 'required',
                'id_unit'     => 'required',
                'type_code'   => 'required'
             ];

            $validator = Validator::make($postData, $rules, $messages);
            if ($validator->fails()) {               
                return Redirect::route('supplier.edit', e($id))->withInput()->withErrors($validator);
            }
            else
            {
                $data = Request::all(); 

                $Supplier = Supplier::find( e($id) );
                $Supplier->sp_code     = $data['sp_code'];
                $Supplier->sp_name     = $data['sp_name'];
                $Supplier->id_unit     = $data['id_unit'];
                $Supplier->type_code   = $data['type_code'];

                DB::transaction(function() use ($Supplier) {
                    $Supplier->save();  
                }); 

                Session::flash( 'savedata', save_data );

                return Redirect::to('supplier');
            }
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
        if( Session::get('level') == '1' || Session::get('level') == '2' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) )
        {                                        
            $Supplier = Supplier::find( e($id) );  

            DB::transaction(function() use ($Supplier) {
                Supplier::find( $Supplier->id )->delete(); 
            });              
            return Redirect::to('supplier');                  
        }
        else
        {
            return Redirect::to('/');
        }
    }





    public function getcode($code)
    {
        if( Session::get('level') == '1' || Session::get('level') == '2' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) )
        {   
            $c = DB::table('sp_supplier')
                ->where('type_code', '=', $code)
                ->select( DB::raw('max(sp_code) as sp_code') )
                ->first();

            $code_num='';

            //== รูปแบบ code ตัวอักษรนำหน้า 1 ตัว ตามด้วยตัวเลข 3 ตัว   
            if( $c->sp_code == null ){
                $code = $code.'001';
            }
            else{               
                $s = substr($c->sp_code, 1);              
                $code_num = sprintf("%03d",$s+1);
            }
      
            return array( 'code' => $code.$code_num );
        }
        else
        {
            return Redirect::to('/');
        }
    }


}
