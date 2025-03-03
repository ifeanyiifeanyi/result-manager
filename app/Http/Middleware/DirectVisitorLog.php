<?php

namespace App\Http\Middleware;

use Closure;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use Shetabit\Visitor\Models\Visit;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class DirectVisitorLog
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $agent = new Agent();

        $data = [
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'ip' => $request->ip(),
            'user_agent' => $request->header('user-agent'),
            'browser' => $agent->browser(),
            'platform' => $agent->platform(),
            'device' => $agent->device(),
            'country' => geoip($request->ip())->country ?? 'Unknown',
            'visitor_data' => json_encode([
                'device_type' => $agent->isDesktop() ? 'desktop' : ($agent->isTablet() ? 'tablet' : ($agent->isPhone() ? 'mobile' : 'other'))
            ])
        ];

        if (Auth::check()) {
            $data['user_id'] = $request->user()->id;
        }

        Visit::create($data);
        return $response;
    }
}
