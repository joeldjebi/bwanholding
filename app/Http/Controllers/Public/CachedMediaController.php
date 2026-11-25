<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CachedMediaController extends Controller
{
    public function __invoke(string $encoded): BinaryFileResponse|Response
    {
        $path = $this->decodePath($encoded);

        abort_if(blank($path) || str_contains($path, '..'), 404);

        $cacheDirectory = storage_path('app/media-cache');
        $extension = pathinfo($path, PATHINFO_EXTENSION) ?: 'bin';
        $cachePath = $cacheDirectory.'/'.sha1($path).'.'.$extension;

        if (! is_file($cachePath)) {
            if (! is_dir($cacheDirectory)) {
                mkdir($cacheDirectory, 0755, true);
            }

            abort_unless(Storage::disk('wasabi')->exists($path), 404);

            file_put_contents($cachePath, Storage::disk('wasabi')->get($path));
        }

        $etag = '"'.sha1_file($cachePath).'"';

        if (request()->headers->get('If-None-Match') === $etag) {
            return response('', 304, $this->cacheHeaders($etag, $path));
        }

        return response()
            ->file($cachePath, $this->cacheHeaders($etag, $path));
    }

    private function decodePath(string $encoded): ?string
    {
        $base64 = strtr($encoded, '-_', '+/');
        $base64 .= str_repeat('=', (4 - strlen($base64) % 4) % 4);
        $decoded = base64_decode($base64, true);

        return $decoded ? ltrim($decoded, '/') : null;
    }

    /**
     * @return array<string, string>
     */
    private function cacheHeaders(string $etag, string $path): array
    {
        return [
            'Cache-Control' => 'public, max-age=604800, stale-while-revalidate=86400',
            'ETag' => $etag,
            'Expires' => now()->addWeek()->toRfc7231String(),
            'Content-Type' => $this->contentTypeFromExtension($path),
        ];
    }

    private function contentTypeFromExtension(string $path): string
    {
        return match (Str::lower(pathinfo($path, PATHINFO_EXTENSION))) {
            'jpg', 'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
            'svg' => 'image/svg+xml',
            default => 'application/octet-stream',
        };
    }
}
