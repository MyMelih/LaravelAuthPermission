<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        foreach ($this->getDefinedRoles() as $role) {
            Gate::define($role->name, function ($user) use ($role) {
                $roles = DB::table('role_user')
                    ->join('roles', 'role_user.role_id', '=', 'roles.id')
                    ->where('role_user.user_id', $user->id)
                    ->where('roles.name', $role->name)
                    ->first();

                if ($roles) {
                    return true;
                }
                return false;
            });
        }
    }

    protected function getDefinedRoles()
    {
        $roles = DB::table('roles')->get();
        return $roles;
    }
}
