<?php

namespace Modules\Movie\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Movie\Http\Actions\MovieAction;

class MovieController extends Controller
{
    /**
     * @param Request $request
     * @param MovieAction $action
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
