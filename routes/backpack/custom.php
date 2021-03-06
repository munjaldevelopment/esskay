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

    Route::get('getLastLenderBanking', 'LenderBankingDetailCrudController@getLastLenderBanking');
    Route::get('getLastLenderBankingDetail', 'LenderBankingDetailCrudController@getLastLenderBankingDetail');
    

    Route::post('checkerBankingArrangmentDetail/{lender_banking_id}', 'LenderBankingDetailCrudController@checkerBankingArrangmentDetail');

    Route::get('getLenderBanking/{lender_id}', 'LenderBankingCrudController@getLenderBanking');
	
	Route::get('exportLenderBanking', 'ImportExportController@exportLenderBanking');
	Route::get('importLenderBanking', 'ImportExportController@importLenderBanking');
	Route::post('insertLenderBanking', 'ImportExportController@insertLenderBanking');

    Route::get('exportLenderBankingDetail', 'ImportExportController@exportLenderBankingDetail');
    Route::get('importLenderBankingDetail', 'ImportExportController@importLenderBankingDetail');
    Route::post('insertLenderBankingDetail', 'ImportExportController@insertLenderBankingDetail');

    Route::get('exportOperationalHighlight', 'ImportExportController@exportOperationalHighlight');
    Route::get('importOperationalHighlight', 'ImportExportController@importOperationalHighlight');
    Route::post('insertOperationalHighlight', 'ImportExportController@insertOperationalHighlight');
    
    Route::crud('insight_category', 'InsightCategoryCrudController');
    Route::crud('trustee', 'TrusteeCrudController');
    Route::crud('trustee_type', 'TrusteeTypeCrudController');

    Route::crud('operational_highlight', 'OperationalHighlightCrudController');
    Route::crud('geographical_concentration', 'GeographicalConcentrationCrudController');
    Route::crud('product_concentration', 'ProductConcentrationCrudController');
    Route::crud('asset_quality', 'AssetQualityCrudController');
    Route::crud('collection_efficiency', 'CollectionEfficiencyCrudController');
    Route::crud('net_worth', 'NetWorthCrudController');
    Route::crud('liquidity', 'LiquidityCrudController');
}); // this should be the absolute last line of this file