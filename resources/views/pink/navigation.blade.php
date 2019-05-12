@if($menu)
	<div class="menu classic">
		<ul id="nav" class="menu">
			@include(env('THEME').'.custom_menu_items',['items'=>$menu->roots()])
		</ul>
	</div>
@endif
