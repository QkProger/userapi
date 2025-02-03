<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|min:2|max:15',
                'email' => 'required|string|email|min:3|max:50|unique:users',
                'password' => 'required|string|min:8',
            ]);
        } catch (ValidationException $e) {
            $validationErrors = $e->errors();
            $errorMessage = "Кто-то попытался зарегистрироваться, но не прошел валидацию. Ошибки валидации: ";

            foreach ($validationErrors as $field => $messages) {
                $errorMessage .= "Поле \"$field\": " . implode(', ', $messages) . ". ";
            }

            Log::error($errorMessage);
            return response()->json(['error' => $e->validator->errors()->all()], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('I love laravel')->plainTextToken;

        Log::info("Зарегистрировался новый пользователь с ID " . $user->id);

        return response()->json([
            'status' => 'success',
            'message' => 'Пользователь создан успешно!',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ], 201);
    }


    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|string|email|min:3|max:50',
                'password' => 'required|string|min:8',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->validator->errors()->all()], 400);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            $user->tokens->each(function ($token) {
                $token->delete();
            });
            
            $token = $user->createToken('I love laravel')->plainTextToken;

            Log::info("Пользователь с ID " . Auth::id() . " вошел в свой аккаунт");

            $user->makeHidden('tokens');
            return response()->json([
                'status' => 'success',
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ], 200);
        }

        return response()->json([
            'message' => 'Unauthorized',
        ], 401);
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        $user->tokens->each(function ($token) {
            $token->delete();
        });

        Log::info("Пользователь с ID " . $user->id . " вышел из своего аккаунта");

        return response()->json([
            'status' => 'success',
            'message' => 'Успешно вышел из аккаунта',
        ], 200);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    public function users() {
        $users = User::get();
        return response()->json($users);
    }
}
