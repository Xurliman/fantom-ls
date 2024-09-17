<?php

namespace App\Http\Controllers;

use App\Models\ContentUpdate;
use App\Models\License;
use App\Models\Store;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LicenseController extends Controller
{
    public function validateLicense(Request $request)
    {
        $request->validate([
            'license_key' => 'required',
            'store_id' => 'required',
        ]);

        $license = License::where('license_key', $request->input('license_key'))
            ->first();
        if ($license->store()->where('store_id', $request->input('store_id'))->first()) {
            return $license;
        }
        return null;
    }

    public function checkIfUpdateAvailable(Request $request): array
    {
        $request->validate([
            'store_id' => 'required',
        ]);

        $store = Store::firstWhere('store_id', $request->input('store_id'));
        if ($store) {
            $latestContentUpdate = $store
                ->contentUpdates()
                ->where('status', 'pending_update')
                ->latest()
                ->first();
            return $latestContentUpdate ? [
                'status' => 'available',
                'created_at' => $latestContentUpdate->created_at,
            ] : [
                'status' => 'not_available',
                'created_at' => null,
            ];
        }
        return [
            'status' => 'not_available',
            'created_at' => null,
        ];
    }

    public function sendUpdate(Request $request): Application|Response|StreamedResponse|ResponseFactory
    {
        $request->validate([
            'store_id' => 'required',
        ]);
        $store = Store::firstWhere('store_id', $request->input('store_id'));
        $latestContentUpdate = $store
            ->contentUpdates()
            ->where('status', 'pending_update')
            ->latest()
            ->first();
        $filePath = Storage::disk('public')->path($latestContentUpdate?->path);
        if (file_exists($filePath)) {
            return response()->stream(function () use ($filePath) {
                $chunkSize = 1024 * 8;
                $stream = fopen($filePath, 'rb');
                if ($stream === false) {
                    abort(500, 'Failed to open the file.');
                }

                while (!feof($stream)) {
                    echo fread($stream, $chunkSize);
                    ob_flush();
                    flush();
                }
                fclose($stream);
            }, 200, [
                'Content-Type' => 'application/zip',
                'Content-Disposition' => 'attachment; filename="' . basename($filePath) . '"',
                'Content-Length' => filesize($filePath),
                'X-Additional-Data' => json_encode(['content_update_id' => $latestContentUpdate->id])
            ]);
        }
        return response(null, 500);
    }

    public function verifyUpdate(Request $request): bool
    {
        $request->validate([
            'content_update_id' => 'required|exists:content_updates,id',
            'update_installed_at' => 'required|date',
        ]);
        return (bool)ContentUpdate::firstWhere('id', $request->input('content_update_id'))->update([
            'status' => 'update_installed',
            'update_installed_at' => $request->input('update_installed_at'),
        ]);
    }
}
