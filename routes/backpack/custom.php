<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('asset_class', 'AssetClassCrudController');
	Route::crud('lender', 'LenderCrudController');
    Route::crud('document_category', 'DocumentCategoryCrudController');
    Route::crud('document', 'DocumentCrudController');
    Route::crud('email_sms', 'EmailSMSCrudController');
    Route::crud('lender_type', 'LenderTypeCrudController');
    Route::crud('instrument_type', 'InstrumentTypeCrudController');
    Route::crud('facility_type', 'FacilityTypeCrudController');
	Route::crud('contact_us', 'ContactUsCrudController');
	
	Route::get('getSubCategory/{document_category_id}', 'DocumentCategoryCrudController@getSubCategory');
    Route::crud('enquiry', 'EnquiryCrudController');
    Route::crud('user_document', 'UserDocumentCrudController');
    Route::crud('user_pdf', 'UserPDFCrudController');
    Route::crud('banking_arrangment', 'BankingArrangmentCrudController');
    Route::crud('lender_banking', 'LenderBankingCrudController');
    Route::crud('lender_banking_detail', 'LenderBankingDetailCrudController');
    Route::crud('user_login', 'UserLoginCrudController');
    Route::crud('user_login_attempt', 'UserLoginAttemptCrudController');	
    Route::crud('analytics_graph', 'AnalyticsGraphCrudController');
	
	Route::crud('permission', 'PermissionCrudController');
    Route::crud('role', 'RoleCrudController');
    Route::crud('user', 'UserCrudController');
	
	Route::post('checkerDocument/{document_id}', 'DocumentCrudController@checkerDocument');
	Route::post('checkerBankingArrangment/{lender_banking_id}', 'LenderBankingCrudController@checkerBankingArrangment');
	
	Route::get('exportLenderBanking', 'ImportExportController@exportLenderBanking');
	Route::get('importLenderBanking', 'ImportExportController@importLenderBanking');
	Route::post('insertLenderBanking', 'ImportExportController@insertLenderBanking');

    Route::get('exportLenderBankingDetail', 'ImportExportController@exportLenderBankingDetail');
    Route::get('importLenderBankingDetail', 'ImportExportController@importLenderBankingDetail');
    Route::post('insertLenderBankingDetail', 'ImportExportController@insertLenderBankingDetail');
    
}); // this should be the absolute last line of this file