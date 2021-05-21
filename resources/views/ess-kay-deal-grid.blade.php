@if($dealsData)
<div class="deal-product-grid">
	<div class="row">
		@foreach($dealsData as $k => $row)
			@if($category_name != "")
				@if($category_name == $row->category_name)
				<div class="blog-item col-md-4 col-sm-12 post-row-{{ strtolower($row->category_name) }}">
					<div class="deal-product-box @if(($k % 3 == 1)) dpx-green @elseif(($k % 3 == 2)) dpx-yellow @endif">
						<div class="deal-product-category">
							<div class="dpc-cate-text">{{ $row->category_code }}</div>
						</div>
						<div class="deal-product-amount">{{ $row->amount }} Cr(s)</div>
						<div class="deal-product-bank">{{ $row->name }}</div>
						<div class="deal-product-info">
							<ul>
								<li>
									<div class="dpi-info-heading">Rating</div>
									<div class="dpi-info-details">{{ $row->rating }}</div>
								</li>
								<li>
									<div class="dpi-info-heading">Tenor</div>
									<div class="dpi-info-details">{{ $row->tenure }}</div>
								</li>
								<li>
									<div class="dpi-info-heading">Yield</div>
									<div class="dpi-info-details">{{ $row->pricing }}% fixed</div>
								</li>
							</ul>
						</div>
					</div>
				</div>
				@else
				<div class="blog-item col-md-4 col-sm-12 post-row-{{ strtolower($row->category_name) }}">
					<div class="deal-product-box @if(($k % 3 == 1)) dpx-green @elseif(($k % 3 == 2)) dpx-yellow @endif">
						<div class="deal-product-category">
							<div class="dpc-cate-text">{{ $row->category_code }}</div>
						</div>
						<div class="deal-product-amount">{{ $row->amount }} Cr(s)</div>
						<div class="deal-product-bank">{{ $row->name }}</div>
						<div class="deal-product-info">
							<ul>
								<li>
									<div class="dpi-info-heading">Rating</div>
									<div class="dpi-info-details">{{ $row->rating }}</div>
								</li>
								<li>
									<div class="dpi-info-heading">Tenor</div>
									<div class="dpi-info-details">{{ $row->tenure }}</div>
								</li>
								<li>
									<div class="dpi-info-heading">Yield</div>
									<div class="dpi-info-details">{{ $row->pricing }}% fixed</div>
								</li>
							</ul>
						</div>
					</div>
				</div>
				@endif
			@else
				<div class="blog-item col-md-4 col-sm-12 post-row-{{ strtolower($row->category_name) }}">
					<div class="deal-product-box @if(($k % 3 == 1)) dpx-green @elseif(($k % 3 == 2)) dpx-yellow @endif">
						<div class="deal-product-category">
							<div class="dpc-cate-text">{{ $row->category_code }}</div>
						</div>
						<div class="deal-product-amount">{{ $row->amount }} Cr(s)</div>
						<div class="deal-product-bank">{{ $row->name }}</div>
						<div class="deal-product-info">
							<ul>
								<li>
									<div class="dpi-info-heading">Rating</div>
									<div class="dpi-info-details">{{ $row->rating }}</div>
								</li>
								<li>
									<div class="dpi-info-heading">Tenor</div>
									<div class="dpi-info-details">{{ $row->tenure }}</div>
								</li>
								<li>
									<div class="dpi-info-heading">Yield</div>
									<div class="dpi-info-details">{{ $row->pricing }}% fixed</div>
								</li>
							</ul>
						</div>
					</div>
				</div>
			@endif

		@endforeach
	</div>
</div>
@else
<div class="alert alert-danger">No deals available</div>
@endif