<?php

namespace App\Http\Middleware;

use Closure;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use Shetabit\Visitor\Visitor;
use Shetabit\Visitor\Models\Visit;
use Symfony\Component\HttpFoundation\Response;

class EnhancedVisitorLog
{

    protected $visitor;

    public function __construct(Visitor $visitor)
    {
        $this->visitor = $visitor;
    }

    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $visit = $this->visitor->visit();

        if ($visit) {
            $agent = new Agent();
            $visitRecord = Visit::find($visit->id);

            if ($visitRecord) {
                $deviceType = $agent->isDesktop() ? 'desktop' : ($agent->isTablet() ? 'tablet' : ($agent->isPhone() ? 'mobile' : 'other'));

                $visitorData = json_decode($visitRecord->visitor_data, true) ?: [];
                $visitorData['device_type'] = $deviceType;
                $visitRecord->visitor_data = json_encode($visitorData);
                $visitRecord->country = geoip($request->ip())->country ?? 'Unknown';  // Fixed syntax
                $visitRecord->save();
            }
        }

        return $response;
    }
}
