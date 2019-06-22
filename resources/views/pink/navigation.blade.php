@if($menu)
	<div class="menu classic">
		<ul id="nav" class="menu">
			@include(config('settings.theme').'.custom_menu_items',['items'=>$menu->roots()])
		</ul>
	</div>
@endif
