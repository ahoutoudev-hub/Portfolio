<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class MaintenanceController extends Controller
{
    public function toggle()
    {
        if (app()->isDownForMaintenance()) {
            Artisan::call('up');
            return back()->with('toast_success', 'Site remis en ligne avec succès.');
        }

        Artisan::call('down', [
            '--secret' => env('MAINTENANCE_SECRET', 'ahoutou-admin-bypass'),
            '--render' => 'errors.503',
            '--retry'  => 60,
        ]);

        return back()->with('toast_success', 'Site mis en maintenance. L\'admin peut toujours y accéder.');
    }
}
