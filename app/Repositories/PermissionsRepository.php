<?php

namespace App\Repositories;

use App\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Lang;

class PermissionsRepository extends Repository
{
    public function __construct(Permission $permission, RolesRepository $roles)
    {
        $this->model = $permission;
        $this->r_rep = $roles;
    }

    public function changePermissions($request)
    {
        if (Gate::denies('change', $this->model))
        {
            abort(403);
        }

        $data = $request->except('_token');

        $roles = $this->r_rep->get();

        foreach($roles as $value)
        {
            $data_save = isset($data[$value->id]) ? $data[$value->id] : [];
            $value->savePermission($data_save);
        }

        return ['status' => Lang::get('admin.permissions_settings_are_updated')];

    }

}
