@php
	$list_dashboard = backpack_user()->hasPermissionTo('list_dashboard');
	$list_lender_type = backpack_user()->hasPermissionTo('list_lender_type');
	$list_instrument_type = backpack_user()->hasPermissionTo('list_instrument_type');
	$list_facility_type = backpack_user()->hasPermissionTo('list_facility_type');
	$list_asset_class = backpack_user()->hasPermissionTo('list_asset_class');
	$list_document_category = backpack_user()->hasPermissionTo('list_document_category');
	$list_banking_arrangment = backpack_user()->hasPermissionTo('list_banking_arrangment');
	$list_insight_category = 1;//backpack_user()->hasPermissionTo('list_insight_category');
	$list_insight = 1;//backpack_user()->hasPermissionTo('list_insight');

	$list_email_sms = backpack_user()->hasPermissionTo('list_email_sms');
	$list_lender = backpack_user()->hasPermissionTo('list_lender');
	$maker_banking_arrangment = backpack_user()->hasPermissionTo('maker_banking_arrangment');
	$list_lender_banking = backpack_user()->hasPermissionTo('list_lender_banking');
	$list_document = backpack_user()->hasPermissionTo('list_document');
	$list_file_manager = backpack_user()->hasPermissionTo('list_file_manager');
	$list_log = backpack_user()->hasPermissionTo('list_log');
	$list_user_log = backpack_user()->hasPermissionTo('list_user_log');
	
	if($list_dashboard):
@endphp

<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
@php
	endif;
@endphp
{{-- <li class='nav-item'><a class='nav-link' href='{{ backpack_url('backup') }}'><i class='nav-icon la la-hdd-o'></i> Backups</a></li> --}}

@php
	if($list_lender_type || $list_instrument_type || $list_facility_type || $list_asset_class || $list_document_category || $list_banking_arrangment || $list_insight_category || $list_insight):
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
			if($list_insight):
		@endphp
		<li class='nav-item'><a class='nav-link' href='{{ backpack_url('insight') }}'><i class='nav-icon la la-list'></i> Insight</a></li>
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

	if($list_lender || $list_lender_banking):
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
@endphp
	</ul>
</li>
@php
	endif;

	if($list_document):
@endphp
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('document') }}'><i class='nav-icon la la-file-o'></i> Documents</a></li>
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