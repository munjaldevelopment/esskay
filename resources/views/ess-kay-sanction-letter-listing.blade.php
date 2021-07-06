<div class="mtd-inner-box mtd-doc-main">
	<div class="mtd-inner">
		 <!-- Menu -->
		<div class="side-menu side-menu-sanction"  id="content-1">
			<nav class="navbar" role="navigation">
				<!-- Main Menu -->
				<div class="side-menu-container">
					<ul class="nav navbar-nav category-listing" id="menu-accordian">
						<li>
							<a class="dropdown-box sanction-letter-category-list" data-category="all" href="javascript:;" data-category="all">
								<span>All</span>
							</a>
						</li>
						<li>
							<a class="dropdown-box sanction-letter-category-list" data-category="accepted" href="javascript:;" data-category="accepted">
								<span>Accepted</span>
							</a>
						</li>
						<li>
							<a class="dropdown-box sanction-letter-category-list" data-category="rejected" href="javascript:;" data-category="rejected">
								<span>Rejected</span>
							</a>
						</li>
					</ul>
				</div><!-- /.navbar-collapse -->
			</nav>
		</div>

		<div class="side-body side-body-sanction">
			<div class="sanctionletter-container">
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
	
	$('.sanction-letter-category-list').bind('click', function(e) {
		//e.preventDefault();
		
		var expanded = $(this).attr('aria-expanded');
		var level = $(this).attr('data-level');
		var category_id = $(this).attr('data-category_id');
		
		//$('.category-data').removeClass('show');
		//$('.category-list-data a').attr('aria-expanded', 'false');
		
	});
	
	$('.dropdown-box').bind('click', function() {
		var category = $(this).attr('data-category');
		
		
		$.ajax({
			url: base_url+'showSanctionLetterInfo',
			type: 'post',
			data: {_token: CSRF_TOKEN, category_id: category},
			beforeSend: function() {
				var content = $('.preloader_doc').html();
				$('.sanctionletter-container').html(content);
			},
			success: function(output) {
				$('.sanctionletter-container').html(output);
			}
		});
		
		$('ul.category-listing li').removeClass('active');
				
		$('ul.category-listing li a[data-category="'+category+'"]').parent('li').addClass("active");
	});
	
	
	$('ul.category-listing > li:first-child a').trigger('click');
});
</script>
