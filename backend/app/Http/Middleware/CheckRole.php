<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        
        $user = auth()->user();
        
        if (in_array($user->role, $roles)) {
            // Check if school operator has access to the correct school
            if ($user->role === 'operator' || $user->role === 'kepala_sekolah') {
                $schoolId = $request->route('schoolId') ?? $request->route('id');
                
                if ($schoolId && $user->school_id != $schoolId) {
                    abort(403, 'Anda tidak memiliki akses ke sekolah ini.');
                }
            }
            
            return $next($request);
        }
        
        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }
}