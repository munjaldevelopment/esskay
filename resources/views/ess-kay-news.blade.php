<div class="outer-bg">
	<div class="container-fluid inner-bg">
		<div class="row">
			<div class="col-md-9 ">
				<div class="wpb_wrapper"><div class="rs-blog "><div class="row">
					@foreach($articleData as $k => $article)
					<div class="blog-item col-md-4 col-sm-12 col-xs-12 {{ $article['category_name'] }}">
						<div class="blog-content-main">
							<div class="blog-img"> 
								<a href="javascript:;" data-toggle="modal" data-target="#exampleModal{{ $article['id'] }}"><img src="{{ asset('public/') }}/{{ $article['image'] }}" class="img-fluid" alt="{{ $article['title'] }}"></a>
								@if($article['category_id'] != "")
								<div class="cat_name hide d-none"> {{ $article['category_id'] }} </div>
								@endif
								
								<!--<div class="blog-img-content"><div class="display-table"><div class="display-table-cell"> <a class="blog-link" href="javascript:;" data-toggle="modal" data-target="#exampleModal{{ $article['id'] }}" title="{{ $article['title'] }}"> <i class="fa fa-link"></i> </a></div></div></div>-->
							</div>
							
							<div class="blog-meta"><h3 class="blog-title"><a href="javascript:;" data-toggle="modal" data-target="#exampleModal{{ $article['id'] }}"> {{ $article['title'] }} </a></h3><div class="blog-date"> <i class="fa fa-calendar"></i> {!! date('F d, Y', strtotime($article['date'])) !!} <span class="author">  @if($article['article_pdf'] != NULL)<a href="{{ asset('/') }}downloadFile/{{ $article['id'] }}" target="_blank" class="doc-download001" data-document="{{$article['id']}}"><i class="fa fa-download" aria-hidden="true"></i></a>@endif </span></div><div class="blog-lc"></div></div>
							
							<div class="blog-desc"> {!! $article['short_description'] !!} </div>
						</div>
					</div>
				
					<!-- Modal -->
					<div class="modal fade" id="exampleModal{{ $article['id'] }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
						<div class="modal-dialog modal-notify modal-info modal-dialog-centered" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<p class="heading lead modal-title">{{ $article['title'] }}</p>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true" class="white-text">&times;</span>
									</button>
								</div>
								<div class="modal-body" style="background: #f3fbfd;">
									<div class="row">		
										<div class="col-md-12 text-center">
											<img src="{{ asset('public/') }}/{{ $article['image'] }}" class="img-fluid blog-img" alt="{{ $article['title'] }}">
										</div>
									</div>
									<hr />
									<div class="row">										
										<div class="col-md-12">
											<h6>Short Description:</h6>
											<div class="blog-short-desc">{!! $article['short_description_full'] !!} </div>
											<hr />
											<h6>Description:</h6>
											<div class="blog-desc1">{!! $article['content'] !!} </div>
											<div class="blog-desc" style="font-size:10px;text-align:right;"><i class="fa fa-calendar"></i> {!! date('F d, Y', strtotime($article['date'])) !!}</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				@endforeach
				
			</div></div></div></div>



			<div class="col-md-3">
				<aside id="secondary" class="widget-area inner-bg1">
					<div class="bs-sidebar dynamic-sidebar">
						<section id="categories-2" class="widget widget_categories loaded">
							<h2 class="widget-title">Categories</h2>
						
							<ul>
								@foreach($categoriesData as $k => $category)
								<li class="cat-item cat-item-206"><a href="javascript:;" class="category-link category-{{ $category['name'] }}"  onclick="showCategoryData('{{ $category['name'] }}, {{ strtolower($category['name1']) }}');">{{ $category['name'] }} ({{ $category['count'] }})</a></li>
								@endforeach
							</ul>
							
							<div class="pull-right"><a href="javascript:;" class="btn btn-info" onclick="clearAll();">Clear</a></div>
						</section>
					</div>
				</aside>
			</div>
		</div>
	</div>
</div>

<script src="{{ asset('public/assets/') }}/js/jquery.min.js"></script>
<script src="{{ asset('public/assets/') }}/js/bootstrap.min.js"></script>
	
