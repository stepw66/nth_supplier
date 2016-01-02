<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Around;
use Input;
use Request;
use Session;
use View;
use Redirect;
use Validator;
use DB;

class AroundController extends Controller
{
    
    
    
    
    
    
    
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        if( Session::get('level') == '1' || Session::get('level') == '2' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ){    
            $data = DB::table('sp_around')->select('*')->orderby('id', 'asc')->get();
           
            return View::make( 'around.index', array( 'data' => $data ) );
        }
        else{
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
        if( Session::get('level') == '1' || Session::get('level') == '2' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ){    
            return View::make( 'around.create' );
        }
        else{
            return Redirect::to('/');
        }
    }

    
    
    
    
    
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        if( Session::get('level') == '1' || Session::get('level') == '2' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ){    
           $postData = Input::All();

            $messages = [
                'around.required'      => 'กรุณากรอก', 
                'around_date.required' => 'กรุณากรอก'
            ];

             $rules = [
                'around'      => 'required',
                'around_date' => 'required'
             ];

            $validator = Validator::make($postData, $rules, $messages);
            if ($validator->fails()) {               
                return Redirect::route('around.create')->withInput()->withErrors($validator);
            }
            else{
                $data = Request::all(); 
                
                $c = Around::where('around', $data['around'])->first();
                
                if( count($c) > 0 ){
                     return Redirect::route('around.create')->withInput()->withErrors($validator);
                }else{
                    $d = explode("-", $data['around_date']);
                    $date = ($d[2]-543).'-'.$d[1].'-'.$d[0];

                    $Around = new Around();
                    $Around->around          = $data['around'];
                    $Around->around_date     = $date;

                    DB::transaction(function() use ($Around) {
                        $Around->save();  
                    }); 

                    Session::flash( 'savedata', save_data );

                    return Redirect::to('around');
                }
            }
        }
        else{
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
        if( Session::get('level') == '1' || Session::get('level') == '2' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ){    
            $data = Around::find( e($id) );
            return View::make( 'around.edit', array('data' => $data) );
        }
        else{
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
        if( Session::get('level') == '1' || Session::get('level') == '2' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ){    
           $postData = Input::All();

            $messages = [
                'around.required'      => 'กรุณากรอก', 
                'around_date.required' => 'กรุณากรอก'
            ];

             $rules = [
                'around'      => 'required',
                'around_date' => 'required'
             ];

            $validator = Validator::make($postData, $rules, $messages);
            if ($validator->fails()) {               
                return Redirect::route('around.edit', e($id))->withInput()->withErrors($validator);
            }
            else{
                $data = Request::all(); 
                
                $c = Around::where('around', $data['around'])->first();
                
                if( count($c) > 0 ){
                     return Redirect::route('around.create')->withInput()->withErrors($validator);
                }else{
                    $d = explode("-", $data['around_date']);
                    $date = ($d[2]-543).'-'.$d[1].'-'.$d[0];

                    $Around = Around::find( e($id) );
                    $Around->around          = $data['around'];
                    $Around->around_date     = $date;

                    DB::transaction(function() use ($Around) {
                        $Around->save();  
                    }); 

                    Session::flash( 'savedata', save_data );

                    return Redirect::to('around');
                }
            }
        }
        else{
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
       if( Session::get('level') == '1' || Session::get('level') == '2' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ){                   
            $Around = Around::find( e($id) );  

            DB::transaction(function() use ($Around) {
                Around::find( $Around->id )->delete(); 
            });

            return Redirect::to('around');        
        }
        else{
            return Redirect::to('/');
        }
    }
}
