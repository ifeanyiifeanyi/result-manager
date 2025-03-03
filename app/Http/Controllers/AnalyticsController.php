<?php

namespace App\Http\Controllers;

use view;
use Carbon\Carbon;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Shetabit\Visitor\Models\Visit;

class AnalyticsController extends Controller
{
    public function index()
    {
        // Get total page views
        $totalPageViews = Visit::count();

        // Get most visited pages
        $popularPages = Visit::select('url', DB::raw('count(*) as views'))
            ->groupBy('url')
            ->orderByDesc('views')
            ->limit(10)
            ->get();

        // Get visitors by country
        $countries = Visit::select('country', DB::raw('count(*) as total'))
            ->groupBy('country')
            ->orderByDesc('total')
            ->limit(10)
            ->get();



        // Get visitors by browser
        $browsers = Visit::select('browser', DB::raw('count(*) as total'))
            ->groupBy('browser')
            ->orderByDesc('total')
            ->get();

        // Get visitors by device
        $devices = Visit::select('device_type', DB::raw('count(*) as total'))
            ->groupBy('device_type')
            ->orderByDesc('total')
            ->get();

        // Get visitors for the last 30 days
        $startDate = Carbon::now()->subDays(30);
        $dailyVisits = Visit::where('created_at', '>=', $startDate)
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as views'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $agent = new Agent();
        $browsers = Visit::all()->groupBy(function ($visit) use ($agent) {
            $agent->setUserAgent($visit->useragent);
            return $agent->browser() ?: 'Unknown';
        })->map->count();

        $devices = Visit::all()->groupBy(function ($visit) {
            $data = json_decode($visit->visitor_data, true);
            return $data['device_type'] ?? 'Unknown';
        })->map->count();

        return view('analytics.dashboard', compact(
            'totalPageViews',
            'popularPages',
            'countries',
            'browsers',
            'devices',
            'dailyVisits',
            'browsers',
            'devices'
        ));
    }
}
