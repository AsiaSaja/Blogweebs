<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RedirectByRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);

        //User Authenticated
        if (Auth::check()) {
            $user = Auth::user();
            $route = $request->route()->getName();


            $allowedRoutes = [
                'admin' => ['admin.*'],
                'editor'=> ['editor.*', 'home'],
                'writer'=> ['writer.*', 'home'],
                'reader'=> ['home', 'aticles.*'],
            ];


            $allowed = false;
            foreach ($allowedRoutes[$user->role] as $pattern) {
                if(str_is($pattern, $route)) {
                    $allowed = true;
                    break;
                }
            }

            if (!$allowed) {
                return $this->redirectToRole($user->role);
            }
        }

        return $response;
    }

    protected function redirectToRole($role)
    {
        return match($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'editor'=> redirect()->route('editor.home'),
            'writer'=> redirect()->route('writer.dashboard'),
            default => redirect()->route('home'),
        };
    }
}
