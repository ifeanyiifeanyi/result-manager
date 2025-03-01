<?php

namespace App\Services;

use Carbon\Carbon;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\DB;

class SessionService
{
    /**
     * Get all active sessions for a user
     *
     * @param int $userId
     * @return \Illuminate\Support\Collection
     */
    public function getUserSessions(int $userId)
    {
        $sessions = DB::table('sessions')
            ->where('user_id', $userId)
            ->get();

        $currentSessionId = session()->getId();
        $agent = new Agent();

        return $sessions->map(function ($session) use ($currentSessionId, $agent) {
            $payload = unserialize(base64_decode($session->payload));
            $userAgent = $session->user_agent ?? 'Unknown';

            // Set user agent for detection
            $agent->setUserAgent($userAgent);

            return (object) [
                'id' => $session->id,
                'ip_address' => $session->ip_address,
                'is_current' => $session->id === $currentSessionId,
                'last_active' => Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
                'agent_name' => $this->getBrowserName($agent),
                'platform' => $this->getPlatformName($agent),
                'device' => $this->getDeviceType($agent),
                'user_agent' => $userAgent
            ];
        });
    }


    /**
     * Invalidate a specific session
     *
     * @param string $sessionId
     * @param int $userId
     * @return bool
     */
    public function invalidateSession(string $sessionId, int $userId)
    {
        return DB::table('sessions')
            ->where('id', $sessionId)
            ->where('user_id', $userId)
            ->delete() > 0;
    }

    /**
     * Invalidate all sessions for a user except the current one
     *
     * @param int $userId
     * @param string $currentSessionId
     * @return int
     */
    public function invalidateAllSessions(int $userId, string $currentSessionId)
    {
        return DB::table('sessions')
            ->where('user_id', $userId)
            ->where('id', '!=', $currentSessionId)
            ->delete();
    }

    /**
     * Get browser name
     *
     * @param Agent $agent
     * @return string
     */
    private function getBrowserName(Agent $agent)
    {
        $browser = $agent->browser();
        $version = $agent->version($browser);

        return $browser . ' ' . $version;
    }

    /**
     * Get platform name
     *
     * @param Agent $agent
     * @return string
     */
    private function getPlatformName(Agent $agent)
    {
        $platform = $agent->platform();
        $version = $agent->version($platform);

        return $platform . ' ' . $version;
    }

    /**
     * Get device type
     *
     * @param Agent $agent
     * @return string
     */
    private function getDeviceType(Agent $agent)
    {
        if ($agent->isTablet()) {
            return 'Tablet';
        } elseif ($agent->isPhone()) {
            return 'Phone';
        } elseif ($agent->isDesktop()) {
            return 'Desktop';
        } else {
            return 'Unknown';
        }
    }
}
