<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Support\Str;
use Input;
use Image;
use Request;
use Session;
use View;
use Redirect;
use Validator;
use Hash;
use DB;

class HomeController extends Controller
{





    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        if(  Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ){                    
            return view::make('dasboard.index');
        }
        else{
            return Redirect::to('login');
        }
    }
    
    
    
    
    
    
    public function graphgroup()
    {
        if(  Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ){                    
            if( Session::get('level') == 1 || Session::get('level') == 2 ){
                $data = DB::table('sp_issue')
                        ->leftjoin('sp_issue_detail', 'sp_issue_detail.id_issue', '=', 'sp_issue.id')
                        ->select(DB::raw('concat("รอบที่ ",sp_issue.approve_q) as around'), DB::raw('sum(sp_issue_detail.supply) as totalqty'))
                        ->groupby('sp_issue.approve_q')
                        ->get();
            }
            else{
               $data = DB::table('sp_issue')
                        ->leftjoin('sp_issue_detail', 'sp_issue_detail.id_issue', '=', 'sp_issue.id')
                        ->where('sp_issue.issue_user', Session::get('uid'))
                        ->select(DB::raw('concat("รอบที่ ",sp_issue.approve_q) as around'), DB::raw('sum(sp_issue_detail.supply) as totalqty'))
                        ->groupby('sp_issue.approve_q')
                        ->get();
            }
            
            return json_encode($data);
        }
        else{
            return Redirect::to('login');
        }
    }





    public function loadApp()
    {
        $filename = 'stock-nth.apk';
        $headers = array();
        $disposition = 'attachment';
        $response = new BinaryFileResponse(storage_path().'/'.$filename, 200, $headers, true);

        return $response->setContentDisposition($disposition, $filename, Str::ascii($filename));
    }




    
}
