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

Route::get('/', 'HomeController@index')->name('dashboard');
Route::get('/login', 'HomeController@login');
Route::any('saveLogin', 'HomeController@saveLogin');

Route::get('/login-otp', 'HomeController@loginOtp');
Route::post('saveLoginOtp', 'HomeController@saveLoginOtp');

Route::post('saveResendLoginOtp', 'HomeController@saveResendLoginOtp');


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


Route::post('/insight', 'HomeController@insight');
Route::post('/document', 'HomeController@document');
Route::post('/news', 'HomeController@news');
Route::post('/contact_us', 'HomeController@contactUs');

Route::post('/sanction-letter', 'HomeController@sanctionLetter');

Route::post('/deal', 'HomeController@deal');

Route::post('/dealGrid', 'HomeController@dealGrid');
Route::post('/dealList', 'HomeController@dealList');

// Deal Sort
Route::post('/dealSort', 'HomeController@dealSort');
Route::post('/dealSortTrustee', 'HomeController@dealSortTrustee');


Route::post('/dealSearch', 'HomeController@dealSearch');
Route::post('/dealSearchTrustee', 'HomeController@dealSearchTrustee');

Route::get('/edit-password', 'HomeController@editPassword');
Route::get('/send-user-otp', 'HomeController@sendUserOtp');
Route::post('updatePassword', 'HomeController@updatePassword');

Route::post('/saveContact', 'HomeController@saveContact');

// Trustee Part
Route::post('/insightTrustee', 'HomeController@insightTrustee');
Route::post('/showInsightTrustee', 'HomeController@showInsightTrustee');
Route::post('/sanction-letter-trustee', 'HomeController@sanctionLetterTrustee');

Route::post('/dealTrustee', 'HomeController@dealTrustee');

Route::post('/dealGridTrustee', 'HomeController@dealGridTrustee');
Route::post('/dealListTrustee', 'HomeController@dealListTrustee');

Route::post('/newsTrustee', 'HomeController@newsTrustee');
Route::post('/contact_us_trustee', 'HomeController@contactUsTrustee');

Route::post('/documentTrustee', 'HomeController@documentTrustee');

Route::post('/showTrusteeTransactionInfo', 'HomeController@showTrusteeTransactionInfo');
Route::post('/showTrusteeTransactionDocumentInfo', 'HomeController@showTrusteeTransactionDocumentInfo');
Route::post('/assignTransactionDate', 'HomeController@assignTransactionDate');

Route::post('/showTrusteeTransactionDocument', 'HomeController@showTrusteeTransactionDocument');

Route::post('/showDocTrustee', 'HomeController@showDocTrustee');
Route::get('/previewDocTrustee/{id}', 'HomeController@previewDocTrustee');
Route::get('/downloadDocTrustee/{id}', 'HomeController@downloadDocTrustee');
Route::get('/downloadFileTrustee/{id}', 'HomeController@downloadFileTrustee');
Route::post('/showChildDocTrustee', 'HomeController@showChildDocTrustee');

Route::post('/saveContactTrustee', 'HomeController@saveContactTrustee');

Route::any('/transactionCategory/{id}', 'HomeController@transactionCategory');

// Trans Doc
Route::get('/previewTransDocTrustee/{id}', 'HomeController@previewTransDocTrustee');
Route::get('/downloadTransDocTrustee/{id}', 'HomeController@downloadTransDocTrustee');

// Graph

Route::any('/company_graph', 'HomeController@companyGraph');

// Insight Section
Route::post('/showInsight', 'HomeController@showInsight');

// Doc section
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

Route::get('/operationalHighlight', function () {
	\DB::statement("ALTER TABLE operational_highlights ADD operation_row3_year VARCHAR(4) NULL DEFAULT NULL AFTER `operational_highlight_status`");
});



Route::get('/updateCat', function () {
	\DB::statement("UPDATE insight_categories SET status = '0' WHERE id = 1");
});

