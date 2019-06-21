<div id="content-page" class="content group">
    <div class="hentry group">
        <h3 class="title_page">{{ Lang::get('admin.manager_menu') }}</h3>
        <div class="short-table white">
            <table style="width: 100%" cellspacing="0" cellpadding="0">
                <thead>

                <th>{{ Lang::get('admin.menu_element_title') }}</th>
                <th>{{ Lang::get('admin.menu_element_link') }}</th>

                <th>{{ Lang::get('admin.menu_element_delete') }}</th>
                </thead>
                @if($menus)

                    @include(env('THEME').'.admin.custom-menu-items', array('items' => $menus->roots(),'paddingLeft' => ''))


                @endif
            </table>
        </div>
        {!! HTML::link(route('menus.create'), Lang::get('admin.menu_element_add_button'),['class' => 'btn btn-the-salmon-dance-3']) !!}

    </div>
</div>

<script type="text/javascript">

    jQuery(function($) {
        $(".delete_menu_item").on("click", function () {
           var confirm_delete = confirm("{{ Lang::get('admin.confirm_delete') }}?");

           if (!confirm_delete)
           {
               return false;
           }


        });
    });

</script>