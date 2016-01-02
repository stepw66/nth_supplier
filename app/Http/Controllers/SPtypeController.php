<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Type;
use Input;
use Request;
use Session;
use View;
use Redirect;
use Validator;
use DB;

class SPtypeController extends Controller
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
            $data = Type::all();
            return View::make( 'type.index', array( 'data' => $data ) );
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
            return View::make( 'type.create' );
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
                'type_code.required'      => 'กรุณากรอก', 
                'type_name.required'      => 'กรุณากรอก', 
            ];

             $rules = [
                'type_code'     => 'required', 
                'type_name'     => 'required',
             ];

            $validator = Validator::make($postData, $rules, $messages);
            if ($validator->fails()) {               
                return Redirect::route('type.create')->withInput()->withErrors($validator);
            }
            else
            {
                $data = Request::all(); 

                $Type = new Type();
                $Type->type_code     = $data['type_code'];
                $Type->type_name     = $data['type_name'];

                DB::transaction(function() use ($Type) {
                    $Type->save();  
                }); 

                Session::flash( 'savedata', save_data );

                return Redirect::to('type');
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
            $data = Type::find( e($id) );
          
            return View::make( 'type.edit', array('data' => $data) );
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
                'type_code.required'      => 'กรุณากรอก', 
                'type_name.required'      => 'กรุณากรอก', 
            ];

             $rules = [
                'type_code'     => 'required', 
                'type_name'     => 'required',
             ];

            $validator = Validator::make($postData, $rules, $messages);
            if ($validator->fails()) {               
                return Redirect::route('type.edit', e($id))->withInput()->withErrors($validator);
            }
            else
            {
                $data = Request::all(); 

                $Type = Type::find( e($id) );
                $Type->type_code     = $data['type_code'];
                $Type->type_name     = $data['type_name'];

                DB::transaction(function() use ($Type) {
                    $Type->save();  
                }); 

                Session::flash( 'savedata', save_data );

                return Redirect::to('type');
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
            $Type = Type::find( e($id) );  

            DB::transaction(function() use ($Type) {
                Type::find( $Type->id )->delete(); 
            });

            return Redirect::to('type');        
        }
        else
        {
            return Redirect::to('/');
        }
    }
}
