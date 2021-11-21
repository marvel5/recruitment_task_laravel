<?php

namespace App\Http\Controllers;

use App\Http\Actions\LoginAction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status' => 'Invalid login details',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = User::where('email', $request['email'])->firstOrFail();
        $token =  $user->createToken('auth_token')->plainTextToken;
        // if ($action->execute($request)) {
        //     $accessToken = '';
        //     return response()->json([
        //         'status' => 'success',
        //         'token' => $accessToken
        //     ]);
        // }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer'
        ], Response::HTTP_OK);
    }


    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], Response::HTTP_CREATED);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'status' => 'Tokens delete'
        ], Response::HTTP_OK);
    }

    public function user(Request $request)
    {
        return $request->user();
    }
}
