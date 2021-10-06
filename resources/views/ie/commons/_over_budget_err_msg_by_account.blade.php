<ul class="list-unstyled alert alert-warning alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    @foreach($arrErrLines as $errLine)
		<li class="m-b-xs">
			{{ '- ' }}
			@foreach($errLine['category_icon'] as $key => $categoryIcon)
				@if($key > 0) {{ ', ' }} @endif
				<i class="fa {{ $categoryIcon }}"></i> 
				{{ ' : ' . $errLine['sub_category_name'][$key] }}
			@endforeach
			{{ ' ('.$errLine['concatenated_segments'].')'}} 
			{{ ' is over budget '. number_format($errLine['over_amount'],2) .' '.$baseCurrencyId }}
			{{ ' (Total : '.number_format($errLine['total_amount'],2) .' | Available : '.number_format($errLine['amount_available'],2) .') ' }}
		</li>
    @endforeach
</ul>
