<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Input;
use Request;
use Session;
use View;
use Redirect;
use Validator;
use DB;

class UnitController extends Controller
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
            $data = DB::table('sp_unit')->select('id', 'unit_name')->orderby('unit_name', 'asc')->get();
           
            return View::make( 'unit.index', array( 'data' => $data ) );
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
            return View::make( 'unit.create' );
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
                'unit_name.required'      => 'กรุณากรอก', 
            ];

             $rules = [
                'unit_name'     => 'required', 
             ];

            $validator = Validator::make($postData, $rules, $messages);
            if ($validator->fails()) {               
                return Redirect::route('unit.create')->withInput()->withErrors($validator);
            }
            else
            {
                $data = Request::all(); 

                $Unit = new Unit();
                $Unit->unit_name     = $data['unit_name'];

                DB::transaction(function() use ($Unit) {
                    $Unit->save();  
                }); 

                Session::flash( 'savedata', save_data );

                return Redirect::to('unit');
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
            $data = Unit::find( e($id) );
          
            return View::make( 'unit.edit', array('data' => $data) );
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
                'unit_name.required'      => 'กรุณากรอก', 
            ];

             $rules = [
                'unit_name'     => 'required', 
             ];

            $validator = Validator::make($postData, $rules, $messages);
            if ($validator->fails()) {               
                return Redirect::route('unit.edit', e($id))->withInput()->withErrors($validator);
            }
            else
            {
                $data = Request::all(); 

                $Unit = Unit::find( e($id) );
                $Unit->unit_name     = $data['unit_name'];

                DB::transaction(function() use ($Unit) {
                    $Unit->save();  
                }); 

                Session::flash( 'savedata', save_data );

                return Redirect::to('unit');
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
            $Unit = Unit::find( e($id) );  

            DB::transaction(function() use ($Unit) {
                Unit::find( $Unit->id )->delete(); 
            });

            return Redirect::to('unit');        
        }
        else
        {
            return Redirect::to('/');
        }
    }
}
