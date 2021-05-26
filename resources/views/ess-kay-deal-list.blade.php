
<div class="deal-product-list">
	<div class="deal-list-table">	
		<div class="custom-table-area">
			<div class="table-responsive">
				<table class="table">
					<thead>
					  <tr>
						<th>Name</th>
						<th>Product</th>
						<th>Rating</th>
						<th>Amount</th>
						<th>Pricing</th>
						<th>TENOR</th>
					  </tr>
					</thead>
					<tbody>
						@foreach($dealsData as $k => $row)
							@if($category_name != "")
								@if($category_name == $row->category_name)
								<tr class="blog-item post-row-{{ strtolower($row->category_name) }}">
									<td>
									<a href="">
									<div class="deal-list-info">  
									<div class="deal-list-bank">{{ $row->name }}</div>
									<div class="deal-list-created">Created at: {{ $row->created_at }}</div>
									</div>
									</a>
									</td>
									<td><a href=""><div class="dpc-cate-text">{{ $row->category_code }}</div></a></td>
									<td><a href="">{{ $row->rating }}</a></td>  
									<td><a href="">{{ $row->amount }} CRORES</a></td>  
									<td><a href="">{{ $row->pricing }}% Fixed</a></td>  
									<td><a href="">{{ $row->tenure }}</a></td>  
								</tr>
								@endif
							@else
							<tr class="blog-item post-row-{{ strtolower($row->category_name) }}">
								<td>
								<a href="">
								<div class="deal-list-info">  
								<div class="deal-list-bank">{{ $row->name }}</div>
								<div class="deal-list-created">Created at: {{ $row->created_at }}</div>
								</div>
								</a>
								</td>
								<td><a href=""><div class="dpc-cate-text">{{ $row->category_code }}</div></a></td>
								<td><a href="">{{ $row->rating }}</a></td>  
								<td><a href="">{{ $row->amount }} CRORES</a></td>  
								<td><a href="">{{ $row->pricing }}% Fixed</a></td>  
								<td><a href="">{{ $row->tenure }}</a></td>  
							</tr>
							@endif
						@endforeach
					</tbody>
			  	</table>	
			</div>	
		</div>
	</div>
</div>