<?php

namespace App\Providers;

use App\Models\Permission;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(Gate $gate)
    {
        $this->registerPolicies();

        // return if no permissions table -- for testing purpose

        $tableName = (new Permission)->getTable();
        $checkTable = \DB::connection('oracle')->select("
                            select
                                dob.object_name
                            from dba_objects dob
                            where 1=1
                                and lower(object_name) = lower('{$tableName}')
                                and owner = 'APPS'
                        ");

        if (count($checkTable) == 0) {
            return false;
        }

        foreach ($this->getPermissions() as $permission) {
            Gate::define($permission->name, function ($user) use ($permission) {
                return $user->hasPermission($permission);
            });
        }
    }

    private function getPermissions()
    {
        return Permission::all();
    }
}
