<div id="content-page" class="content group">
    <div class="hentry group">
        <h3 class="title_page">{{ Lang::get('admin.admin_menu_items_users') }}</h3>
        <div class="short-table white">
            <table style="width: 100%" cellspacing="0" cellpadding="0">
                <thead>
                <th>ID</th>
                <th>{{ Lang::get('admin.name') }}</th>
                <th>Email</th>
                <th>{{ Lang::get('admin.login') }}</th>
                <th>{{ Lang::get('admin.role') }}</th>
                <th>{{ Lang::get('admin.delete') }}</th>
                </thead>
                @if($users)

                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{!! Html::link(route('users.edit',['users' => $user->id]),$user->name) !!}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->login }}</td>
                            <td>{{ $user->roles->implode('name', ', ') }}</td>


                            <td>
                                {!! Form::open(['url' => route('users.destroy',['users'=> $user->id]),'class'=>'form-horizontal','method'=>'POST']) !!}
                                {{ method_field('DELETE') }}
                                {!! Form::button(Lang::get('admin.delete'), ['class' => 'btn btn-french-5','type'=>'submit']) !!}
                                {!! Form::close() !!}

                            </td>
                        </tr>
                    @endforeach

                @endif
            </table>
        </div>
        {!! Html::link(route('users.create'), Lang::get('admin.add_user_button'),['class' => 'btn btn-the-salmon-dance-3']) !!}

    </div>
</div>