Route::get('/updateGeo', function () {
	\DB::statement("UPDATE `geographical_concentrations` set amount_percentage1 = amount_percentage1 * 100;");
	\DB::statement("UPDATE `geographical_concentrations` set amount_percentage2 = amount_percentage2 * 100;");
	\DB::statement("UPDATE `geographical_concentrations` set amount_percentage3 = amount_percentage3 * 100;");
	\DB::statement("UPDATE `geographical_concentrations` set amount_percentage4 = amount_percentage4 * 100;");
	\DB::statement("UPDATE `geographical_concentrations` set amount_percentage5 = amount_percentage5 * 100;");
	\DB::statement("UPDATE `geographical_concentrations` set amount_percentage6 = amount_percentage6 * 100;");
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

Route::get('/updateUserEmail', function () {
	\DB::statement("UPDATE users Set name = TRIM(name) WHERE id > 2");
	\DB::statement("UPDATE users Set email = CONCAT(lower(name), '@skfin.in') WHERE id > 2");
	\DB::statement("UPDATE users Set email = REPLACE(email, ' ', '.') WHERE id > 2");
	\DB::statement("UPDATE users Set email = REPLACE(email, '.@', '@') WHERE id > 2");
	\DB::statement("UPDATE users Set email = REPLACE(email, '.(', '.') WHERE id > 2");
	\DB::statement("UPDATE users Set email = REPLACE(email, ')@', '@') WHERE id > 2");
	\DB::statement("UPDATE users Set email = REPLACE(email, '&.', '.') WHERE id > 2");
});

Route::get('/updateAll', function () {
	$updateData = array('is_banking_arrangement' => '1', 'is_message_md' => '1', 'is_document' => '1', 'is_financial_summary' => '1', 'is_newsletter' => '1', 'is_contact_us' => '1');
	\DB::table('lenders')->update($updateData);

	$updateData = array('lender_banking_status' => '1');
	\DB::table('lender_banking')->update($updateData);
});

Route::get('/terms', 'HomeController@termsPage');


Route::get('/enter_transaction_category_data', function () {
	\DB::table('transaction_category_trustee')->delete();
	
	$parentData = \DB::table('trustees')->get();
	$parentData1 = \DB::table('transaction_categories')->get();
	
	foreach($parentData as $row)
	{
		foreach($parentData1 as $row1)
		{
			\DB::table('transaction_category_trustee')->insert(['transaction_category_id' => $row1->id, 'trustee_id' => $row->id]);
		}
	}
});

Route::get('/enter_insight_category_data', function () {
	$parentData = \DB::table('insight_category_lender')->delete();
	
	$parentData = \DB::table('lenders')->get();
	$parentData1 = \DB::table('insight_categories')->get();
	
	foreach($parentData as $row)
	{
		foreach($parentData1 as $row1)
		{
			\DB::table('insight_category_lender')->insert(['insight_category_id' => $row1->id, 'lender_id' => $row->id]);
		}
	}
});

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

// Data
Route::get('/enter_current_deal_category_data', function () {
	$parentData = \DB::table('current_deal_category_lender')->delete();
	$parentData = \DB::table('current_deal_category_trustee')->delete();
	
	$parentData = \DB::table('lenders')->get();
	$parentData1 = \DB::table('current_deal_categories')->get();
	
	foreach($parentData as $row)
	{
		foreach($parentData1 as $row1)
		{
			\DB::table('current_deal_category_lender')->insert(['current_deal_category_id' => $row1->id, 'lender_id' => $row->id]);
		}
	}

	$parentData = \DB::table('trustees')->get();
	$parentData1 = \DB::table('current_deal_categories')->get();
	
	foreach($parentData as $row)
	{
		foreach($parentData1 as $row1)
		{
			\DB::table('current_deal_category_trustee')->insert(['current_deal_category_id' => $row1->id, 'trustee_id' => $row->id]);
		}
	}
});

Route::get('/enter_document_data', function () {
	$parentData = \DB::table('document_category_trustee')->delete();
	$parentData = \DB::table('document_trustee')->delete();

	$parentData = \DB::table('trustees')->get();
	$parentData1 = \DB::table('document_category')->get();
	
	foreach($parentData as $row)
	{
		foreach($parentData1 as $row1)
		{
			\DB::table('document_category_trustee')->insert(['document_category_id' => $row1->id, 'trustee_id' => $row->id]);
		}
	}

	$parentData = \DB::table('trustees')->get();
	$parentData1 = \DB::table('documents')->get();
	
	foreach($parentData as $row)
	{
		foreach($parentData1 as $row1)
		{
			\DB::table('document_trustee')->insert(['document_id' => $row1->id, 'trustee_id' => $row->id]);
		}
	}
});

// Send mail
Route::get('/test', function()
{
	$beautymail = app()->make(Snowfire\Beautymail\Beautymail::class, ['settings' => null]);
	$beautymail->send('emails.esskay', [], function($message)
	{
		$message
			->from('communication@skfin.in', 'ESSKAY FINCORP')
			->to('munjaldevelopment@gmail.com', 'Munjal Mayank')
			->cc('abhishekdevelopment@gmail.com', 'Abhishek')
			->cc('milankhadiya@yahoo.co.in', 'Milan Khadiya')
			->subject('Welcome!');
	});

});