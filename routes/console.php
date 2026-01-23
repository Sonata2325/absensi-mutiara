<?php

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Storage;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('media:cleanup', function () {
    $disk = Storage::disk('public');
    $profileCutoff = now()->subDays(7);
    $attendanceCutoff = now()->subDays(30)->startOfDay();

    User::query()
        ->whereNotNull('foto_profile')
        ->chunkById(200, function ($users) use ($disk, $profileCutoff) {
            foreach ($users as $user) {
                $path = (string) $user->foto_profile;
                $shouldDelete = true;

                if ($disk->exists($path)) {
                    $lastModified = Carbon::createFromTimestamp($disk->lastModified($path));
                    $shouldDelete = $lastModified->lessThan($profileCutoff);
                    if ($shouldDelete) {
                        $disk->delete($path);
                    }
                }

                if ($shouldDelete) {
                    $user->update(['foto_profile' => null]);
                }
            }
        });

    Attendance::query()
        ->whereDate('tanggal', '<', $attendanceCutoff->toDateString())
        ->where(function ($query) {
            $query->whereNotNull('foto_masuk')->orWhereNotNull('foto_keluar');
        })
        ->chunkById(200, function ($rows) use ($disk) {
            foreach ($rows as $attendance) {
                $updates = [];
                if ($attendance->foto_masuk) {
                    if ($disk->exists($attendance->foto_masuk)) {
                        $disk->delete($attendance->foto_masuk);
                    }
                    $updates['foto_masuk'] = null;
                }
                if ($attendance->foto_keluar) {
                    if ($disk->exists($attendance->foto_keluar)) {
                        $disk->delete($attendance->foto_keluar);
                    }
                    $updates['foto_keluar'] = null;
                }
                if ($updates) {
                    $attendance->update($updates);
                }
            }
        });
})->purpose('Hapus foto lama agar storage tidak penuh');

Schedule::command('media:cleanup')->dailyAt('01:00');
