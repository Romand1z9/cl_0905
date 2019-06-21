<div id="content-page" class="content group">
    <div class="hentry group">

        {!! Form::open(['url' => (isset($menu->id)) ? route('menus.update',['menus'=>$menu->id]) : route('menus.store'),'class'=>'contact-form','method'=>'POST','enctype'=>'multipart/form-data']) !!}

        <ul>

            <li class="text-field">
                <label for="name-contact-us">
                    <span class="label">{{ Lang::get('admin.menu_element_title') }}:</span>
                    <br />
                    <span class="sublabel">{{ Lang::get('admin.menu_element_title') }}</span><br />
                </label>
                <div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span>
                    {!! Form::text('title',isset($menu->title) ? $menu->title  : old('title'), ['placeholder' => Lang::get('admin.enter_page_name')]) !!}
                </div>
            </li>

            <li class="text-field">
                <label for="name-contact-us">
                    <span class="label">{{ Lang::get('admin.parent_menu_item') }}:</span>
                    <br />
                    <span class="sublabel">{{ Lang::get('admin.parent_menu_item') }}:</span><br />
                </label>
                <div class="input-prepend">
                    {!! Form::select('parent', $menus, isset($menu->parent) ? $menu->parent : null) !!}
                </div>

            </li>

        </ul>

        <h1>{{ Lang::get('admin.menu_type') }}:</h1>

        <div id="accordion">

            <h3>{!! Form::radio('type', 'customLink',(isset($type) && $type == 'customLink') ? TRUE : FALSE,['class' => 'radioMenu']) !!}
                <span class="label">{{ Lang::get('admin.menu_user_link') }}:</span></h3>

            <ul>

                <li class="text-field">
                    <label for="name-contact-us">
                        <span class="label">{{ Lang::get('admin.link_path') }}:</span>
                        <br />
                        <span class="sublabel">{{ Lang::get('admin.link_path') }}</span><br />
                    </label>
                    <div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span>
                        {!! Form::text('custom_link',(isset($menu->path) && $type=='customLink') ? $menu->path  : old('custom_link'), ['placeholder' => Lang::get('admin.enter_page_name')]) !!}
                    </div>
                </li>
                <div style="clear: both;"></div>
            </ul>


            <h3>{!! Form::radio('type', 'blogLink',(isset($type) && $type == 'blogLink') ? TRUE : FALSE,['class' => 'radioMenu']) !!}
                <span class="label">{{ Lang::get('admin.section') }} {{ Lang::get('blog.title') }}:</span></h3>

            <ul>

                <li class="text-field">
                    <label for="name-contact-us">
                        <span class="label">Ссылка на категорию блога:</span>
                        <br />
                        <span class="sublabel">Ссылка на категорию блога</span><br />
                    </label>
                    <div class="input-prepend">

                        @if($categories)
                            {!! Form::select('category_alias',$categories,(isset($option) && $option) ? $option :FALSE) !!}
                        @endif
                    </div>
                </li>


                <li class="text-field">
                    <label for="name-contact-us">
                        <span class="label">Ссылка на материал блога:</span>
                        <br />
                        <span class="sublabel">Ссылка на материал блога</span><br />
                    </label>
                    <div class="input-prepend">
                        {!! Form::select('article_alias', $articles, (isset($option) && $option) ? $option :FALSE, ['placeholder' => Lang::get('admin.not_used')]) !!}

                    </div>

                </li>
                <div style="clear: both;"></div>
            </ul>



            <h3>{!! Form::radio('type', 'portfolioLink',(isset($type) && $type == 'portfolioLink') ? TRUE : FALSE,['class' => 'radioMenu']) !!}
                <span class="label">{{ Lang::get('admin.section') }} {{ Lang::get('portfolios.title') }}:</span></h3>

            <ul>

                <li class="text-field">
                    <label for="name-contact-us">
                        <span class="label">Ссылка на запись портфолио:</span>
                        <br />
                        <span class="sublabel">Ссылка на запись портфолио</span><br />
                    </label>
                    <div class="input-prepend">
                        {!! Form::select('portfolio_alias', $portfolios, (isset($option) && $option) ? $option :FALSE, ['placeholder' => Lang::get('admin.not_used')]) !!}

                    </div>

                </li>

                <li class="text-field">
                    <label for="name-contact-us">
                        <span class="label">Портфолио:</span>
                        <br />
                        <span class="sublabel">Портфолио</span><br />
                    </label>
                    <div class="input-prepend">
                        {!! Form::select('filter_alias', $filters, (isset($option) && $option) ? $option :FALSE, ['placeholder' => Lang::get('admin.not_used')]) !!}

                    </div>

                </li>

            </ul>

        </div>

        <br />

        @if(isset($menu->id))
            <input type="hidden" name="_method" value="PUT">
        @endif

        <ul>
            <li class="submit-button">
                {!! Form::button(Lang::get('admin.save'), ['class' => 'btn btn-the-salmon-dance-3','type'=>'submit']) !!}
            </li>
        </ul>

        {!! Form::close() !!}

    </div>
</div>

<script type="text/javascript">

    jQuery(function($) {

        $('#accordion').accordion({
            activate: function(e, obj) {
                obj.newPanel.prev().find('input[type=radio]').attr('checked','checked');
            }
        });

        var active = 0;
        $('#accordion input[type=radio]').each(function(ind,it) {
            if($(this).prop('checked')) {
                active = ind;
            }

        });

        $('#accordion').accordion('option','active', active);
        if(active == 0)
        {
            $('input[value=customLink]').attr('checked', 'checked');
        }

    });

</script>