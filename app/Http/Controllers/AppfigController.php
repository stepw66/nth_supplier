<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appfig;
use Input;
use Request;
use Session;
use View;
use Redirect;
use Validator;
use DB;


class AppfigController extends Controller
{






    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        if( Session::get('level') == '1' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) )
        {    
            $count = Appfig::where('address', '<>', '')->count();
           
            if( $count == 0 ){
                return View::make( 'appfig.index' );
            }else{
                $data = Appfig::first();               
                return View::make( 'appfig.edit', array('data' => $data) );
            }                         
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
     * @return Response
     */
    public function store()
    {
        if( Session::get('level') == '1' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) )
        {    
            $postData = Input::All();

            $messages = [
                'address.required'      => 'กรุณากรอก',                 
            ];

             $rules = [
                'address'     => 'required', 
             ];

            $validator = Validator::make($postData, $rules, $messages);
            if ($validator->fails()) {               
                return Redirect::route('appfig.index')->withInput()->withErrors($validator);
            }
            else
            {
                $data = Request::all(); 

                $Appfig = new Appfig();
                $Appfig->address = $data['address'];

                DB::transaction(function() use ($Appfig) {
                    $Appfig->save();  
                }); 

                Session::flash( 'savedata', save_data );

                return Redirect::to('appfig');
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
        //
    }






    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        if( Session::get('level') == '1' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) )
        {    
            $postData = Input::All();

            $messages = [
                'address.required'      => 'กรุณากรอก',                 
            ];

             $rules = [
                'address'     => 'required', 
             ];

            $validator = Validator::make($postData, $rules, $messages);
            if ($validator->fails()) {               
                return Redirect::route('appfig.index')->withInput()->withErrors($validator);
            }
            else
            {
                $data = Request::all(); 

                $Appfig = Appfig::find( e($id) );
                $Appfig->address = $data['address'];

                DB::transaction(function() use ($Appfig) {
                    $Appfig->save();  
                }); 

                Session::flash( 'savedata', save_data );

                return Redirect::to('appfig');
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
        //
    }
}
