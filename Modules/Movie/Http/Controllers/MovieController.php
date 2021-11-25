<?php

namespace Modules\Movie\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Movie\Http\Actions\MovieAction;

class MovieController extends Controller
{
    /**
     * Companies Foo, Bar and Baz are the suppliers of the footage. One of the goals of this app is to provide clients with access to all the material offered by the vendors.
     * The files are classes with the method getTitles() which returns a list of titles (in different format) for your system. No title belongs to more than one system.
     * @param Request $request
     * @param MovieAction $action
     *
     * @return JsonResponse
     *
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
