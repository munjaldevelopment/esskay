@php
	$list_dashboard = backpack_user()->hasPermissionTo('list_dashboard');
	$list_lender_type = backpack_user()->hasPermissionTo('list_lender_type');
	$list_trustee_type = backpack_user()->hasPermissionTo('list_trustee_type');
	$list_instrument_type = backpack_user()->hasPermissionTo('list_instrument_type');
	$list_facility_type = backpack_user()->hasPermissionTo('list_facility_type');
	$list_asset_class = backpack_user()->hasPermissionTo('list_asset_class');
	$list_document_category = backpack_user()->hasPermissionTo('list_document_category');
	$list_banking_arrangment = backpack_user()->hasPermissionTo('list_banking_arrangment');
	$list_insight_category = backpack_user()->hasPermissionTo('list_insight_category');
	$list_insight = backpack_user()->hasPermissionTo('list_insight');

	$list_transaction_document_type = backpack_user()->hasPermissionTo('list_transaction_document_type');

	$list_operational_highlight = backpack_user()->hasPermissionTo('list_operational_highlight');
	$list_geographical_concentration = backpack_user()->hasPermissionTo('list_geographical_concentration');
	$list_product_concentration = backpack_user()->hasPermissionTo('list_product_concentration');
	$list_asset_quality = backpack_user()->hasPermissionTo('list_asset_quality');
	$list_collection_efficiency = backpack_user()->hasPermissionTo('list_collection_efficiency');
	$list_net_worth = backpack_user()->hasPermissionTo('list_net_worth');
	$list_net_worth_infusion = backpack_user()->hasPermissionTo('list_net_worth_infusion');
	$list_liquidity = backpack_user()->hasPermissionTo('list_liquidity');

	$list_current_deal_category = backpack_user()->hasPermissionTo('list_current_deal_category');
	$list_current_deal = backpack_user()->hasPermissionTo('list_current_deal');
	
	$list_sanction_letter = backpack_user()->hasPermissionTo('list_sanction_letter');
	$list_approve_sanction_letter = backpack_user()->hasPermissionTo('list_approve_sanction_letter');
	$list_reject_sanction_letter = backpack_user()->hasPermissionTo('list_reject_sanction_letter');

	$list_strong_liability_profile = backpack_user()->hasPermissionTo('list_strong_liability_profile');
	$list_strong_liability_profile_table = backpack_user()->hasPermissionTo('list_strong_liability_profile_table');

	$list_covid_relief = backpack_user()->hasPermissionTo('list_covid_relief');
	$list_covid_relief_borrower = backpack_user()->hasPermissionTo('list_covid_relief_borrower');


	$list_email_sms = backpack_user()->hasPermissionTo('list_email_sms');
	$list_lender = backpack_user()->hasPermissionTo('list_lender');
	$maker_banking_arrangment = backpack_user()->hasPermissionTo('maker_banking_arrangment');
	$list_lender_banking = backpack_user()->hasPermissionTo('list_lender_banking');
	
	$list_document = backpack_user()->hasPermissionTo('list_document');
	$list_accept_document = backpack_user()->hasPermissionTo('list_accept_document');
	$list_reject_document = backpack_user()->hasPermissionTo('list_reject_document');


	$list_file_manager = backpack_user()->hasPermissionTo('list_file_manager');
	$list_log = backpack_user()->hasPermissionTo('list_log');
	$list_user_log = backpack_user()->hasPermissionTo('list_user_log');
	
	$list_trustee = backpack_user()->hasPermissionTo('list_trustee');
	$list_transaction_category = backpack_user()->hasPermissionTo('list_transaction_category');

	$list_transaction = backpack_user()->hasPermissionTo('list_transaction');
	$list_accept_transaction = backpack_user()->hasPermissionTo('list_accept_transaction');
	$list_reject_transaction = backpack_user()->hasPermissionTo('list_reject_transaction');

	$list_transaction_document = backpack_user()->hasPermissionTo('list_transaction_document');
	$list_accept_transaction_document = backpack_user()->hasPermissionTo('list_accept_transaction_document');
	$list_reject_transaction_document = backpack_user()->hasPermissionTo('list_reject_transaction_document');

	if($list_dashboard):
@endphp

<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
@php
	endif;
@endphp
{{-- <li class='nav-item'><a class='nav-link' href='{{ backpack_url('backup') }}'><i class='nav-icon la la-hdd-o'></i> Backups</a></li> --}}

@php
	if($list_lender_type || $list_trustee_type || $list_instrument_type || $list_facility_type || $list_asset_class || $list_document_category || $list_banking_arrangment || $list_insight_category || $list_transaction_document_type || $list_transaction_category):
