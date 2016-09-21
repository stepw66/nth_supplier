<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


define('error_login', 'ชื่อผู้ใช้งานหรือรหัสผ่าน ผิด!! กรุณาลองใหม่อีกครั้ง');
define('save_data', 'บันทึกข้อมูลเรียบร้อยแล้ว');





Route::get('/', 'HomeController@index');
Route::get('downloads/app', 'HomeController@loadApp');





//------page dashboard------------//
Route::get('graphgroup', 'HomeController@graphgroup');






//------page issue------------//
Route::get('getprice/{id}', 'IssueController@getprice');
Route::post('addissueTemp', 'IssueController@addissueTemp');
Route::get('listissueTemp/{id}', 'IssueController@listissueTemp');
Route::get('issue/{id}', 'IssueController@destroy');
Route::get('clearissueTemp/{id}', 'IssueController@clearissueTemp');
Route::post('addIssue', 'IssueController@addIssue');
Route::get('listIssue', 'IssueController@listIssue');
Route::get('showIssue/{id}', 'IssueController@showIssue');
Route::post('showIssue/oksupply', 'IssueController@oksupply');
Route::post('showIssue/updateapprove', 'IssueController@updateapprove');
Route::get('showIssue/printissue/{id}', 'IssueController@printissue');
Route::get('showIssue/loadfileprint/{id}', 'IssueController@loadfileprint');
Route::get('editIssue/detail/{id}', 'IssueController@editIssue');
Route::get('editIssue/delete/{id}/{id2}', 'IssueController@deleteIssueDetail');
Route::post('editIssue/detail/addEditIssue', 'IssueController@addEditIssue');
Route::post('editIssue/detail/getsupplier', 'ReceiveController@getsupplier');
Route::get('editIssue/detail/getprice/{id}', 'IssueController@getprice');
Route::get('editIssue/issueeditlist/{id}/{spid}', 'IssueController@getissuelistedit');
Route::post('editIssueList', 'IssueController@editIssueList');

Route::get('showIssue/sp_restore/{id1}/{id2}/{id3}', 'IssueController@sp_restore');
Route::get('showIssue/sp_issue_bg/{id1}/{id2}/{id3}', 'IssueController@sp_issue_bg');




//--------page recive-----------//
Route::post('getsupplier', 'ReceiveController@getsupplier');
Route::post('addSpTemp', 'ReceiveController@addSpTemp');
Route::get('listTemp/{id}', 'ReceiveController@listTemp');
Route::post('addReceive', 'ReceiveController@addReceive');
Route::get('receive/{id}', 'ReceiveController@destroy');
Route::get('clearTemp/{id}', 'ReceiveController@clearTemp');
Route::get('listReceive', 'ReceiveController@listReceive');
Route::get('showReceive/{id}', 'ReceiveController@showReceive');
Route::get('gettempedit/{id}', 'ReceiveController@gettempedit');





//---------------page kumbuk-----------------//
Route::get('getspcode/{id}', 'KbCardController@getspcode');
Route::get('listkbcard', 'KbCardController@listkbcard');
Route::post('getspdep', 'KbCardController@getspdep');
Route::get('kbcardprint/{id}', 'KbCardController@kbcardprint');
Route::get('kbcardprint_small/{id}', 'KbCardController@kbcardprint_small');




//--------page report-----------//
Route::get('report/report_issuedep_round', 'ReportController@report_issuedep_round');
Route::get('report/reportissuedep/{id}/{id2}', 'ReportController@reportissuedep');
Route::get('report/report_issue_year', 'ReportController@report_issue_year');
Route::get('report/reportissueyear/{id}', 'ReportController@reportissueyear');
Route::get('report/report_use_dep', 'ReportController@report_use_dep');
Route::get('report/reportusedep/{id}/{id2}', 'ReportController@reportusedep');
Route::get('report/report_use_six', 'ReportController@report_use_six');
Route::get('report/reportusesix/{id}', 'ReportController@reportusesix');
Route::get('report/report_store_all', 'ReportController@report_store_all');
Route::get('report/report_store_all_2', 'ReportController@report_store_all_2');
Route::get('report/reportstoreall2/{id1}/{id2}', 'ReportController@reportstoreall2');

Route::get('report/report_store_all_3', 'ReportController@report_store_all_3');
Route::get('report/reportstoreall3/{id1}/{id2}', 'ReportController@reportstoreall3');

Route::get('report/loadfileprint/{id}', 'IssueController@loadfileprint');





Route::resource('login', 'LoginController');
Route::get('logout', 'LoginController@logout');





Route::resource('issue', 'IssueController');





Route::resource('receive', 'ReceiveController');





Route::resource('store', 'StoreController');





Route::resource('supplier', 'SupplierController');
Route::get('supplier/getcode/{id}', 'SupplierController@getcode');




Route::resource('user', 'UserController');


Route::resource('kbcard', 'KbCardController');
Route::resource('around', 'AroundController');
Route::resource('unit', 'UnitController');
Route::resource('type', 'SPtypeController');
Route::resource('department', 'DepController');
Route::resource('appfig', 'AppfigController');
Route::resource('company', 'CompanyController');