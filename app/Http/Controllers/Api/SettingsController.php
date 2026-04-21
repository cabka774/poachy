<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    use ApiResponse;

    public function index(Request $request): JsonResponse
    {
        $settings = Setting::firstOrCreate(
            ['user_id' => $request->user()->id],
            [
                'business_name' => 'My Business',
                'currency' => 'KSh',
                'tax_rate' => 16.00,
                'receipt_footer' => 'Thank you for your business!',
            ]
        );

        return $this->success($settings);
    }

    public function update(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'business_name' => 'sometimes|string|max:255',
            'business_phone' => 'sometimes|nullable|string|max:20',
            'business_email' => 'sometimes|nullable|email|max:255',
            'business_location' => 'sometimes|nullable|string|max:255',
            'currency' => 'sometimes|string|max:10',
            'tax_rate' => 'sometimes|numeric|min:0|max:100',
            'receipt_footer' => 'sometimes|nullable|string|max:500',
        ]);

        $settings = Setting::updateOrCreate(
            ['user_id' => $request->user()->id],
            $validated
        );

        return $this->success($settings, 'Settings saved');
    }

    public function changePassword(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return $this->success(null, 'Password changed successfully');
    }
}

