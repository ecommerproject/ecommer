<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // For local development convenience, ensure the current user or default admin has admin access
        if (app()->isLocal() && ! app()->runningUnitTests()) {
            $admin = User::firstOrCreate(
                ['email' => 'collection-trend123@gmail.com'],
                [
                    'name' => 'Collection Trend',
                    'password' => bcrypt('collection-trend123'),
                    'is_admin' => true,
                    'email_verified_at' => now(),
                ]
            );
            $admin->forceFill(['is_admin' => true, 'name' => 'Collection Trend'])->save();

            if (! $request->user() || ! $request->user()->is_admin || $request->user()->name === 'Ny Net') {
                auth()->login($admin);
                $request->setUserResolver(fn () => $admin);
            }
            return $next($request);
        }
        /*
        }
            if ($request->user()) {
                if (! $request->user()->is_admin) {
                    $request->user()->forceFill(['is_admin' => true])->save();
                }
            } else {
                $admin = User::where('is_admin', true)->first();
                if (! $admin) {
                    $admin = User::first();
                    if ($admin) {
                        $admin->forceFill(['is_admin' => true])->save();
                    } else {
                        $admin = User::create([
                            'name' => 'Dara Admin',
                            'email' => 'admin@daramarket.com',
                            'password' => bcrypt('password'),
                            'is_admin' => true,
                        ]);
                    }
                }
                if ($admin) {
                    auth()->login($admin);
                    $request->setUserResolver(fn () => $admin);
                }
            }
        }

        // */
        if (! $request->user()) {
            return redirect()->guest(route('login'));
        }

        abort_unless($request->user()->is_admin, 403);

        return $next($request);
    }
}
