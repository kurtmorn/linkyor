<?php
/**
**
 * MIT License
 *
 * Copyright (c) 2023 Linkyor
 *
**
 */

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\UserBan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InfoController extends Controller
{
    public function index()
    {
        $serverData = $this->data('server');
        $siteData = $this->data('site');

        return view('admin.info')->with([
            'siteData' => $siteData,
            'serverData' => $serverData
        ]);
    }

    public function data($type)
    {
        switch ($type) {
            case 'site':
                $totalUsers = User::count();
                $joinedToday = User::where('created_at', '>=', Carbon::now()->subDays(1))->count();
                $onlineUsers = User::where('updated_at', '>=', Carbon::now()->subMinutes(3))->count();
                $bannedUsers = UserBan::where('active', '=', true)->count();

                return [
                    'Total Users' => $totalUsers,
                    'Joined Today' => $joinedToday,
                    'Online Users' => $onlineUsers,
                    'Banned Users' => $bannedUsers
                ];
            case 'server':
                if (strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {
                    $cpuUsage = sys_getloadavg()[0] . '%';

                    $execFree = explode("\n", trim(shell_exec('free')));
                    $getMem = preg_split("/[\s]+/", $execFree[1]);
                    $ramUsage = round($getMem[2] / $getMem[1] * 100, 0) . '%';

                    $uptime = preg_split("/[\s]+/", trim(shell_exec('uptime')))[2] . ' Days';
                }

                return [
                    'CPU Usage' => $cpuUsage ?? '???',
                    'RAM Usage' => $ramUsage ?? '???',
                    'PHP Version' => phpversion(),
                    'Uptime' => $uptime ?? '???'
                ];
        }
    }
}
