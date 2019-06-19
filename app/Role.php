<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    public function users()
    {
        return $this->belongsToMany('App\User','role_user');
    }

    public function perms()
    {
        return $this->belongsToMany('App\Permission','permission_role');
    }

    public function hasPermission($name, $require = FALSE)
    {
        if (is_array($name))
        {
            foreach ($name as $permissionName)
            {
                $hasPermission = $this->hasPermission($permissionName);

                if ($hasPermission && !$require)
                {
                    return TRUE;
                }
                elseif (!$hasPermission && $require)
                {
                    return FALSE;
                }
            }
            return $require;
        }
        else
        {
            foreach ($this->perms as $permission)
            {
                if ($permission->name == $name)
                {
                    return TRUE;
                }
            }
        }

        return FALSE;
    }

    public function savePermission($inputPermissions)
    {
        if(!empty($inputPermissions))
        {
            $this->perms()->sync($inputPermissions);
        }
        else
        {
            $this->perms()->detach();
        }

        return TRUE;
    }

}