@endphp
<li class="nav-item nav-dropdown">
	<a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-list"></i> Master</a>
	<ul class="nav-dropdown-items">
		@php
			if($list_lender_type):
		@endphp
		<li class='nav-item'><a class='nav-link' href='{{ backpack_url('lender_type') }}'><i class='nav-icon la la-list'></i> Lender Type</a></li>
		@php
			endif;
			if($list_trustee_type):
		@endphp
		<li class='nav-item'><a class='nav-link' href='{{ backpack_url('trustee_type') }}'><i class='nav-icon la la-list'></i> Trustee Type</a></li>
		@php
			endif;
			if($list_instrument_type):
		@endphp
		<li class='nav-item'><a class='nav-link' href='{{ backpack_url('instrument_type') }}'><i class='nav-icon la la-list'></i> Instrument Type</a></li>
		@php
			endif;
			if($list_facility_type):
		@endphp
		<li class='nav-item'><a class='nav-link' href='{{ backpack_url('facility_type') }}'><i class='nav-icon la la-list'></i> Facility Type</a></li>
		@php
			endif;
			if($list_asset_class):
		@endphp
		<li class='nav-item'><a class='nav-link' href='{{ backpack_url('asset_class') }}'><i class='nav-icon la la-list'></i> Asset Classes</a></li>
		@php
			endif;
			if($list_document_category):
		@endphp
		<li class='nav-item'><a class='nav-link' href='{{ backpack_url('document_category') }}'><i class='nav-icon la la-list'></i> Doc Category</a></li>
		@php
			endif;
			if($list_banking_arrangment):
		@endphp
		<li class='nav-item'><a class='nav-link' href='{{ backpack_url('banking_arrangment') }}'><i class='nav-icon la la-list'></i> Banking Arrangment</a></li>
		@php
			endif;
			if($list_insight_category):
		@endphp
		<li class='nav-item'><a class='nav-link' href='{{ backpack_url('insight_category') }}'><i class='nav-icon la la-list'></i> Insight Category</a></li>
		@php
			endif;
			if($list_transaction_document_type):
		@endphp
		<li class='nav-item'><a class='nav-link' href='{{ backpack_url('transaction_document_type') }}'><i class='nav-icon la la-list'></i> Trans. Document Type</a></li>
		@php
			endif;

			if($list_transaction_category):
		@endphp
		<li class='nav-item'><a class='nav-link' href='{{ backpack_url('transaction_category') }}'><i class='nav-icon la la-user'></i> Trans. Category</a></li>
		@php
			endif;
		@endphp
	</ul>
</li>
@php
	endif;
@endphp

@php
	if($list_email_sms):
@endphp
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('email_sms') }}'><i class='nav-icon la la-cog'></i> Email / SMS </a></li>
@php
	endif;

	if($list_operational_highlight || $list_geographical_concentration || $list_product_concentration || $list_asset_quality || $list_collection_efficiency || $list_strong_liability_profile || $list_strong_liability_profile_table || $list_covid_relief || $list_covid_relief_borrower):
@endphp
<li class="nav-item nav-dropdown">
	<a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-list"></i> Insight</a>
	<ul class="nav-dropdown-items">
		@php
		if($list_operational_highlight):
		@endphp
			<li class='nav-item'><a class='nav-link' href='{{ backpack_url('operational_highlight') }}'><i class='nav-icon la la-list'></i> Operational Highlight</a></li>
		@php
			endif;
			if($list_geographical_concentration):
		@endphp
			<li class='nav-item'><a class='nav-link' href='{{ backpack_url('geographical_concentration') }}'><i class='nav-icon la la-list'></i> Graphical Con.</a></li>
		@php
			endif;
			if($list_product_concentration):
		@endphp
			<li class='nav-item'><a class='nav-link' href='{{ backpack_url('product_concentration') }}'><i class='nav-icon la la-list'></i> Product Con.</a></li>
		@php
			endif;
			if($list_asset_quality):
		@endphp
			<li class='nav-item'><a class='nav-link' href='{{ backpack_url('asset_quality') }}'><i class='nav-icon la la-list'></i> Asset Quality</a></li>
		@php
			endif;
			if($list_collection_efficiency):
		@endphp
			<li class='nav-item'><a class='nav-link' href='{{ backpack_url('collection_efficiency') }}'><i class='nav-icon la la-list'></i> Collection Efficiency</a></li>
		@php
			endif;
			if($list_net_worth):
		@endphp
			<li class='nav-item'><a class='nav-link' href='{{ backpack_url('net_worth') }}'><i class='nav-icon la la-list'></i> Net Worth</a></li>
		@php
			endif;
			if($list_net_worth_infusion):
		@endphp
			<li class='nav-item'><a class='nav-link' href='{{ backpack_url('networth_infusion') }}'><i class='nav-icon la la-list'></i> Net Worth Infusions</a></li>
		@php
			endif;
			if($list_liquidity):
	@endphp
			<li class='nav-item'><a class='nav-link' href='{{ backpack_url('liquidity') }}'><i class='nav-icon la la-list'></i> Liquidity</a></li>
	@php
			endif;

			if($list_strong_liability_profile):
	@endphp
			<li class='nav-item'><a class='nav-link' href='{{ backpack_url('strongliabilityprofile') }}'><i class='nav-icon la la-list'></i> Strong Liability Profile</a></li>
	@php
			endif;

	 		if($list_strong_liability_profile_table):
	@endphp
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('strongliabilityprofiletable') }}'><i class='nav-icon la la-list'></i> Strong Liability Profile Table</a></li>
	@php
			endif;

			if($list_covid_relief):
