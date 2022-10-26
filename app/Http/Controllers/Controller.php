<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\OpenApi(
 *  @OA\Info(
 *      title="HomeWork API",
 *      version="1.0.0",
 *      description="10 API",
 *      @OA\Contact(
 *          email="johnnyshih@25sprout.com"
 *      ),
 *  ),
 *  @OA\Server(
 *      description="local",
 *      url="http://127.0.0.1:8000/api"
 *  ),
 *  @OA\PathItem(
 *      path="/"
 *  )
 * )
 */

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
