<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();

        if (!$setting) {
            $setting = Setting::create([
                'app_name' => 'Stockify',
            ]);
        }

        return view('setting.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = Setting::first();

        if (!$setting) {
            $setting = new Setting();
        }

        $validated = $request->validate([
            'app_name' => 'required|string|max:255',
            'app_logo' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'company_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
        ]);

        if ($request->hasFile('app_logo')) {

            if (
                $setting->app_logo &&
                Storage::disk('public')->exists($setting->app_logo)
            ) {
                Storage::disk('public')->delete($setting->app_logo);
            }

            $validated['app_logo'] = $request
                ->file('app_logo')
                ->store('settings', 'public');
        }

        $setting->fill($validated);
        $setting->save();

        return redirect()
            ->route('pengaturan.index')
            ->with('success', 'Pengaturan berhasil disimpan.');
    }
}