<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class SetUserAuthorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        if ($response instanceof JsonResponse) {
            $data = $response->getData(true);
            if (isset($data['team'])) {
                $user = User::find($request->user()->id);
                if ($user->roles()->where('name', 'Admin')->wherePivot('team_id', $data['team']['id'])->exists()) {
                    $data['canEdit'] = true;
                }
            }
            Log::info("msgrrr", $data);

            $response->setData($data);
        }






        return $response;
    }
}
