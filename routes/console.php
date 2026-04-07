<?php

use App\Http\Controllers\FeatureFlagController;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// ===========================================================
// Feature Flag Management Commands
// ===========================================================
Artisan::command('flag:create {name} {enabled}', function () {
    $name = $this->argument('name');
    $enabled = $this->argument('enabled');

    $response = app(FeatureFlagController::class)->createFlag($name, (int) $enabled);

    if ($response['error']) {
        $this->error($response['message']);
        return;
    }

    $this->info($response['message']);
})->purpose('Create a new feature flag');

Artisan::command('flag:edit {name} {enabled}', function () {
    $name = $this->argument('name');
    $enabled = $this->argument('enabled');

    $response = app(FeatureFlagController::class)->editFlag($name, (int) $enabled);

    if ($response['error']) {
        $this->error($response['message']);

        return;
    }

    $this->info($response['message']);
})->purpose('Edit a feature flag by name');

Artisan::command('flag:list', function () {
    $response = app(FeatureFlagController::class)->listFlags();

    if ($response['error']) {
        $this->error($response['message']);

        return;
    }

    if (empty($response['flags'])) {
        $this->info($response['message']);

        return;
    }

    foreach ($response['flags'] as $flag) {
        $this->line("{$flag['name']}: {$flag['status']}");
    }
})->purpose('List all feature flags');