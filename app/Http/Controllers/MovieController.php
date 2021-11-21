<?php

namespace App\Http\Controllers;

use App\Http\Actions\MovieAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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
            if (Cache::has('movies')) {
                $titles = Cache::get('movies');
            } else {
                $titles = $action->execute();
                Cache::put('movies', $titles, 3600);
            }
            return response()->json($titles);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'failure'
            ]);
        }
    }
}
