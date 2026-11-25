<?php

namespace App\Support;

use Illuminate\Support\Str;

class MediaUrl
{
    public static function for(?string $value): ?string
    {
        if (blank($value)) {
            return $value;
        }

        if (! self::looksLikeWasabi($value)) {
            return $value;
        }

        $path = self::pathFromWasabiValue($value);

        if (blank($path)) {
            return $value;
        }

        return '/media-cache/'.self::encodePath($path);
    }

    private static function looksLikeWasabi(string $value): bool
    {
        $wasabiUrl = rtrim((string) config('filesystems.disks.wasabi.url'), '/');
        $endpoint = (string) config('filesystems.disks.wasabi.endpoint');

        return str_contains($value, 'wasabisys.com')
            || ($wasabiUrl && str_starts_with($value, $wasabiUrl))
            || ($endpoint && str_contains($value, parse_url($endpoint, PHP_URL_HOST) ?: $endpoint));
    }

    private static function pathFromWasabiValue(string $value): ?string
    {
        $wasabiUrl = rtrim((string) config('filesystems.disks.wasabi.url'), '/');

        if ($wasabiUrl && str_starts_with($value, $wasabiUrl)) {
            return ltrim(Str::after($value, $wasabiUrl), '/');
        }

        $path = ltrim((string) parse_url($value, PHP_URL_PATH), '/');
        $bucket = trim((string) config('filesystems.disks.wasabi.bucket'), '/');

        if ($bucket && str_starts_with($path, $bucket.'/')) {
            return Str::after($path, $bucket.'/');
        }

        return $path ?: null;
    }

    private static function encodePath(string $path): string
    {
        return rtrim(strtr(base64_encode($path), '+/', '-_'), '=');
    }
}
