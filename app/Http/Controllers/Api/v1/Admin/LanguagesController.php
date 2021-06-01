<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\JsonResponse;

class LanguagesController extends Controller
{

    /**
     * Show Languages.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return response(
            $this->successResponse(
                'languages',
                Language::all()
            )
        );
    }

}
