<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Lang;
use App\Repositories\RolesRepository;
use App\Repositories\UsersRepository;
use App\User;

class UserController extends AdminController
{

    protected $user_rep;
    protected $role_rep;

    public function __construct(RolesRepository $role_rep, UsersRepository $user_rep)
    {
        $this->user_rep = $user_rep;
        $this->role_rep = $role_rep;

        $this->template = env('THEME').'.admin.users';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::denies('ADMIN_USERS'))
        {
            abort(403);
        }

        $users = $this->user_rep->get();

        $this->content = view(env('THEME').'.admin.users_content')->with(['users' => $users])->render();

        return $this->renderOutput();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Gate::denies('create', new User))
        {
            abort(403);
        }

        $this->title = Lang::get('admin.new_user');

        $roles = $this->role_rep->get()->reduce(function ($returnRoles, $role)
        {
            $returnRoles[$role->id] = $role->name;
            return $returnRoles;
        }, []);

        //dd($roles);

        $this->content = view(env('THEME').'.admin.users_create_content')->with('roles', $roles)->render();

        return $this->renderOutput();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $result = $this->user_rep->addUser($request);

        if(is_array($result) && !empty($result['error']))
        {
            return back()->with($result);
        }
        return redirect('/admin/users')->with($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Gate::denies('edit', new User))
        {
            abort(403);
        }

        $user = User::where('id', $id)->first();

        if (empty($user))
        {
            abort(404);
        }

        $this->title =  Lang::get('admin.edit_user').' - '. $user->name;

        $roles = $this->role_rep->get()->reduce(function ($returnRoles, $role)
        {
            $returnRoles[$role->id] = $role->name;
            return $returnRoles;
        }, []);

        $this->content = view(env('THEME').'.admin.users_create_content')->with(['roles'=>$roles,'user'=>$user])->render();

        return $this->renderOutput();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $user = User::where('id', $id)->first();

        if (empty($user))
        {
            abort(404);
        }

        $result = $this->user_rep->updateUser($request, $user);

        if(is_array($result) && !empty($result['error']))
        {
            return back()->with($result);
        }

        return redirect('/admin/users')->with($result);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::where('id', $id)->first();

        if (empty($user))
        {
            abort(404);
        }

        $result = $this->user_rep->deleteUser($user);

        if(is_array($result) && !empty($result['error']))
        {
            return back()->with($result);
        }
        return redirect('/admin/users')->with($result);
    }

}
