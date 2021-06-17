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
    Route::crud('accept_document', 'AcceptDocumentCrudController');
    Route::crud('reject_document', 'RejectDocumentCrudController');

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
    Route::post('checkerDocumentReject/{document_id}', 'DocumentCrudController@checkerDocumentReject');

    Route::post('checkerTransactionDocument/{document_id}', 'DocumentCrudController@checkerTransactionDocument');
    Route::post('checkerTransactionDocumentReject/{document_id}', 'DocumentCrudController@checkerTransactionDocumentReject');

    Route::post('checkerSanctionLetter/{document_id}', 'DocumentCrudController@checkerSanctionLetter');
    Route::post('checkerSanctionLetterReject/{document_id}', 'DocumentCrudController@checkerSanctionLetterReject');

    Route::post('checkerSanctionLetter2/{document_id}', 'DocumentCrudController@checkerSanctionLetter2');
    Route::post('checkerSanctionLetterReject2/{document_id}', 'DocumentCrudController@checkerSanctionLetterReject2');

    Route::post('checkerSanctionLetter3/{document_id}', 'DocumentCrudController@checkerSanctionLetter3');
    Route::post('checkerSanctionLetterReject3/{document_id}', 'DocumentCrudController@checkerSanctionLetterReject3');
    
    Route::post('checkerTransaction/{document_id}', 'DocumentCrudController@checkerTransaction');
    Route::post('checkerTransactionReject/{document_id}', 'DocumentCrudController@checkerTransactionReject');
	Route::post('checkerBankingArrangment/{lender_banking_id}', 'LenderBankingCrudController@checkerBankingArrangment');

    // Insight
    Route::post('checkerOperationalHighlight/{document_id}', 'DocumentCrudController@checkerOperationalHighlight');
    Route::post('checkerOperationalHighlightReject/{document_id}', 'DocumentCrudController@checkerOperationalHighlightReject');

    //geographicalConcentration
    Route::post('checkergeographicalConcentration/{document_id}', 'DocumentCrudController@checkergeographicalConcentration');
    Route::post('checkergeographicalConcentrationReject/{document_id}', 'DocumentCrudController@checkergeographicalConcentrationReject');

    //Product Concentrations
    Route::post('checkerproductConcentration/{document_id}', 'DocumentCrudController@checkerproductConcentration');
    Route::post('checkerproductConcentrationReject/{document_id}', 'DocumentCrudController@checkerproductConcentrationReject');

    //asset_quality
    Route::post('checkerassetQuality/{document_id}', 'DocumentCrudController@checkerassetQuality');
    Route::post('checkerassetQualityReject/{document_id}', 'DocumentCrudController@checkerassetQualityReject');

    //collection_efficiency
    Route::post('checkercollectionEfficiency/{document_id}', 'DocumentCrudController@checkercollectionEfficiency');
    Route::post('checkercollectionEfficiencyReject/{document_id}', 'DocumentCrudController@checkercollectionEfficiencyReject');

    //net_worth
    Route::post('checkernetWorth/{document_id}', 'DocumentCrudController@checkernetWorth');
    Route::post('checkernetWorthReject/{document_id}', 'DocumentCrudController@checkernetWorthReject');

    //net_worth_infusion
    Route::post('checkernetWorthInfusion/{document_id}', 'DocumentCrudController@checkernetWorthInfusion');
    Route::post('checkernetWorthInfusionReject/{document_id}', 'DocumentCrudController@checkernetWorthInfusionReject');

    //liquidity_status
    Route::post('checkerLiquidity/{document_id}', 'DocumentCrudController@checkerLiquidity');
    Route::post('checkerLiquidityReject/{document_id}', 'DocumentCrudController@checkerLiquidityReject');

    //strong_liability
    Route::post('checkerstrongLiabilityProfile/{document_id}', 'DocumentCrudController@checkerstrongLiabilityProfile');
    Route::post('checkerstrongLiabilityProfileReject/{document_id}', 'DocumentCrudController@checkerstrongLiabilityProfileReject');//strong_liability
    
    //strong_liability_tables
    Route::post('checkerstrongLiabilityProfileTable/{document_id}', 'DocumentCrudController@checkerstrongLiabilityProfileTable');
    Route::post('checkerstrongLiabilityProfileTableReject/{document_id}', 'DocumentCrudController@checkerstrongLiabilityProfileTableReject');

    //strong_liability_profile_ration
    Route::post('checkerstrongLiabilityProfileRatio/{document_id}', 'DocumentCrudController@checkerstrongLiabilityProfileRatio');
    Route::post('checkerstrongLiabilityProfileRatioReject/{document_id}', 'DocumentCrudController@checkerstrongLiabilityProfileRatioReject');

    //strong_liability_profile_driving
    Route::post('checkerstrongLiabilityProfileDriving/{document_id}', 'DocumentCrudController@checkerstrongLiabilityProfileDriving');
    Route::post('checkerstrongLiabilityProfileDrivingReject/{document_id}', 'DocumentCrudController@checkerstrongLiabilityProfileDrivingReject');

    //strong_liability_profile_well_table
    Route::post('checkerstrongLiabilityProfileWellTable/{document_id}', 'DocumentCrudController@checkerstrongLiabilityProfileWellTable');
    Route::post('checkerstrongLiabilityProfileWellTableReject/{document_id}', 'DocumentCrudController@checkerstrongLiabilityProfileWellTableReject'); 

    //strong_liability_profile_overall
    Route::post('checkerstrongLiabilityProfileOverall/{document_id}', 'DocumentCrudController@checkerstrongLiabilityProfileOverall');
    Route::post('checkerstrongLiabilityProfileOverallReject/{document_id}', 'DocumentCrudController@checkerstrongLiabilityProfileOverallReject');

    //liability_profile_category
    Route::post('checkerliabilityProfileCategory/{document_id}', 'DocumentCrudController@checkerliabilityProfileCategory');
    Route::post('checkerliabilityProfileCategoryReject/{document_id}', 'DocumentCrudController@checkerliabilityProfileCategoryReject');

    //liability_profile_slider
    Route::post('checkerliabilityProfileSlider/{document_id}', 'DocumentCrudController@checkerliabilityProfileSlider');
    Route::post('checkerliabilityProfileSliderReject/{document_id}', 'DocumentCrudController@checkerliabilityProfileSliderReject');

    //covid_relief_lender
    Route::post('checkercovidReliefLender/{document_id}', 'DocumentCrudController@checkercovidReliefLender');
    Route::post('checkercovidReliefLenderReject/{document_id}', 'DocumentCrudController@checkercovidReliefLenderReject');

    //covid_relief_borrower
    Route::post('checkercovidReliefBorrower/{document_id}', 'DocumentCrudController@checkercovidReliefBorrower');
    Route::post('checkercovidReliefBorrowerReject/{document_id}', 'DocumentCrudController@checkercovidReliefBorrowerReject');


    //current_deal
    Route::post('checkercurrentDeal/{document_id}', 'DocumentCrudController@checkercurrentDeal');
    Route::post('checkercurrentDealReject/{document_id}', 'DocumentCrudController@checkercurrentDealReject');

    //current_deal_category
    Route::post('checkercurrentDealCategory/{document_id}', 'DocumentCrudController@checkercurrentDealCategory');
    Route::post('checkercurrentDealCategoryReject/{document_id}', 'DocumentCrudController@checkercurrentDealCategoryReject');


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

    Route::get('exportGeographicalConcentration', 'ImportExportController@exportGeographicalConcentration');
    Route::get('importGeographicalConcentration', 'ImportExportController@importGeographicalConcentration');
    Route::post('insertGeographicalConcentration', 'ImportExportController@insertGeographicalConcentration');

    Route::get('exportProductConcentration', 'ImportExportController@exportProductConcentration');
    Route::get('importProductConcentration', 'ImportExportController@importProductConcentration');
    Route::post('insertProductConcentration', 'ImportExportController@insertProductConcentration');

    Route::get('exportAssetQuality', 'ImportExportController@exportAssetQuality');
    Route::get('importAssetQuality', 'ImportExportController@importAssetQuality');
    Route::post('insertAssetQuality', 'ImportExportController@insertAssetQuality');

    Route::get('exportCollectionEfficiency', 'ImportExportController@exportCollectionEfficiency');
    Route::get('importCollectionEfficiency', 'ImportExportController@importCollectionEfficiency');
    Route::post('insertCollectionEfficiency', 'ImportExportController@insertCollectionEfficiency');

    Route::get('exportNetWorth', 'ImportExportController@exportNetWorth');
    Route::get('importNetWorth', 'ImportExportController@importNetWorth');
    Route::post('insertNetWorth', 'ImportExportController@insertNetWorth');

    Route::get('exportNetWorthInfusion', 'ImportExportController@exportNetWorthInfusion');
    Route::get('importNetWorthInfusion', 'ImportExportController@importNetWorthInfusion');
    Route::post('insertNetWorthInfusion', 'ImportExportController@insertNetWorthInfusion');

    Route::get('exportLiquidity', 'ImportExportController@exportLiquidity');
    Route::get('importLiquidity', 'ImportExportController@importLiquidity');
    Route::post('insertLiquidity', 'ImportExportController@insertLiquidity');

    // New
    Route::get('exportStrongLiability', 'ImportExportController@exportStrongLiability');
    Route::get('importStrongLiability', 'ImportExportController@importStrongLiability');
    Route::post('insertStrongLiability', 'ImportExportController@insertStrongLiability');


    Route::get('exportStrongLiabilityTable', 'ImportExportController@exportStrongLiabilityTable');
    Route::get('importStrongLiabilityTable', 'ImportExportController@importStrongLiabilityTable');
    Route::post('insertStrongLiabilityTable', 'ImportExportController@insertStrongLiabilityTable');

    Route::get('exportStrongLiabilityRatio', 'ImportExportController@exportStrongLiabilityRatio');
    Route::get('importStrongLiabilityRatio', 'ImportExportController@importStrongLiabilityRatio');
    Route::post('insertStrongLiabilityRatio', 'ImportExportController@insertStrongLiabilityRatio');

    Route::get('exportStrongLiabilityDriving', 'ImportExportController@exportStrongLiabilityDriving');
    Route::get('importStrongLiabilityDriving', 'ImportExportController@importStrongLiabilityDriving');
    Route::post('insertStrongLiabilityDriving', 'ImportExportController@insertStrongLiabilityDriving');

    Route::get('exportStrongLiabilityWellTable', 'ImportExportController@exportStrongLiabilityWellTable');
    Route::get('importStrongLiabilityWellTable', 'ImportExportController@importStrongLiabilityWellTable');
    Route::post('insertStrongLiabilityWellTable', 'ImportExportController@insertStrongLiabilityWellTable');

    Route::get('exportStrongLiabilityOverall', 'ImportExportController@exportStrongLiabilityOverall');
    Route::get('importStrongLiabilityOverall', 'ImportExportController@importStrongLiabilityOverall');
    Route::post('insertStrongLiabilityOverall', 'ImportExportController@insertStrongLiabilityOverall');

    
    

    

    Route::get('exportCurrentDeal', 'ImportExportController@exportCurrentDeal');
    Route::get('importCurrentDeal', 'ImportExportController@importCurrentDeal');
    Route::post('insertCurrentDeal', 'ImportExportController@insertCurrentDeal');

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
    Route::crud('networth_infusion', 'NetWorthInfusionCrudController');
    Route::crud('currentdeal_category', 'CurrentDealCategoryCrudController');
    Route::crud('current_deal', 'CurrentDealCrudController');
    
    Route::crud('sanction_letter', 'SanctionLetterCrudController');
    Route::crud('approve_sanction_letter', 'ApproveSanctionLetterCrudController');
    Route::crud('reject_sanction_letter', 'RejectSanctionLetterCrudController');

    Route::crud('covidrelief_lender', 'CovidReliefLenderCrudController');
    Route::crud('covidrelief_borrower', 'CovidReliefBorrowerCrudController');
    Route::crud('transaction_category', 'TransactionCategoryCrudController');

    Route::crud('transaction', 'TransactionCrudController');
    Route::crud('accept_transaction', 'AcceptTransactionCrudController');
    Route::crud('reject_transaction', 'RejectTransactionCrudController');
    
    Route::crud('transaction_document', 'TransactionDocumentCrudController');
    Route::crud('accept_transaction_document', 'AcceptTransactionDocumentCrudController');
    Route::crud('reject_transaction_document', 'RejectTransactionDocumentCrudController');
    
    Route::crud('transaction_document_type', 'TransactionDocumentTypeCrudController');

    Route::get('getSanctionLetter/{count}', 'SanctionLetterCrudController@getSanctionLetter');
    
    Route::crud('strongliabilityprofile', 'StrongLiabilityProfileCrudController');
    Route::crud('strongliabilityprofiletable', 'StrongLiabilityProfileTableCrudController');
    Route::crud('strongliabilityprofileratio', 'StrongLiabilityProfileRatioCrudController');
    Route::crud('strongliabilityprofiledriving', 'StrongLiabilityProfileDrivingCrudController');
    Route::crud('strongliabilityprofilewelltable', 'StrongLiabilityProfileWellTableCrudController');
    Route::crud('strongliabilityprofileoverall', 'StrongLiabilityProfileOverallCrudController');
    Route::crud('liabilityprofilecategory', 'LiabilityProfileCategoryCrudController');
    Route::crud('liabilityprofileslider', 'LiabilityProfileSliderCrudController');
    Route::crud('insight_location', 'InsightLocationCrudController');
    Route::crud('state', 'StateCrudController');
    Route::crud('district', 'DistrictCrudController');
}); // this should be the absolute last line of this file