<style>
	.carousel-inner>.item>a>img,.carousel-inner>.item>img,.img-responsive {display:block;max-width:100%;height:auto}
	
	.carousel-inner{position:relative;width:100%;overflow:hidden}.carousel-inner>.item{position:relative;display:none;-webkit-transition:.6s ease-in-out left;-o-transition:.6s ease-in-out left;transition:.6s ease-in-out left}.carousel-inner>.item>a>img,.carousel-inner>.item>img{line-height:1}@media all and (transform-3d),(-webkit-transform-3d){.carousel-inner>.item{-webkit-transition:-webkit-transform .6s ease-in-out;-o-transition:-o-transform .6s ease-in-out;transition:transform .6s ease-in-out;-webkit-backface-visibility:hidden;backface-visibility:hidden;-webkit-perspective:1000px;perspective:1000px}.carousel-inner>.item.active.right,.carousel-inner>.item.next{left:0;-webkit-transform:translate3d(100%,0,0);transform:translate3d(100%,0,0)}.carousel-inner>.item.active.left,.carousel-inner>.item.prev{left:0;-webkit-transform:translate3d(-100%,0,0);transform:translate3d(-100%,0,0)}.carousel-inner>.item.active,.carousel-inner>.item.next.left,.carousel-inner>.item.prev.right{left:0;-webkit-transform:translate3d(0,0,0);transform:translate3d(0,0,0)}}.carousel-inner>.active,.carousel-inner>.next,.carousel-inner>.prev{display:block}.carousel-inner>.active{left:0}.carousel-inner>.next,.carousel-inner>.prev{position:absolute;top:0;width:100%}.carousel-inner>.next{left:100%}.carousel-inner>.prev{left:-100%}.carousel-inner>.next.left,.carousel-inner>.prev.right{left:0}.carousel-inner>.active.left{left:-100%}.carousel-inner>.active.right{left:100%}
	
	.carousel-control{position:absolute;top:0;bottom:0;left:0;width:15%;font-size:20px;color:#fff;text-align:center;text-shadow:0 1px 2px rgba(0,0,0,.6);background-color:rgba(0,0,0,0);filter:alpha(opacity=50);opacity:.5}.carousel-control.left{background-image:-webkit-linear-gradient(left,rgba(0,0,0,.5) 0,rgba(0,0,0,.0001) 100%);background-image:-o-linear-gradient(left,rgba(0,0,0,.5) 0,rgba(0,0,0,.0001) 100%);background-image:-webkit-gradient(linear,left top,right top,from(rgba(0,0,0,.5)),to(rgba(0,0,0,.0001)));background-image:linear-gradient(to right,rgba(0,0,0,.5) 0,rgba(0,0,0,.0001) 100%);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#80000000', endColorstr='#00000000', GradientType=1);background-repeat:repeat-x}.carousel-control.right{right:0;left:auto;background-image:-webkit-linear-gradient(left,rgba(0,0,0,.0001) 0,rgba(0,0,0,.5) 100%);background-image:-o-linear-gradient(left,rgba(0,0,0,.0001) 0,rgba(0,0,0,.5) 100%);background-image:-webkit-gradient(linear,left top,right top,from(rgba(0,0,0,.0001)),to(rgba(0,0,0,.5)));background-image:linear-gradient(to right,rgba(0,0,0,.0001) 0,rgba(0,0,0,.5) 100%);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#00000000', endColorstr='#80000000', GradientType=1);background-repeat:repeat-x}.carousel-control:focus,.carousel-control:hover{color:#fff;text-decoration:none;filter:alpha(opacity=90);outline:0;opacity:.9}.carousel-control .glyphicon-chevron-left,.carousel-control .glyphicon-chevron-right,.carousel-control .icon-next,.carousel-control .icon-prev{position:absolute;top:50%;z-index:5;display:inline-block;margin-top:-10px}.carousel-control .glyphicon-chevron-left,.carousel-control .icon-prev{left:50%;margin-left:-10px}.carousel-control .glyphicon-chevron-right,.carousel-control .icon-next{right:50%;margin-right:-10px}.carousel-control .icon-next,.carousel-control .icon-prev{width:20px;height:20px;font-family:serif;line-height:1}.carousel-control .icon-prev:before{content:'\2039'}.carousel-control .icon-next:before{content:'\203a'}.carousel-indicators{position:absolute;bottom:10px;left:50%;z-index:15;width:60%;padding-left:0;margin-left:-30%;text-align:center;list-style:none}.carousel-indicators li{display:inline-block;width:10px;height:10px;margin:1px;text-indent:-999px;cursor:pointer;background-color:#000\9;background-color:rgba(0,0,0,0);border:1px solid #fff;border-radius:10px}.carousel-indicators .active{width:12px;height:12px;margin:0;background-color:#fff}.carousel-caption{position:absolute;right:15%;bottom:20px;left:15%;z-index:10;padding-top:20px;padding-bottom:20px;color:#fff;text-align:center;text-shadow:0 1px 2px rgba(0,0,0,.6)}.carousel-caption .btn{text-shadow:none}@media screen and (min-width:768px){.carousel-control .glyphicon-chevron-left,.carousel-control .glyphicon-chevron-right,.carousel-control .icon-next,.carousel-control .icon-prev{width:30px;height:30px;margin-top:-10px;font-size:30px}.carousel-control .glyphicon-chevron-left,.carousel-control .icon-prev{margin-left:-10px}.carousel-control .glyphicon-chevron-right,.carousel-control .icon-next{margin-right:-10px}.carousel-caption{right:20%;left:20%;padding-bottom:30px}.carousel-indicators{bottom:20px}}
	
	.carousel-control .glyphicon-chevron-left, .carousel-control .glyphicon-chevron-right, .carousel-control .icon-next, .carousel-control .icon-prev {
		position: absolute;
		top: 50%;
		z-index: 5;
		display: inline-block;
		margin-top: -10px;
	}
	
	.img-fluid.blog-img {
		max-width: 50%;
	}
	
	.modal {
		padding-right: 0 !important;
		z-index: 9999;
		background: rgba(255,255,255,0.6);
	}
	
	.modal-dialog.modal-notify.modal-info .modal-header {
		background-color: #33b5e5;
	}
	
	.modal-dialog.modal-notify .heading {
		padding: .3rem;
		margin: 0;
		font-size: 1.15rem;
		color: #fff;
	}
	
	.white-text {
		color: #fff !important;
	}
	

	button.close {
		position: unset;
		float: right;
		font-size: 1.5rem;
		font-weight: 700;
		line-height: 1;
		color: #000;
		text-shadow: 0 1px 0 #fff;
		opacity: .5;
	}
	
	/*.bs-sidebar .widget {
		margin-bottom: 5px;
	}*/
</style>

<script>
	$(document).ready(function() {
		$('.carousel').carousel();
	});
	
	function clearAll()
	{
		$('.blog-item').show();
	}

	function showCategoryData(cate_name1, cat_name)
	{
		$('.category-link').removeClass('active');
		$('.blog-item').hide();
		
		//alert(cat_name);
		
		$('.category-link'+cate_name1).Class('active');

		if($('.blog-item').hasClass('post-row-'+cat_name))
		{
			$('.post-row-'+cat_name).show();
		}
	}
</script>