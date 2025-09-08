<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            // Check URL or role to send to the right login page
            if ($request->is('traveler/*')) {
                return route('traveler.travelerLogin');
            } elseif ($request->is('staff/*')) {
                return route('staff.staffLogin');
            } elseif ($request->is('admin/*')) {
                return route('admin.adminLogin');
            }

            // Default fallback
            return route('landing');
        }
    }
}
