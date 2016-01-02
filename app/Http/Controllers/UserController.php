<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Dep;
use Input;
use Request;
use Session;
use View;
use Redirect;
use Validator;
use DB;
use Hash;

class UserController extends Controller
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
            $data = DB::table('sp_user')
                        ->leftjoin('sp_department', 'sp_department.id', '=', 'sp_user.id_dep' )  
                        ->select('sp_user.id', 'sp_user.fullname', 'sp_user.username', 'sp_user.password', 'sp_user.id_dep', 'sp_user.level', 'sp_user.activated', 'sp_department.dep_name')                 
                        ->get();

            return View::make( 'users.index', array( 'data' => $data ) );
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
            $dep = DB::table( 'sp_department' )->select( DB::raw('id, dep_name') )->get();
                $dep_name=[];
                foreach ($dep as $key => $value) {                    
                   $dep_name[$value->id] = $value->dep_name;
                }   

            return View::make( 'users.create', array('dep' => $dep_name) );
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
                'fullname.required'      => 'กรุณากรอก', 
                'username.required'      => 'กรุณากรอก', 
                'password.required'      => 'กรุณากรอก',                 
            ];

             $rules = [
                'fullname'     => 'required', 
                'username'     => 'required',
                'password'     => 'required',
             ];

            $validator = Validator::make($postData, $rules, $messages);
            if ($validator->fails()) {               
                return Redirect::route('user.create')->withInput()->withErrors($validator);
            }
            else
            {
                $data = Request::all(); 

                $user = new User();
                $user->fullname     = $data['fullname'];
                $user->username     = $data['username'];
                $user->password     = Hash::make($data['password']);
                $user->id_dep       = $data['id_dep'];
                $user->level        = $data['level'];
                $user->activated    = $data['activated'];

                DB::transaction(function() use ($user) {
                    $user->save();  
                }); 

                Session::flash( 'savedata', save_data );

                return Redirect::to('user');
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
            $data = User::find( e($id) );

            $dep = DB::table( 'sp_department' )->select( DB::raw('id, dep_name') )->get();
                $dep_name=[];
                foreach ($dep as $key => $value) {                    
                   $dep_name[$value->id] = $value->dep_name;
                }  

            return View::make( 'users.edit', array('data' => $data, 'dep' => $dep_name) );
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
                'fullname.required'      => 'กรุณากรอก', 
                'username.required'      => 'กรุณากรอก', 
                'password.required'      => 'กรุณากรอก',                 
            ];

             $rules = [
                'fullname'     => 'required', 
                'username'     => 'required',
                'password'     => 'required',
             ];

            $validator = Validator::make($postData, $rules, $messages);
            if ($validator->fails()) {               
                return Redirect::route('user.edit', e($id))->withInput()->withErrors($validator);
            }
            else
            {
                $data = Request::all(); 

                $user = User::find( e($id) );
                $user->fullname     = $data['fullname'];
                $user->username     = $data['username'];
                $user->password     = $data['password'];
                $user->id_dep       = $data['id_dep'];
                $user->level        = $data['level'];
                $user->activated    = $data['activated'];

                DB::transaction(function() use ($user) {
                    $user->save();  
                }); 

                Session::flash( 'savedata', save_data );

                return Redirect::to('user');
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
            $user = User::find( e($id) );  

            DB::transaction(function() use ($user) {
                User::find( $user->id )->delete(); 
            });

            return Redirect::to('user');           
        }
        else
        {
            return Redirect::to('/');
        }
    }
}
