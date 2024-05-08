<?php

namespace App\Http\Controllers;

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
    //
}
