<?php

namespace Modules\Admin\Http\Controllers;

use App\Containers\User\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

/**
 * Dashboard Controller
 * 
 * Handles dashboard functionality for the Admin module.
 * Provides comprehensive statistics and analytics for user management.
 */
class DashboardController extends Controller
{
    /**
     * Display the admin dashboard with comprehensive statistics
     * 
     * This method aggregates various user statistics and analytics data
     * to provide a complete overview of the system's user management.
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Overall statistics
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('status', 'active')->count(),
            'inactive_users' => User::where('status', 'inactive')->count(),
            'new_users_this_month' => User::whereMonth('created_at', Carbon::now()->month)->count(),
            'new_users_this_week' => User::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count(),
            'admin_users' => User::where('role', 'admin')->count(),
            'manager_users' => User::where('role', 'manager')->count(),
            'regular_users' => User::where('role', 'user')->count(),
        ];

        // Statistics by role
        $usersByRole = User::select('role', DB::raw('count(*) as count'))
            ->groupBy('role')
            ->get()
            ->pluck('count', 'role')
            ->toArray();

        // Statistics by status
        $usersByStatus = User::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        // Statistics by department
        $usersByDepartment = User::select('department', DB::raw('count(*) as count'))
            ->whereNotNull('department')
            ->groupBy('department')
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get();

        // Monthly statistics (last 6 months)
        $monthlyStats = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthlyStats[] = [
                'month' => $date->format('M Y'),
                'count' => User::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count()
            ];
        }

        // Recent users
        $recentUsers = User::with('permissions')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Users with avatar
        $usersWithAvatar = User::whereNotNull('avatar')->count();
        $usersWithoutAvatar = User::whereNull('avatar')->count();

        return view('admin::index', compact(
            'stats',
            'usersByRole',
            'usersByStatus',
            'usersByDepartment',
            'monthlyStats',
            'recentUsers',
            'usersWithAvatar',
            'usersWithoutAvatar'
        ));
    }
} 