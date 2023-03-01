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

        Gate::define('admin-only', function ($user) {
            if ($user->isAdmin == 1) {
                return true;
            }
            return false;
        });

        Gate::define('excel-yukle', function ($user) {
            $roles = DB::table('role_user')
                ->join('roles', 'role_user.role_id', '=', 'roles.id')
                ->where('role_user.user_id', $user->id)
                ->where('roles.name', 'excel-yukle')
                ->first();

            if ($roles) {
                return true;
            }
            return false;
        });


        Gate::define('excel-indir', function ($user) {
            $roles = DB::table('role_user')
                ->join('roles', 'role_user.role_id', '=', 'roles.id')
                ->where('role_user.user_id', $user->id)
                ->where('roles.name', 'excel-indir')
                ->first();

            if ($roles) {
                return true;
            }
            return false;
        });

        Gate::define('firma-ekle', function ($user) {
            $roles = DB::table('role_user')
                ->join('roles', 'role_user.role_id', '=', 'roles.id')
                ->where('role_user.user_id', $user->id)
                ->where('roles.name', 'firma-ekle')
                ->first();

            if ($roles) {
                return true;
            }
            return false;
        });

        Gate::define('firma-listele', function ($user) {
            $roles = DB::table('role_user')
                ->join('roles', 'role_user.role_id', '=', 'roles.id')
                ->where('role_user.user_id', $user->id)
                ->where('roles.name', 'firma-listele')
                ->first();

            if ($roles) {
                return true;
            }
            return false;
        });

        Gate::define('firma-detay', function ($user) {
            $roles = DB::table('role_user')
                ->join('roles', 'role_user.role_id', '=', 'roles.id')
                ->where('role_user.user_id', $user->id)
                ->where('roles.name', 'firma-detay')
                ->first();

            if ($roles) {
                return true;
            }
            return false;
        });

        Gate::define('firma-guncelle', function ($user) {
            $roles = DB::table('role_user')
                ->join('roles', 'role_user.role_id', '=', 'roles.id')
                ->where('role_user.user_id', $user->id)
                ->where('roles.name', 'firma-guncelle')
                ->first();

            if ($roles) {
                return true;
            }
            return false;
        });

        Gate::define('firma-sil', function ($user) {
            $roles = DB::table('role_user')
                ->join('roles', 'role_user.role_id', '=', 'roles.id')
                ->where('role_user.user_id', $user->id)
                ->where('roles.name', 'firma-sil')
                ->first();

            if ($roles) {
                return true;
            }
            return false;
        });

        Gate::define('user-listele', function ($user) {
            $roles = DB::table('role_user')
                ->join('roles', 'role_user.role_id', '=', 'roles.id')
                ->where('role_user.user_id', $user->id)
                ->where('roles.name', 'user-listele')
                ->first();

            if ($roles) {
                return true;
            }
            return false;
        });

        Gate::define('user-detay', function ($user) {
            $roles = DB::table('role_user')
                ->join('roles', 'role_user.role_id', '=', 'roles.id')
                ->where('role_user.user_id', $user->id)
                ->where('roles.name', 'user-detay')
                ->first();

            if ($roles) {
                return true;
            }
            return false;
        });

        Gate::define('user-guncelle', function ($user) {
            $roles = DB::table('role_user')
                ->join('roles', 'role_user.role_id', '=', 'roles.id')
                ->where('role_user.user_id', $user->id)
                ->where('roles.name', 'user-guncelle')
                ->first();

            if ($roles) {
                return true;
            }
            return false;
        });

        Gate::define('user-sil', function ($user) {
            $roles = DB::table('role_user')
                ->join('roles', 'role_user.role_id', '=', 'roles.id')
                ->where('role_user.user_id', $user->id)
                ->where('roles.name', 'user-sil')
                ->first();

            if ($roles) {
                return true;
            }
            return false;
        });

        Gate::define('roles-ekle', function ($user) {
            $roles = DB::table('role_user')
                ->join('roles', 'role_user.role_id', '=', 'roles.id')
                ->where('role_user.user_id', $user->id)
                ->where('roles.name', 'roles-ekle')
                ->first();

            if ($roles) {
                return true;
            }
            return false;
        });

        Gate::define('roles-listele', function ($user) {
            $roles = DB::table('role_user')
                ->join('roles', 'role_user.role_id', '=', 'roles.id')
                ->where('role_user.user_id', $user->id)
                ->where('roles.name', 'roles-listele')
                ->first();

            if ($roles) {
                return true;
            }
            return false;
        });

        Gate::define('roles-detay', function ($user) {
            $roles = DB::table('role_user')
                ->join('roles', 'role_user.role_id', '=', 'roles.id')
                ->where('role_user.user_id', $user->id)
                ->where('roles.name', 'roles-detay')
                ->first();

            if ($roles) {
                return true;
            }
            return false;
        });

        Gate::define('roles-guncelle', function ($user) {
            $roles = DB::table('role_user')
                ->join('roles', 'role_user.role_id', '=', 'roles.id')
                ->where('role_user.user_id', $user->id)
                ->where('roles.name', 'roles-guncelle')
                ->first();

            if ($roles) {
                return true;
            }
            return false;
        });

        Gate::define('roles-sil', function ($user) {
            $roles = DB::table('role_user')
                ->join('roles', 'role_user.role_id', '=', 'roles.id')
                ->where('role_user.user_id', $user->id)
                ->where('roles.name', 'roles-sil')
                ->first();

            if ($roles) {
                return true;
            }
            return false;
        });

        Gate::define('save-roles', function ($user) {
            $roles = DB::table('role_user')
                ->join('roles', 'role_user.role_id', '=', 'roles.id')
                ->where('role_user.user_id', $user->id)
                ->where('roles.name', 'save-roles')
                ->first();

            if ($roles) {
                return true;
            }
            return false;
        });

        Gate::define('get-user-roles', function ($user) {
            $roles = DB::table('role_user')
                ->join('roles', 'role_user.role_id', '=', 'roles.id')
                ->where('role_user.user_id', $user->id)
                ->where('roles.name', 'get-user-roles')
                ->first();

            if ($roles) {
                return true;
            }
            return false;
        });
    }
}
