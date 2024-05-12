<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     in="header",
 *     name="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 * )
 * Class Controller
 * @package App\Http\Controllers
 * @OA\Info(title="API List", version="1.0")
 */
abstract class Controller
{
    use AuthorizesRequests;

    public function user(): User
    {
        /** @var User $currentUser */
        $currentUser = auth()->user();

        return $currentUser;
    }
}
