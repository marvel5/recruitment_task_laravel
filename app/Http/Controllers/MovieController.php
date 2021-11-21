<?php

namespace App\Http\Controllers;

use App\Http\Actions\MovieAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class MovieController extends Controller
{
    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getTitles(Request $request, MovieAction $action): JsonResponse
    {
        try {
            return response()->json($action->execute());
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'failure'
            ]);
        }
    }
}
