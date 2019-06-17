<div id="content-page" class="content group">
    <div class="hentry group">

        {!! Form::open(['url' => (isset($article->id)) ? route('articles.update',['articles'=>$article->alias]) : route('articles.store'),'class'=>'contact-form','method'=>'POST','enctype'=>'multipart/form-data']) !!}

            <ul>
                <li class="text-field">
                    <label for="name-contact-us">
                        <span class="label">{{ Lang::get('admin.name') }}:</span>
                        <br />
                        <span class="sublabel">{{ Lang::get('admin.title') }}</span><br />
                    </label>
                    <div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span>
                        {!! Form::text('title',isset($article->title) ? $article->title  : old('title'), ['placeholder'=>Lang::get('admin.enter_page_name')]) !!}
                    </div>
                </li>

                <li class="text-field">
                    <label for="name-contact-us">
                        <span class="label">{{ Lang::get('admin.keywords') }}:</span>
                        <br />
                        <span class="sublabel">{{ Lang::get('admin.title') }}</span><br />
                    </label>
                    <div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span>
                        {!! Form::text('keywords', isset($article->keywords) ? $article->keywords  : old('keywords'), ['placeholder'=>Lang::get('admin.enter_page_name')]) !!}
                    </div>
                </li>

                <li class="text-field">
                    <label for="name-contact-us">
                        <span class="label">{{ Lang::get('admin.meta_description') }}:</span>
                        <br />
                        <span class="sublabel">{{ Lang::get('admin.title') }}</span><br />
                    </label>
                    <div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span>
                        {!! Form::text('meta_desc', isset($article->meta_desc) ? $article->meta_desc  : old('meta_desc'), ['placeholder'=>Lang::get('admin.enter_page_name')]) !!}
                    </div>
                </li>

                <li class="text-field">
                    <label for="name-contact-us">
                        <span class="label">{{ Lang::get('admin.alias') }}:</span>
                        <br />
                        <span class="sublabel">{{ Lang::get('admin.enter_alias') }}</span><br />
                    </label>
                    <div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span>
                        {!! Form::text('alias', isset($article->alias) ? $article->alias  : old('alias'), ['placeholder'=>Lang::get('admin.enter_alias_page')]) !!}
                    </div>
                </li>

                <li class="textarea-field">
                    <label for="message-contact-us">
                        <span class="label">{{ Lang::get('admin.description') }}:</span>
                    </label>
                    <div class="input-prepend"><span class="add-on"><i class="icon-pencil"></i></span>
                        {!! Form::textarea('desc', isset($article->desc) ? $article->desc  : old('desc'), ['id'=>'editor','class' => 'form-control','placeholder'=>Lang::get('admin.enter_page_description')]) !!}
                    </div>
                    <div class="msg-error"></div>
                </li>

                <li class="textarea-field">
                    <label for="message-contact-us">
                        <span class="label">{{ Lang::get('admin.text') }}:</span>
                    </label>
                    <div class="input-prepend"><span class="add-on"><i class="icon-pencil"></i></span>
                        {!! Form::textarea('text', isset($article->text) ? $article->text  : old('text'), ['id'=>'editor2','class' => 'form-control','placeholder'=>Lang::get('admin.enter_page_text')]) !!}
                    </div>
                    <div class="msg-error"></div>
                </li>

                @if(isset($article->img->path))
                    <li class="textarea-field">

                        <label>
                            <span class="label">{{ Lang::get('admin.image') }}:</span>
                        </label>

                        {{ Html::image(asset(env('THEME')).'/images/articles/'.$article->img->path,'',['style'=>'width:400px']) }}
                        {!! Form::hidden('old_image',$article->img->path) !!}

                    </li>
                @endif


                <li class="text-field">
                    <label for="name-contact-us">
                        <span class="label">{{ Lang::get('admin.image') }}:</span>
                        <br />
                        <span class="sublabel">{{ Lang::get('admin.image') }}</span><br />
                    </label>
                    <div class="input-prepend">
                        {!! Form::file('image', ['class' => 'filestyle','data-buttonText'=>'Выберите изображение','data-buttonName'=>"btn-primary",'data-placeholder'=>Lang::get('admin.file_not_exists')]) !!}
                    </div>

                </li>

                <li class="text-field">
                    <label for="name-contact-us">
                        <span class="label">{{ Lang::get('admin.category') }}:</span>
                        <br />
                        <span class="sublabel">{{ Lang::get('admin.category') }}</span><br />
                    </label>
                    <div class="input-prepend">
                        {!! Form::select('category_id', $categories,isset($article->category_id) ? $article->category_id  : '') !!}
                    </div>

                </li>

                @if(isset($article->id))
                    <input type="hidden" name="_method" value="PUT">

                @endif

                <li class="submit-button">
                    {!! Form::button(Lang::get('admin.save'), ['class' => 'btn btn-the-salmon-dance-3','type'=>'submit']) !!}
                </li>

            </ul>

        {!! Form::close() !!}

        <script>
            CKEDITOR.replace( 'editor' );
            CKEDITOR.replace( 'editor2' );
        </script>
    </div>
</div>