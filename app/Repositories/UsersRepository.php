<?php

namespace App\Repositories;

use Lang;
use App\User;
use Illuminate\Support\Facades\Gate;

class UsersRepository extends Repository
{
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function addUser($request)
    {
        if (Gate::denies('create',$this->model))
        {
            abort(403);
        }

        $data = $request->all();

        $user = $this->model->create([
            'name' => $data['name'],
            'login' => $data['login'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        if($user)
        {
            $user->roles()->attach($data['role_id']);
        }

        return ['status' => Lang::get('admin.user_is_added')];
    }

    public function updateUser($request, $user)
    {
        if (Gate::denies('edit', $this->model))
        {
            abort(403);
        }

        $data = $request->all();

        if(isset($data['password']))
        {
            $data['password'] = bcrypt($data['password']);
        }
        else
        {
            unset($data['password']);
            unset($data['password_confirmation']);
        }

        $user->fill($data)->update();
        $user->roles()->sync([$data['role_id']]);

        return ['status' => Lang::get('admin.user_is_updated')];
    }

    public function deleteUser($user) {

        if (Gate::denies('edit',$this->model))
        {
            abort(403);
        }

        $user->roles()->detach();

        if($user->delete())
        {
            return ['status' => Lang::get('admin.user_is_deleted')];
        }
    }


}
