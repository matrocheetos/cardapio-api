<?php

namespace App\Http\Controllers;

use App\Models\FeatureFlag;

final class FeatureFlagController
{
    /**
     * Cria nova feature flag
     */
    public function createFlag(string $name, int $enabled): array
    {
        if (!in_array($enabled, [0, 1], true)) {
            return [
                'error' => true,
                'message' => "Enabled must be '1' or '0'."
            ];
        }

        try {
            $flag = FeatureFlag::create([
                'name' => $name,
                'enabled' => $enabled === 1
            ]);

            return [
                'error' => false,
                'message' => "Feature flag '{$flag->name}' created successfully.",
            ];
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => 'Error creating feature flag: '.$e->getMessage()
            ];
        }
    }

    /**
     * Edita uma feature flag existente
     */
    public function editFlag(string $name, int $enabled): array
    {
        if (!in_array($enabled, [0, 1], true)) {
            return [
                'error' => true,
                'message' => "Enabled must be '1' or '0'."
            ];
        }

        try {
            $flag = FeatureFlag::where('name', '=', $name)->first();

            if (!$flag) {
                return [
                    'error' => true,
                    'message' => "Feature flag '{$name}' not found."
                ];
            }

            $flag->enabled = $enabled === 1;
            $flag->save();

            return [
                'error' => false,
                'message' => "Feature flag '{$name}' updated successfully."
            ];
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => 'Error updating feature flag: '.$e->getMessage()
            ];
        }
    }

    /**
     * Lista todas as feature flags
     */
    public function listFlags(): array
    {
        try {
            $flags = FeatureFlag::all();

            if ($flags->isEmpty()) {
                return [
                    'error' => false,
                    'message' => 'No feature flags found.',
                    'flags' => []
                ];
            }

            $formattedFlags = $flags->map(function (FeatureFlag $flag): array {
                return [
                    'name' => $flag->name,
                    'enabled' => $flag->enabled,
                    'status' => $flag->enabled ? '[1] Enabled' : '[0] Disabled'
                ];
            })->all();

            return [
                'error' => false,
                'message' => 'Feature flags listed successfully.',
                'flags' => $formattedFlags
            ];
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => 'Error listing feature flags: '.$e->getMessage(),
                'flags' => []
            ];
        }
    }
}
