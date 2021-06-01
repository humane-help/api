<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Newspaper;
use App\Models\User;
use App\Models\Tech;
use Illuminate\Http\JsonResponse;

class StatisticsController extends Controller
{

    /**
     * Show data.
     *
     * @return JsonResponse
     */
    public function dashboard()
    {
        return response()->json([
            'code' => 20000,
            'data' => [
                'activeArticles' => Article::where('status', 1)->count(),
                'activeTech' => Tech::where('status', 1)->count(),
                'activeNewspaper' => Newspaper::where('status', 1)->count(),
                'users' => User::count(),
            ]
        ]);
    }
}
