<?php

use App\Models\User;
use App\Models\Position;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$users = User::where('role', 'employee')->with('position')->get();

foreach ($users as $user) {
    echo "Name: " . $user->name . "\n";
    echo "Phone: " . $user->phone . "\n";
    echo "Position ID: " . $user->position_id . "\n";
    echo "Position Column Value: " . ($user->attributes['position'] ?? 'N/A') . "\n";
    if ($user->position) {
        echo "Position Name: " . $user->position->nama_posisi . "\n";
    } else {
        echo "Position Relation is NULL\n";
    }
    echo "------------------------\n";
}

$positions = Position::all();
echo "\nAll Positions:\n";
foreach ($positions as $pos) {
    echo "ID: " . $pos->id . " - Name: " . $pos->nama_posisi . "\n";
}
