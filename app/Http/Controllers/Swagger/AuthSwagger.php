<?php

namespace App\Http\Controllers\Swagger;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *   title="Swagger Doc API",
 *   version="1.0.0",
 *   description="API для управления пользователями",
 *   @OA\Contact(
 *     email="qq13kk@gmail.com"
 *   )
 * )
* @OA\SecurityScheme(
 *   securityScheme="sanctum",
 *   type="http",
 *   scheme="bearer",
 *   bearerFormat="JWT"
 * )
 */
class AuthSwagger
{
    /**
     * @OA\Post(
     *   path="/api/register",
     *   summary="Регистрация нового пользователя",
     *   tags={"Auth"},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       required={"name", "email", "password"},
     *       @OA\Property(property="name", type="string", example="Test"),
     *       @OA\Property(property="email", type="string", format="email", example="test@gmail.com"),
     *       @OA\Property(property="password", type="string", format="password", example="12345678")
     *     )
     *   ),
     *   @OA\Response(
     *     response=201,
     *     description="Пользователь успешно создан",
     *     @OA\JsonContent(
     *       @OA\Property(property="status", type="string", example="success"),
     *       @OA\Property(property="message", type="string", example="Пользователь создан успешно!"),
     *       @OA\Property(property="user", type="object",
     *         @OA\Property(property="name", type="string", example="Test"),
     *         @OA\Property(property="email", type="string", example="test@gmail.com"),
     *         @OA\Property(property="id", type="string", example="1"),
     *       ),
     *       @OA\Property(property="authorisation", type="object",
     *         @OA\Property(property="token", type="string", example="1|NqCS5fN0rlm81FsqkxuoD5W7LVJi25qjXP62fgHM465688fe"),
     *         @OA\Property(property="type", type="string", example="bearer")
     *       )
     *     )
     *   ),
     *   @OA\Response(response=400, description="Ошибка валидации")
     * )
     */
    public function register() {}

    /**
     * @OA\Post(
     *   path="/api/login",
     *   summary="Авторизация пользователя",
     *   tags={"Auth"},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       required={"email", "password"},
     *         @OA\Property(property="email", type="string", example="test@gmail.com"),
     *         @OA\Property(property="password", type="string", example="12345678"),
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Успешный вход",
     *     @OA\JsonContent(
     *       @OA\Property(property="status", type="string", example="success"),
     *       @OA\Property(property="user", type="object",
     *         @OA\Property(property="id", type="string", example="1"),
     *         @OA\Property(property="name", type="string", example="Test"),
     *         @OA\Property(property="email", type="string", example="test@gmail.com"),
     *       ),
     *       @OA\Property(property="authorisation", type="object",
     *         @OA\Property(property="token", type="string", example="1|NqCS5fN0rlm81FsqkxuoD5W7LVJi25qjXP62fgHM465688fe"),
     *         @OA\Property(property="type", type="string", example="bearer")
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *      response=401, 
     *      description="Error: Unauthorized",
     *      @OA\JsonContent(
     *         @OA\Property(property="message", type="string", example="Unauthorized"),
     *      )
     *   ),
     *   @OA\Response(response=400, description="Ошибка валидации")
     * )
     */
    public function login() {}

    /**
     * @OA\Post(
     *   path="/api/logout",
     *   summary="Выход пользователя",
     *   tags={"Auth"},
     *   security={{ "sanctum":{} }},
     *   @OA\Response(
     *     response=200,
     *     description="Успешный выход",
     *     @OA\JsonContent(
     *       @OA\Property(property="status", type="string", example="success"),
     *       @OA\Property(property="message", type="string", example="Успешно вышел из аккаунта")
     *     )
     *   ),
     *   @OA\Response(
     *      response=401, 
     *      description="Error: Unauthorized",
     *      @OA\JsonContent(
     *         @OA\Property(property="message", type="string", example="Unauthenticated"),
     *      )
     *   ),
     * )
     */
    public function logout() {}

    /**
     * @OA\Get(
     *   path="/api/user",
     *   summary="Получить информацию о текущем пользователе",
     *   tags={"Auth"},
     *   security={{ "sanctum":{} }},
     *   @OA\Response(
     *     response=200,
     *     description="Информация о пользователе",
     *     @OA\JsonContent(
     *        @OA\Property(property="id", type="integer", example=1),
     *        @OA\Property(property="name", type="string", example="Test"),
     *        @OA\Property(property="email", type="string", example="test@gmail.com")
     *     )
     *   ),
     *   @OA\Response(
     *      response=401, 
     *      description="Error: Unauthorized",
     *      @OA\JsonContent(
     *         @OA\Property(property="message", type="string", example="Unauthenticated"),
     *      )
     *   ),
     * )
     */
    public function user() {}

    /**
     * @OA\Get(
     *   path="/api/users",
     *   summary="Получить список всех пользователей",
     *   tags={"Auth"},
     *   security={{ "sanctum":{} }},
     *   @OA\Response(
     *     response=200,
     *     description="Список пользователей",
     *     @OA\JsonContent(
     *       type="array",
     *       @OA\Items(
     *         @OA\Property(property="id", type="integer", example=1),
     *         @OA\Property(property="name", type="string", example="Test"),
     *         @OA\Property(property="email", type="string", example="test@gmail.com")
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *      response=401, 
     *      description="Error: Unauthorized",
     *      @OA\JsonContent(
     *         @OA\Property(property="message", type="string", example="Unauthenticated"),
     *      )
     *   ),
     * )
     */
    public function users() {}

    /**
     * @OA\SecurityScheme(
     *   securityScheme="sanctum",
     *   type="http",
     *   scheme="bearer",
     *   bearerFormat="JWT"
     * )
     */
}
