<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class VisitorGeoService
{
    public function locate(Request $request): array
    {
        $ip = $request->ip();

        if (! $ip || $this->isPrivateIp($ip)) {
            return [
                'ip_address' => $ip,
                'country' => 'Local',
                'region' => null,
                'city' => 'Development',
            ];
        }

        return Cache::remember("visitor-geo:{$ip}", now()->addDays(7), function () use ($ip) {
            try {
                $response = Http::timeout(3)->get("http://ip-api.com/json/{$ip}", [
                    'fields' => 'status,country,regionName,city,query',
                ]);

                if ($response->successful() && $response->json('status') === 'success') {
                    return [
                        'ip_address' => $response->json('query') ?: $ip,
                        'country' => $response->json('country'),
                        'region' => $response->json('regionName'),
                        'city' => $response->json('city'),
                    ];
                }
            } catch (\Throwable $e) {
                report($e);
            }

            return [
                'ip_address' => $ip,
                'country' => null,
                'region' => null,
                'city' => null,
            ];
        });
    }

    public function parseUserAgent(?string $userAgent): array
    {
        $ua = (string) $userAgent;

        $browser = 'Unknown';
        if (preg_match('/Edg\/[\d.]+/i', $ua)) {
            $browser = 'Edge';
        } elseif (preg_match('/Chrome\/[\d.]+/i', $ua) && ! preg_match('/Edg\//i', $ua)) {
            $browser = 'Chrome';
        } elseif (preg_match('/Firefox\/[\d.]+/i', $ua)) {
            $browser = 'Firefox';
        } elseif (preg_match('/Safari\/[\d.]+/i', $ua) && ! preg_match('/Chrome\//i', $ua)) {
            $browser = 'Safari';
        } elseif (preg_match('/MSIE|Trident/i', $ua)) {
            $browser = 'Internet Explorer';
        }

        $platform = 'Unknown';
        if (preg_match('/Windows/i', $ua)) {
            $platform = 'Windows';
        } elseif (preg_match('/Mac OS X|Macintosh/i', $ua)) {
            $platform = 'macOS';
        } elseif (preg_match('/Android/i', $ua)) {
            $platform = 'Android';
        } elseif (preg_match('/iPhone|iPad|iPod/i', $ua)) {
            $platform = 'iOS';
        } elseif (preg_match('/Linux/i', $ua)) {
            $platform = 'Linux';
        }

        $device = 'Desktop';
        if (preg_match('/Mobile|Android|iPhone|iPod/i', $ua)) {
            $device = 'Mobile';
        } elseif (preg_match('/iPad|Tablet/i', $ua)) {
            $device = 'Tablet';
        }

        return compact('browser', 'platform', 'device');
    }

    private function isPrivateIp(string $ip): bool
    {
        return filter_var(
            $ip,
            FILTER_VALIDATE_IP,
            FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
        ) === false;
    }
}
