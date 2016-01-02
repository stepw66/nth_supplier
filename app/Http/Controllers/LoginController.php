<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Input;
use Request;
use Session;
use View;
use Redirect;
use Validator;
use Hash;
use DB;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {    
        return view::make('login.index');
    }





    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $data = Input::all();    
        $username = $data['username'];
        $password = $data['password'];
        
        $rules = array(
        'username' => 'required',
        'password' => 'required',
         );

        //เช็คค่าว่าง
        $validator = Validator::make($data, $rules);
        if ($validator->fails())
        {   
            Session::flash('error', error_login);   
            return Redirect::to('login');                    
        }
        else
        {
            $model = User::where( 'username', '=', e( $username) )->where('activated', '=', '1')->first(); 
                        
            if( !empty($model) )
            {
                if ( Hash::check( $password, $model->password) )
                {
                    Session::regenerate();
                    Session::put( 'username', $model->username );
                    Session::put( 'fullname', $model->fullname );
                    Session::put( 'uid', $model->id );
                    Session::put( 'level', $model->level );
                    Session::put( 'dep', $model->id_dep );
                    Session::put( 'fingerprint', md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) );                  

                    return Redirect::intended('/');        
                }
                else
                {
                    Session::flash('error', error_login);  
                    return Redirect::to('login');   
                }
            }
            else
            {
                Session::flash('error', error_login);   
                return Redirect::to('login');   
            }
        }
    }





     /**
     * logout system
     */
    public function logout()
    {     
        Session::flush(); //delete the session
        return Redirect::to( '/' ); // redirect the user to the login screen
    }
    

    

    
}
