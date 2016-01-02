<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dep;
use Input;
use Request;
use Session;
use View;
use Redirect;
use Validator;
use DB;

class DepController extends Controller
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
            $data = Dep::all();                            
            return View::make( 'department.index', array( 'data' => $data ) );
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
        if( Session::get('level') == '1' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) )
        {    
            return View::make( 'department.create' );
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
        if( Session::get('level') == '1' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) )
        {    
            $postData = Input::All();

            $messages = [
                'dep_name.required'      => 'กรุณากรอก',                 
            ];

             $rules = [
                'dep_name'     => 'required', 
             ];

            $validator = Validator::make($postData, $rules, $messages);
            if ($validator->fails()) {               
                return Redirect::route('department.create')->withInput()->withErrors($validator);
            }
            else
            {
                $data = Request::all(); 

                $dep = new Dep();
                $dep->dep_name = $data['dep_name'];

                DB::transaction(function() use ($dep) {
                    $dep->save();  
                }); 

                Session::flash( 'savedata', save_data );

                return Redirect::to('department');
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
        if( Session::get('level') == '1' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) )
        {    
            $data = Dep::find( e($id) );
            return View::make( 'department.edit', array('data' => $data) );
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
        if( Session::get('level') == '1' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) )
        {    
            $postData = Input::All();

            $messages = [
                'dep_name.required'      => 'กรุณากรอก',                 
            ];

             $rules = [
                'dep_name'     => 'required', 
             ];

            $validator = Validator::make($postData, $rules, $messages);
            if ($validator->fails()) {               
                return Redirect::route('department.edit', e($id))->withInput()->withErrors($validator);
            }
            else
            {
                $data = Request::all(); 

                $dep = Dep::find( e($id) );
                $dep->dep_name = $data['dep_name'];

                DB::transaction(function() use ($dep) {
                    $dep->save();  
                }); 

                Session::flash( 'savedata', save_data );

                return Redirect::to('department');
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
        if( Session::get('level') == '1' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) )
        {    
            $Dep = Dep::find( e($id) );  

            DB::transaction(function() use ($Dep) {
                Dep::find( $Dep->id )->delete(); 
            });

            return Redirect::to('department');           
        }
        else
        {
            return Redirect::to('/');
        }
    }
}
