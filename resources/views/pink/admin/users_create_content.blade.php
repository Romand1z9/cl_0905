<div id="content-page" class="content group">
    <div class="hentry group">

        {!! Form::open(['url' => (isset($user->id)) ? route('users.update',['users'=>$user->id]) : route('users.store'),'class'=>'contact-form','method'=>'POST','enctype'=>'multipart/form-data']) !!}

        <ul>
            <li class="text-field">
                <label for="name-contact-us">
                    <span class="label">{{ Lang::get('admin.name') }}:</span>
                    <br />
                    <span class="sublabel">{{ Lang::get('admin.name') }}</span><br />
                </label>
                <div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span>
                    {!! Form::text('name',isset($user->name) ? $user->name  : old('name'), ['placeholder' => Lang::get('admin.enter_page_name')]) !!}
                </div>
            </li>

            <li class="text-field">
                <label for="name-contact-us">
                    <span class="label">{{ Lang::get('admin.login') }}:</span>
                    <br />
                    <span class="sublabel">{{ Lang::get('admin.login') }}</span><br />
                </label>
                <div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span>
                    {!! Form::text('login',isset($user->login) ? $user->login  : old('login'), ['placeholder' => Lang::get('admin.enter_page_name')]) !!}
                </div>
            </li>

            <li class="text-field">
                <label for="name-contact-us">
                    <span class="label">Email:</span>
                    <br />
                    <span class="sublabel">Email</span><br />
                </label>
                <div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span>
                    {!! Form::text('email',isset($user->email) ? $user->email  : old('email'), ['placeholder' => Lang::get('admin.enter_page_name')]) !!}
                </div>
            </li>

            <li class="text-field">
                <label for="name-contact-us">
                    <span class="label">{{ Lang::get('admin.password') }}:</span>
                    <br />
                    <span class="sublabel">{{ Lang::get('admin.password') }}</span><br />
                </label>
                <div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span>
                    {!! Form::password('password') !!}
                </div>
            </li>

            <li class="text-field">
                <label for="name-contact-us">
                    <span class="label">{{ Lang::get('admin.confirm_password') }}:</span>
                    <br />
                    <span class="sublabel">{{ Lang::get('admin.confirm_password') }}</span><br />
                </label>
                <div class="input-prepend"><span class="add-on"><i class="icon-user"></i></span>
                    {!! Form::password('password_confirmation') !!}
                </div>
            </li>

            <li class="text-field">
                <label for="name-contact-us">
                    <span class="label">{{ Lang::get('admin.role') }}:</span>
                    <br />
                    <span class="sublabel">{{ Lang::get('admin.role') }}</span><br />
                </label>
                <div class="input-prepend">

                    {!! Form::select('role_id', $roles, (isset($user)) ? $user->roles()->first()->id : null) !!}
                </div>

            </li>

            @if(isset($user->id))
                <input type="hidden" name="_method" value="PUT">

            @endif

            <li class="submit-button">
                {!! Form::button(Lang::get('admin.save'), ['class' => 'btn btn-the-salmon-dance-3','type'=>'submit']) !!}
            </li>

        </ul>

        {!! Form::close() !!}

    </div>
</div>