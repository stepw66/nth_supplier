<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Input;
use Request;
use Session;
use View;
use Redirect;
use Validator;
use DB;

class CompanyController extends Controller
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
            $data = Company::all();                            
            return View::make( 'company.index', array( 'data' => $data ) );                    
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
            return View::make( 'company.create' );
        }
        else
        {
            return Redirect::to('/');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store()
    {
        if( Session::get('level') == '1' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) )
        {    
            $postData = Input::All();

            $messages = [
                'company.required'      => 'กรุณากรอก',                 
            ];

             $rules = [
                'company'     => 'required', 
             ];

            $validator = Validator::make($postData, $rules, $messages);
            if ($validator->fails()) {               
                return Redirect::route('company.create')->withInput()->withErrors($validator);
            }
            else
            {
                $data = Request::all(); 

                $company = new Company();
                $company->company   = $data['company'];
                $company->address   = $data['address'];
                $company->mobile    = $data['mobile'];
                $company->email     = $data['email'];

                DB::transaction(function() use ($company) {
                    $company->save();  
                }); 

                Session::flash( 'savedata', save_data );

                return Redirect::to('company');
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
            $data = Company::find( e($id) );
            return View::make( 'company.edit', array('data' => $data) );
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
        if( Session::get('level') == '1' && Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) )
        {    
            $postData = Input::All();

            $messages = [
                'company.required'      => 'กรุณากรอก',                 
            ];

             $rules = [
                'company'     => 'required', 
             ];

            $validator = Validator::make($postData, $rules, $messages);
            if ($validator->fails()) {               
                return Redirect::route('company.create')->withInput()->withErrors($validator);
            }
            else
            {
                $data = Request::all(); 

                $company = Company::find( e($id) );
                $company->company   = $data['company'];
                $company->address   = $data['address'];
                $company->mobile    = $data['mobile'];
                $company->email     = $data['email'];

                DB::transaction(function() use ($company) {
                    $company->save();  
                }); 

                Session::flash( 'savedata', save_data );

                return Redirect::to('company');
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
            $company = Company::find( e($id) );  

            DB::transaction(function() use ($company) {
                Company::find( $company->id )->delete(); 
            });

            return Redirect::to('company');           
        }
        else
        {
            return Redirect::to('/');
        }
    }
}
