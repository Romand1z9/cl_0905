<?php

namespace App\Providers;

use App\Article;
use App\Permission;
use App\Policies\ArticlePolicy;
use App\Policies\PermissionPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        //'App\Model' => 'App\Policies\ModelPolicy',
        Article::class => ArticlePolicy::class,
        Permission::class => PermissionPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        $gate->define('VIEW_ADMIN', function ($user)
        {
            return $user->canDo('VIEW_ADMIN', FALSE);
        });

        $gate->define('VIEW_ADMIN_ARTICLES', function ($user)
        {
            return $user->canDo('VIEW_ADMIN_ARTICLES', FALSE);
        });

        $gate->define('ADMIN_USERS', function ($user)
        {
            return $user->canDo('ADMIN_USERS', FALSE);
        });

        $gate->define('VIEW_ADMIN_MENU', function ($user)
        {
            return $user->canDo('VIEW_ADMIN_MENU', FALSE);
        });

        $gate->define('EDIT_MENU', function ($user)
        {
            return $user->canDo('EDIT_MENU', FALSE);
        });

        //
    }
}
