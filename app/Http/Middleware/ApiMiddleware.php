<?php
namespace App\Http\Middleware;
use App\Models\User;
use Closure;

class ApiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $apiToken = $request->segment(2);

        $tokenValid = User::where('api_token', $apiToken)->exists();

        if (!$tokenValid) {
            return response()->json('Unauthorized! Provide valid api token', 401);
        }

        return $next($request);
    }
}
