<?php

namespace App\Http\Controllers;

use App\Http\Actions\LoginAction;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Throwable;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *      path="/api/login",
     *      operationId="login",
     *      tags={"auth"},
     *      summary="Sign In",
     *      description="Login by email and password",
     *      @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *          type="string",
     *          required={"email", "password"},
     *          @OA\Property(property="email", type="string", format="email"),
     *          @OA\Property(
     *            property="password",
     *            type="string",
     *            format="password"
     *          )
     *        )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function login(Request $request): JsonResponse
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status' => 'Invalid login details',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = User::where('email', $request['email'])->firstOrFail();
        $token =  $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer'
        ], Response::HTTP_OK);
    }

    public function loginFake(Request $request, LoginAction $action): JsonResponse
    {
        if (!$request->has(['login', 'password'])) {
            return $this->returnFailure();
        }
        try {
            if ($action->execute($request)) {
                $accessToken = 'jwt-token-her';
                return response()->json([
                    'status' => 'success',
                    'token' => $accessToken
                ]);
            }

            return $this->returnFailure();
        } catch (Throwable $e) {
            return $this->returnFailure();
        }
    }

    private function returnFailure(): JsonResponse
    {
        return response()->json([
            'status' => 'failure'
        ]);
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
