<?php

namespace App\Http\Controllers;

use App\Http\Actions\LoginAction;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Routing\Controller as BaseController;


class AuthController extends BaseController
{
    /**
     * @param Request $request
     * @param LoginAction $action
     *
     * @return JsonResponse
     */
    public function login(Request $request, LoginAction $action): JsonResponse
    {
        if ($action->execute($request)) {
            return response()->json([
                'status' => 'success',
                'token' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJsb2dpbiI6IkZPT18xIiwiY29udGV4dCI6IkZPTyIsImlhdCI6MTUxNjIzOTAyMn0.iOLIsd1TXyU53nrMGfjShXD7KSMz_lbaT256TQVYDz8'
            ]);
        }

        return response()->json([
            'status' => 'failure',
        ]);
    }
}
