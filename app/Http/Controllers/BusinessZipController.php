<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use ZipArchive;

class BusinessZipController extends Controller
{
    public function download(Business $business)
    {
        // Load all reviews and photos for this business
        $business->load(['reviews', 'photos', 'source']);

        // Check whether ZIP extension is available
        if (!class_exists(ZipArchive::class)) {
            abort(500, 'PHP ZIP extension is not enabled.');
        }

        // Create temporary folder
        $tempFolder = storage_path(
            'app/temp/business-' . $business->id . '-' . Str::random(8)
        );

        $photosFolder = $tempFolder . '/photos';

        if (!mkdir($photosFolder, 0755, true) && !is_dir($photosFolder)) {
            abort(500, 'Unable to create temporary folder.');
        }

        // Create business_info.md
        $businessInfo = "# Business Information\n\n";

        $businessInfo .= "- **Business Name:** " . ($business->name ?? 'N/A') . "\n";
        $businessInfo .= "- **Category:** " . ($business->category ?? 'N/A') . "\n";
        $businessInfo .= "- **Address:** " . ($business->address ?? 'N/A') . "\n";
        $businessInfo .= "- **Phone:** " . ($business->phone ?? 'N/A') . "\n";
        $businessInfo .= "- **Website:** " . ($business->website ?? 'N/A') . "\n";
        $businessInfo .= "- **Rating:** " . ($business->rating ?? 'N/A') . "\n";
        $businessInfo .= "- **Review Count:** " . ($business->review_count ?? 'N/A') . "\n";
        $businessInfo .= "- **Google Maps URL:** " . ($business->maps_url ?? 'N/A') . "\n";
        $businessInfo .= "- **Latitude:** " . ($business->latitude ?? 'N/A') . "\n";
        $businessInfo .= "- **Longitude:** " . ($business->longitude ?? 'N/A') . "\n";
        $businessInfo .= "- **External ID:** " . ($business->external_id ?? 'N/A') . "\n";
        $businessInfo .= "- **Source:** " . ($business->source->name ?? 'N/A') . "\n";
        $businessInfo .= "- **Collected At:** " . ($business->collected_at ?? 'N/A') . "\n";

        file_put_contents(
            $tempFolder . '/business_info.md',
            $businessInfo
        );

        // Create reviews.md
        $reviewsContent = "# Business Reviews\n\n";

        $reviewsContent .= "**Total collected reviews:** "
            . $business->reviews->count() . "\n\n";

        foreach ($business->reviews as $index => $review) {
            $reviewsContent .= "## Review " . ($index + 1) . "\n\n";

            $reviewsContent .= "- **Reviewer:** " . ($review->author ?? 'N/A') . "\n";
            $reviewsContent .= "- **Rating:** " . ($review->rating ?? 'N/A') . "\n";
            $reviewsContent .= "- **Date:** " . ($review->review_date ?? 'N/A') . "\n\n";

            $reviewsContent .= "**Review:**\n\n";
            $reviewsContent .= ($review->review_text ?? 'No review text') . "\n\n";

            $reviewsContent .= "**Owner Response:**\n\n";
            $reviewsContent .= ($review->owner_response ?? 'No owner response') . "\n\n";

            $reviewsContent .= "---\n\n";
        }

        file_put_contents(
            $tempFolder . '/reviews.md',
            $reviewsContent
        );

        // Download photos
        $photoErrors = [];

        foreach ($business->photos as $index => $photo) {
            $url = $photo->photo_url;

            if (!$url || !filter_var($url, FILTER_VALIDATE_URL)) {
                $photoErrors[] = "Photo " . ($index + 1) . ": Invalid URL";
                continue;
            }

            $scheme = parse_url($url, PHP_URL_SCHEME);
            $host = strtolower(parse_url($url, PHP_URL_HOST) ?? '');

            // Only permit known Google photo hosts.
            $allowedHosts = [
                'googleusercontent.com',
                'gstatic.com',
                'google.com',
            ];

            $allowedHost = false;

            foreach ($allowedHosts as $allowed) {
                if ($host === $allowed || str_ends_with($host, '.' . $allowed)) {
                    $allowedHost = true;
                    break;
                }
            }

            if (!in_array($scheme, ['http', 'https'], true) || !$allowedHost) {
                $photoErrors[] = "Photo " . ($index + 1) . ": Unsupported photo URL";
                continue;
            }

            try {
                $response = Http::timeout(20)
                    ->withOptions(['allow_redirects' => false])
                    ->get($url);

                if (!$response->successful()) {
                    $photoErrors[] = "Photo " . ($index + 1) . ": Download failed";
                    continue;
                }

                $contentType = strtolower(
                    $response->header('Content-Type', '')
                );

                $extensions = [
                    'image/jpeg' => 'jpg',
                    'image/png' => 'png',
                    'image/webp' => 'webp',
                    'image/gif' => 'gif',
                ];

                $extension = $extensions[$contentType] ?? null;

                if (!$extension) {
                    $photoErrors[] = "Photo " . ($index + 1) . ": Unsupported image type";
                    continue;
                }

                $filename = 'photo_' . ($index + 1) . '.' . $extension;

                file_put_contents(
                    $photosFolder . '/' . $filename,
                    $response->body()
                );

            } catch (\Throwable $e) {
                $photoErrors[] = "Photo " . ($index + 1) . ": " . $e->getMessage();
            }
        }

        // Include photo download errors, if any
        if (!empty($photoErrors)) {
            file_put_contents(
                $photosFolder . '/download_errors.txt',
                implode("\n", $photoErrors)
            );
        }

        // Create ZIP file
        $zipPath = storage_path(
            'app/temp/business-' . $business->id . '-' . Str::random(8) . '.zip'
        );

        $zip = new ZipArchive();

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            $this->deleteDirectory($tempFolder);
            abort(500, 'Unable to create ZIP file.');
        }

        $zip->addFile(
            $tempFolder . '/business_info.md',
            'business_info.md'
        );

        $zip->addFile(
            $tempFolder . '/reviews.md',
            'reviews.md'
        );

        // Add downloaded photos
        foreach (glob($photosFolder . '/*') ?: [] as $file) {
            if (is_file($file)) {
                $zip->addFile(
                    $file,
                    'photos/' . basename($file)
                );
            }
        }

        $zip->close();

        // Download ZIP and clean temporary files afterward
        return response()->download(
            $zipPath,
            Str::slug($business->name) . '.zip'
        )->deleteFileAfterSend(true);
    }

    private function deleteDirectory($directory)
    {
        if (!is_dir($directory)) {
            return;
        }

        foreach (scandir($directory) as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }

            $path = $directory . '/' . $item;

            if (is_dir($path)) {
                $this->deleteDirectory($path);
            } else {
                unlink($path);
            }
        }

        rmdir($directory);
    }
}