@endphp
			<li class='nav-item'><a class='nav-link' href='{{ backpack_url('covidrelief_lender') }}'><i class='nav-icon la la-list'></i> Covid Relief Lenders</a></li>
@php
	endif;

	if($list_covid_relief_borrower):
@endphp
			<li class='nav-item'><a class='nav-link' href='{{ backpack_url('covidrelief_borrower') }}'><i class='nav-icon la la-list'></i> Covid Relief
 Borrowers</a></li>
@php
	endif;
		@endphp
	</ul>
</li>
@php
	endif;
@endphp

@php
	if($list_current_deal_category || $list_current_deal):
@endphp
<li class="nav-item nav-dropdown">
	<a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-list"></i> Deal</a>
	<ul class="nav-dropdown-items">
	@php
		if($list_current_deal_category):
	@endphp
		<li class='nav-item'><a class='nav-link' href='{{ backpack_url('currentdeal_category') }}'><i class='nav-icon la la-list'></i> Current Deal Category</a></li>
	@php
		endif;
		if($list_current_deal):
	@endphp
	<li class='nav-item'><a class='nav-link' href='{{ backpack_url('current_deal') }}'><i class='nav-icon la la-list'></i> Current Deal</a></li>
	@php
		endif;
	@endphp
	</ul>
</li>
@php
	endif;

	if($list_sanction_letter || $list_approve_sanction_letter || $list_reject_sanction_letter):
@endphp
<li class="nav-item nav-dropdown">
	<a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-list"></i> Sanction Letter</a>
	<ul class="nav-dropdown-items">
		@php
			if($list_sanction_letter):
		@endphp
		<li class='nav-item'><a class='nav-link' href='{{ backpack_url('sanction_letter') }}'><i class='nav-icon la la-list'></i> Sanction Letters</a></li>
	@php
			endif;

			if($list_approve_sanction_letter):
		@endphp
		<li class='nav-item'><a class='nav-link' href='{{ backpack_url('approve_sanction_letter') }}'><i class='nav-icon la la-check'></i> Approve Sanction Letters</a></li>
	@php
			endif;

			if($list_reject_sanction_letter):
		@endphp
		<li class='nav-item'><a class='nav-link' href='{{ backpack_url('reject_sanction_letter') }}'><i class='nav-icon la la-times'></i> Reject Sanction Letters</a></li>
	@php
			endif;
	@endphp
	</ul>
</li>
@php
	endif;
@endphp

@php
	
	if($list_lender || $list_lender_banking || $list_document || $list_accept_document || $list_reject_document):
@endphp
<li class="nav-item nav-dropdown">
	<a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-list"></i> Lender</a>
	<ul class="nav-dropdown-items">
@php
	if($list_lender):
@endphp
		<li class='nav-item'><a class='nav-link' href='{{ backpack_url('lender') }}'><i class='nav-icon la la-user'></i> Lenders</a></li>
@php
	endif;
	if($list_lender_banking):
@endphp
		<li class='nav-item'><a class='nav-link' href='{{ backpack_url('lender_banking') }}'><i class='nav-icon la la-file-o'></i> Lender Banking</a></li>
		<li class='nav-item'><a class='nav-link' href='{{ backpack_url('lender_banking_detail') }}'><i class='nav-icon la la-file-o'></i> Lender Banking Detail</a></li>
@php
	endif;
	if($list_document):
@endphp
		<li class='nav-item'><a class='nav-link' href='{{ backpack_url('document') }}'><i class='nav-icon la la-list'></i> Lender Documents</a></li>
@php
	endif;

	if($list_accept_document):
@endphp
		<li class='nav-item'><a class='nav-link' href='{{ backpack_url('accept_document') }}'><i class='nav-icon la la-check'></i> Accept Lender Documents</a></li>
@php
	endif;

	if($list_reject_document):
@endphp
		<li class='nav-item'><a class='nav-link' href='{{ backpack_url('reject_document') }}'><i class='nav-icon la la-times'></i> Reject Lender Documents</a></li>
