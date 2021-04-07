<div class="mtd-inner-box mtd-doc-main">
	<div class="mtd-inner">
		 <!-- Menu -->
		<div class="side-menu"  id="content-1">
			<nav class="navbar" role="navigation">
				<!-- Main Menu -->
				<div class="side-menu-container">
					<ul class="nav navbar-nav category-listing" id="menu-accordian">
						@php
							$count = 1;
						@endphp
						@foreach($parentCategoryData as $id => $parentCategoryRow)
							<li @if(isset($childCategoryData[$id])) class="panel panel-default" id="dropdown" @endif>
								<a data-toggle="collapse" href="#dropdown-lv{{$id}}" data-category="{{$id}}">
									<span><img src="{{ $parentCategoryRow['image'] }}" alt=""></span> {{ $parentCategoryRow['name'] }} <span class="caret-icon"><img src="{{ asset('public/assets/') }}/images/slide-menu-dropi.svg" alt=""></span>
								</a>

								@if(isset($childCategoryData[$id]))
								<div id="dropdown-lv{{$id}}" class="panel-collapse collapse @if($count == 1) collapse show @endif" data-parent="#menu-accordian">
									<div class="panel-body">
										<ul class="nav navbar-nav">
											@php
												$count1 = 1;
											@endphp
											@foreach($childCategoryData[$id] as $id1 => $childCategoryRow)
											<li><a href="javascript:;" class="doc-category-list dropdown-box @if($count == 1 && $count1 == 1) first-child @endif" data-level="2" data-category="{{$id1}}"><span><img src="{{ asset('public/assets/') }}/images/sub-dropdown-icon.svg" alt=""></span> {{ $childCategoryRow['name'] }}</a></li>
											@php
												$count1++;
											@endphp
											@endforeach
										</ul>
									</div>
								</div>
								@endif
							</li>
							@php
								$count++;
							@endphp
						@endforeach
					</ul>
				</div><!-- /.navbar-collapse -->
			</nav>
		</div>

		<input type="hidden" name="assign_date" class="assign_date" value="{{ $current_year }}" />

		<div class="side-body">
			<div class="doc-container">
				<div class="alert alert-warning">
					Please click on left section to get products
				</div>
			</div>
		</div>
	</div>
</div>

<div class="preloader_doc" style="display:none">
	<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin:auto;display:block;" width="200px" height="200px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
		<g transform="rotate(0 50 50)">
		  <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#0d12aa">
			<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.9166666666666666s" repeatCount="indefinite"></animate>
		  </rect>
		</g><g transform="rotate(30 50 50)">
		  <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#0d12aa">
			<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.8333333333333334s" repeatCount="indefinite"></animate>
		  </rect>
		</g><g transform="rotate(60 50 50)">
		  <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#0d12aa">
			<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.75s" repeatCount="indefinite"></animate>
		  </rect>
		</g><g transform="rotate(90 50 50)">
		  <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#0d12aa">
			<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.6666666666666666s" repeatCount="indefinite"></animate>
		  </rect>
		</g><g transform="rotate(120 50 50)">
		  <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#0d12aa">
			<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.5833333333333334s" repeatCount="indefinite"></animate>
		  </rect>
		</g><g transform="rotate(150 50 50)">
		  <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#0d12aa">
			<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.5s" repeatCount="indefinite"></animate>
		  </rect>
		</g><g transform="rotate(180 50 50)">
		  <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#0d12aa">
			<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.4166666666666667s" repeatCount="indefinite"></animate>
		  </rect>
		</g><g transform="rotate(210 50 50)">
		  <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#0d12aa">
			<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.3333333333333333s" repeatCount="indefinite"></animate>
		  </rect>
		</g><g transform="rotate(240 50 50)">
		  <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#0d12aa">
			<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.25s" repeatCount="indefinite"></animate>
		  </rect>
		</g><g transform="rotate(270 50 50)">
		  <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#0d12aa">
			<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.16666666666666666s" repeatCount="indefinite"></animate>
		  </rect>
		</g><g transform="rotate(300 50 50)">
		  <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#0d12aa">
			<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="-0.08333333333333333s" repeatCount="indefinite"></animate>
		  </rect>
		</g><g transform="rotate(330 50 50)">
		  <rect x="47" y="24" rx="3" ry="6" width="6" height="12" fill="#0d12aa">
			<animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="1s" begin="0s" repeatCount="indefinite"></animate>
		  </rect>
		</g>
		</svg>
</div>

<script>

$(document).ready(function() {
	
	var base_url = $('base').attr('href');
	
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	
	$('.doc-category-list').bind('click', function(e) {
		//e.preventDefault();
		
		var expanded = $(this).attr('aria-expanded');
		var level = $(this).attr('data-level');
		var category_id = $(this).attr('data-category_id');
		
		//$('.category-data').removeClass('show');
		//$('.category-list-data a').attr('aria-expanded', 'false');
		
	});
	
	$('.dropdown-box').bind('click', function() {
		var category = $(this).attr('data-category');
		
		//alert(category);
		var document_date = $('.assign_date').val();
		
		$.ajax({
			url: base_url+'showDoc',
			type: 'post',
			data: {_token: CSRF_TOKEN, category_id: category, document_date: document_date},
			beforeSend: function() {
				var content = $('.preloader_doc').html();
				$('.doc-container').html(content);
			},
			success: function(output) {
				$('.doc-container').html(output);

				$('.assign_date').val('{{ $current_year }}');
			}
		});
		
		$('ul.category-listing li').removeClass('active');
				
		$('ul.category-listing li a[data-category="'+category+'"]').parent('li').addClass("active");
	});
	
	
	$('ul.category-listing > li:first-child a.first-child').trigger('click');
});
</script>
