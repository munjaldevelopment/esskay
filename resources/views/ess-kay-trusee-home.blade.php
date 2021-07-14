@include('common.header_trustee_body')

<div class="preloader" style="display:none;"><div class="sk-cube-grid"><div class="sk-cube sk-cube1"></div><div class="sk-cube sk-cube2"></div><div class="sk-cube sk-cube3"></div><div class="sk-cube sk-cube4"></div><div class="sk-cube sk-cube5"></div><div class="sk-cube sk-cube6"></div><div class="sk-cube sk-cube7"></div><div class="sk-cube sk-cube8"></div><div class="sk-cube sk-cube9"></div></div></div>

<section class="custom-linear pt-3">
	<input type="hidden" id="is_transaction" class="is_transaction" value="{{ $trusteeData->is_transaction }}" />
	<input type="hidden" id="is_message_md" class="is_message_md" value="{{ $trusteeData->is_message_md }}" />
	<input type="hidden" id="is_insight" class="is_insight" value="{{ $trusteeData->is_insight }}" />
	<input type="hidden" id="is_current_deal" class="is_current_deal" value="{{ $trusteeData->is_current_deal }}" />
	<input type="hidden" id="is_document" class="is_document" value="{{ $trusteeData->is_document }}" />
	<input type="hidden" id="is_sanction_letter" class="is_sanction_letter" value="{{ $trusteeData->is_sanction_letter }}" />
	<input type="hidden" id="is_financial_summary" class="is_financial_summary" value="{{ $trusteeData->is_financial_summary }}" />
	<input type="hidden" id="is_newsletter" class="is_newsletter" value="{{ $trusteeData->is_newsletter }}" />
	<input type="hidden" id="is_contact_us" class="is_contact_us" value="{{ $trusteeData->is_contact_us }}" />
		
	<div class="main-tab-area">
		<div class="tab-top-area d-lg-block d-sm-none d-none">
			<ul class="nav esskay-home">
				@if($trusteeData->is_message_md == 1)
				<li class="nav-item">
					<!-- Single button -->
					<div class="dropdown dropdown-trustee">
						<button type="button" class="active nav-link btn btn-primary about-class dropdown-toggle" data-toggle="dropdown">About Us</button>
					  	<div class="dropdown-menu about-container">
							<a class="dropdown-item home-class" href="javascript:;">Message from MD</a>
							<a class="dropdown-item board-class" href="javascript:;">Board of  Directors</a>
							<a class="dropdown-item key-manager-class" href="javascript:;">Key Managerial Person</a>
							<a class="dropdown-item committee-class" href="javascript:;">Committee</a>
					  	</div>
					</div>
				</li>

				@endif
				@if($trusteeData->is_insight == 1)
				<li class="nav-item">
					<a class="nav-link insight-class @if($trusteeData->is_message_md == 0) active @endif" href="javascript:;">Insight</a>
				</li>
				@endif
				@if($trusteeData->is_document == 1)
				<li class="nav-item">
					<a class="nav-link doc-class @if($trusteeData->is_message_md == 0 && $trusteeData->is_insight == 0) active @endif" href="javascript:;">Documents</a>
				</li>
				@endif
				@if($trusteeData->is_sanction_letter == 1)
				<li class="nav-item">
					<a class="nav-link sanction-letter-class @if($trusteeData->is_message_md == 0 && $trusteeData->is_insight == 0 && $trusteeData->is_document == 0) active @endif" href="javascript:;">Sanction Letter</a>
				</li>
				@endif
				@if($trusteeData->is_current_deal  == 1)
				<li class="nav-item">
				<a class="nav-link deal-class @if($trusteeData->is_message_md == 0 && $trusteeData->is_insight == 0 && $trusteeData->is_document == 0) active @endif" href="javascript:;">Current Deal</a>
				</li>
				@endif

				@if($trusteeData->is_transaction == 1)
				<li class="nav-item">
					<div class="dropdown dropdown-trustee">
						<button type="button" class="nav-link btn btn-primary transaction-class dropdown-toggle" data-toggle="dropdown">Transaction</button>
					  	<div class="dropdown-menu">
					  		<ul>  
					  		@foreach($docCategoryData as $row)
							<li class="dropdown-item @if($row['children']) sub-menu @endif">
								<a class="dropdown-item transaction-category-class" data-category="{{ $row['category_id'] }}" href="javascript:;">{{ $row['category_name'] }}</a>

								@if($row['children'])
								<ul>
									@foreach($row['children'] as $child)
                            		<li @if($child['children']) class="sub-menu-2" @endif>
                            			<a class="dropdown-item transaction-category-class" data-category="{{ $child['category_id'] }}" href="javascript:;">{{ $child['category_name'] }}</a>
                            			
                            			@if($child['children'])
                            			<ul>
                            				@foreach($child['children'] as $child1)
                            				<li>
                            					<a class="dropdown-item transaction-category-class" data-category="{{ $child1['category_id'] }}" href="javascript:;">{{ $child1['category_name'] }}</a>
                            				</li>
                            				@endforeach
                            			</ul>
                            			@endif
                            		</li>
                            		@endforeach
                            	</ul>
								@endif
							</li>
							@endforeach
							</ul>
					  	</div>
					</div>
				</li>
				@endif

				@if($trusteeData->is_financial_summary == 1)
				<!--<li class="nav-item">
				<a class="nav-link graph-class @if($trusteeData->is_message_md == 0 && $trusteeData->is_document == 0) active @endif" href="javascript:;">Financial Summary</a>
				</li>-->
				@endif
				@if($trusteeData->is_newsletter == 1)
				<li class="nav-item">
				<a class="nav-link news-class @if($trusteeData->is_message_md == 0 && $trusteeData->is_insight == 0 && $trusteeData->is_document == 0 && $trusteeData->is_financial_summary == 0) active @endif" href="javascript:;">Newsletters</a>
				</li>
				@endif
				@if($trusteeData->is_contact_us == 1)
				<li class="nav-item">
				<a class="nav-link contact-class @if($trusteeData->is_message_md == 0 && $trusteeData->is_insight == 0 && $trusteeData->is_document == 0 && $trusteeData->is_financial_summary == 0 && $trusteeData->is_newsletter == 0) active @endif" href="javascript:;">Contact Us</a>
				</li>
				@endif

				
			</ul>
		</div>
	
		<div class="main-tab-details">
			<!-- Tab panes -->
			<div class="tab-content">
				<div class="home-content">
				</div>
			</div>
		</div>
	</div>
</section>

<style>
	.card.no-border {
		border:none;
	}
</style>
<script> 

	$('.dropdown-trustee').hover(function(){ 
  		//$('.dropdown-toggle', this).trigger('click'); 
	});

	$(document).ready(function(){
	});
</script>
@include('common.footer_trustee_body')