@php
	endif;
@endphp
	</ul>
</li>
@php
	endif;

	if($list_trustee || $list_transaction || $list_accept_transaction || $list_reject_transaction || $list_transaction_document || $list_accept_transaction_document || $list_reject_transaction_document):
@endphp
<li class="nav-item nav-dropdown">
	<a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-list"></i> Trustee</a>
	<ul class="nav-dropdown-items">
@php
	if($list_trustee):
@endphp
		<li class='nav-item'><a class='nav-link' href='{{ backpack_url('trustee') }}'><i class='nav-icon la la-user'></i> Trustee</a></li>
@php
	endif;

	if($list_transaction):
@endphp
		<li class='nav-item'><a class='nav-link' href='{{ backpack_url('transaction') }}'><i class='nav-icon la la-list'></i> Transaction</a></li>
@php
	endif;

	if($list_accept_transaction):
@endphp
		<li class='nav-item'><a class='nav-link' href='{{ backpack_url('accept_transaction') }}'><i class='nav-icon la la-check'></i> Accept Transaction</a></li>
@php
	endif;

	if($list_reject_transaction):
@endphp
		<li class='nav-item'><a class='nav-link' href='{{ backpack_url('reject_transaction') }}'><i class='nav-icon la la-times'></i> Reject Transaction</a></li>
@php
	endif;

	if($list_transaction_document):
@endphp
		<li class='nav-item'><a class='nav-link' href='{{ backpack_url('transaction_document') }}'><i class='nav-icon la la-list'></i> Trans. Document</a></li>
@php
	endif;

	if($list_accept_transaction_document):
@endphp
		<li class='nav-item'><a class='nav-link' href='{{ backpack_url('accept_transaction_document') }}'><i class='nav-icon la la-check'></i> Accept Transaction Document</a></li>
@php
	endif;

	if($list_reject_transaction_document):
@endphp
		<li class='nav-item'><a class='nav-link' href='{{ backpack_url('reject_transaction_document') }}'><i class='nav-icon la la-times'></i> Reject Transaction Document</a></li>
@php
	endif;
@endphp
	</ul>
</li>
@php
	endif;

	if($list_user_log):
@endphp
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('user_document') }}'><i class='nav-icon la la-file-o'></i> Documents Download</a></li>
@php
	endif;
@endphp

@php
	$is_super_admin = backpack_user()->hasRole('Super Admin');
	if($is_super_admin):
@endphp

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('page') }}'><i class='nav-icon la la-file-o'></i> <span>Pages</span></a></li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('setting') }}'><i class='nav-icon la la-cog'></i> Settings</a></li> 

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('contact_us') }}'><i class='nav-icon la la-envelope'></i> Contact Us</a></li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('enquiry') }}'><i class='nav-icon la la-envelope'></i> Enquiry</a></li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('analytics_graph') }}'><i class='nav-icon la la-bar-chart'></i> Analytics Graph</a></li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('user_login') }}'><i class='nav-icon la la-lock'></i> User Login</a></li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('user_login_attempt') }}'><i class='nav-icon la la-lock'></i> User Login Attempt</a></li>

<!-- Users, Roles, Permissions -->
<li class="nav-item nav-dropdown">
	<a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-users"></i> Authentication</a>
	<ul class="nav-dropdown-items">
	  <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-user"></i> <span>Users</span></a></li>
	  <li class="nav-item"><a class="nav-link" href="{{ backpack_url('role') }}"><i class="nav-icon la la-id-badge"></i> <span>Roles</span></a></li>
	  <li class="nav-item"><a class="nav-link" href="{{ backpack_url('permission') }}"><i class="nav-icon la la-key"></i> <span>Permissions</span></a></li>
	</ul>
</li>

<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-newspaper-o"></i>News</a>
    <ul class="nav-dropdown-items">
      <li class="nav-item"><a class="nav-link" href="{{ backpack_url('article') }}"><i class="nav-icon la la-newspaper-o"></i> Articles</a></li>
      <li class="nav-item"><a class="nav-link" href="{{ backpack_url('category') }}"><i class="nav-icon la la-list"></i> Categories</a></li>
      <li class="nav-item"><a class="nav-link" href="{{ backpack_url('tag') }}"><i class="nav-icon la la-tag"></i> Tags</a></li>
    </ul>
</li>
@php
	endif;
	if($list_log):
@endphp
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('log') }}'><i class='nav-icon la la-terminal'></i> Logs</a></li>
@php
	endif;
	if($list_file_manager):
@endphp
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('elfinder') }}"><i class="nav-icon la la-files-o"></i> <span>{{ trans('backpack::crud.file_manager') }}</span></a></li>
@php
	endif;
@endphp