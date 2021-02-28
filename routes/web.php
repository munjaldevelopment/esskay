<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index');
Route::get('/login', 'HomeController@login');
Route::post('saveLogin', 'HomeController@saveLogin');

Route::get('/login-otp', 'HomeController@loginOtp');
Route::post('saveLoginOtp', 'HomeController@saveLoginOtp');


Route::get('/forgot-password', 'HomeController@forgotPassword');
Route::post('saveForgot', 'HomeController@saveForgot');

Route::get('/forgot-password-phone', 'HomeController@forgotPasswordPhone');
Route::post('saveForgotPhone', 'HomeController@saveForgotPhone');

Route::get('/register', 'HomeController@register');
Route::post('saveRegister', 'HomeController@saveRegister');

Route::get('/change_password', 'HomeController@changePassword');
Route::post('saveChangePassword', 'HomeController@saveChangePassword');


Route::get('/user_otp', 'HomeController@userOTP');
Route::post('/saveUserOTP', 'HomeController@saveUserOTP');

Route::get('/logout', 'HomeController@logout');

Route::post('/homepage', 'HomeController@homepage');
Route::post('/board', 'HomeController@boardPage');
Route::post('/keymanager', 'HomeController@keymanagerPage');

Route::post('/document', 'HomeController@document');
Route::post('/news', 'HomeController@news');
Route::post('/contact_us', 'HomeController@contactUs');

Route::get('/edit-password', 'HomeController@editPassword');
Route::get('/send-user-otp', 'HomeController@sendUserOtp');
Route::post('updatePassword', 'HomeController@updatePassword');

Route::post('/saveContact', 'HomeController@saveContact');

// Graph

Route::any('/company_graph', 'HomeController@companyGraph');

Route::post('/showDoc', 'HomeController@showDoc');
Route::get('/previewDoc/{id}', 'HomeController@previewDoc');
Route::get('/downloadDoc/{id}', 'HomeController@downloadDoc');
Route::get('/downloadFile/{id}', 'HomeController@downloadFile');

Route::post('/showChildDoc', 'HomeController@showChildDoc');

Route::post('/assignDate', 'HomeController@assignDate');

Route::any('/send_mail', 'HomeController@sendMail');

Route::get('/change_query', 'HomeController@changeQuery');

Route::get('/chart', 'HomeController@chart');

Route::get('/term-condition', 'HomeController@termCondition');
Route::get('/disclaimer', 'HomeController@disclaimer');

Route::get('/browser_info', 'BrowserDetectController@index');

Route::get('/showStatus', 'HomeController@showStatus');

Route::get('/user_password', function () {
	//$updateData = array('password' => Hash::make("12345678"), 'updated_at' => date('Y-m-d H:i:s'));
    //\DB::table('users')->where(['id' => 2])->update($updateData);
});

Route::get('/updateEmail', function () {
	\DB::statement("UPDATE lenders Set name = TRIM(name) WHERE id > 2");
	\DB::statement("UPDATE lenders Set email = CONCAT(lower(name), '@skfin.in') WHERE id > 2");
	\DB::statement("UPDATE lenders Set email = REPLACE(email, ' ', '.') WHERE id > 2");
	\DB::statement("UPDATE lenders Set email = REPLACE(email, '.@', '@') WHERE id > 2");
	\DB::statement("UPDATE lenders Set email = REPLACE(email, '.(', '.') WHERE id > 2");
	\DB::statement("UPDATE lenders Set email = REPLACE(email, ')@', '@') WHERE id > 2");
	\DB::statement("UPDATE lenders Set email = REPLACE(email, '&.', '.') WHERE id > 2");
});

Route::get('/updateAll', function () {
	$updateData = array('is_banking_arrangement' => '1', 'is_message_md' => '1', 'is_document' => '1', 'is_financial_summary' => '1', 'is_newsletter' => '1', 'is_contact_us' => '1');
	\DB::table('lenders')->update($updateData);

	$updateData = array('lender_banking_status' => '1');
	\DB::table('lender_banking')->update($updateData);
});

Route::get('/terms', 'HomeController@termsPage');

Route::get('/enter_doc_data', function () {
	$parentData = \DB::table('document_lender')->delete();
	
	$parentData = \DB::table('lenders')->get();
	$parentData1 = \DB::table('documents')->get();
	
	foreach($parentData as $row)
	{
		foreach($parentData1 as $row1)
		{
			\DB::table('document_lender')->insert(['document_id' => $row1->id, 'lender_id' => $row->id]);
		}
	}
});

Route::get('/enter_doc_cat_data', function () {
	$parentData = \DB::table('document_category_lender')->delete();
	
	$parentData = \DB::table('lenders')->get();
	$parentData1 = \DB::table('document_category')->get();
	
	foreach($parentData as $row)
	{
		foreach($parentData1 as $row1)
		{
			\DB::table('document_category_lender')->insert(['document_category_id' => $row1->id, 'lender_id' => $row->id]);
		}
	}
});

Route::get('/enter_data', function () {
	$parentData = \DB::table('document_category')->get();
	
	foreach($parentData as $row)
	{
		\DB::table('document_category_lender')->insert(['document_category_id' => $row->id, 'lender_id' => '1']);
	}
	exit;
	
	$parentData1 = \DB::table('documents')->get();
	
	foreach($parentData1 as $row)
	{
		\DB::table('document_lender')->insert(['document_id' => $row->id, 'lender_id' => '1']);
	}
});