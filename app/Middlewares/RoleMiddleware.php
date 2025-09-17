<?php

namespace Middlewares;

use Src\Auth\Auth;
use Src\Request;

class RoleMiddleware
{
    public function handle(Request $request, string $roles): void
    {
        $allowedRoles = explode(',', $roles);
        $user = app()->auth::user();

        if (!$user || !in_array($user->role, $allowedRoles)) {
            app()->route->redirect('/login'); // или return 403
            exit();
        }
    }

}
