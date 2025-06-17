<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Trip;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Apes APIs Documentation",
 *      description="Apes APIs Documentation for Laravel API"
 * )
 */

class MainController extends Controller
{
    public function response($status , $data, $code = 200)
    {
        return response()->json(['status' => $status , 'data' => $data, 'code' => $code] ,  $code);
    }

    public function paginatedResponse($status , $data, $code = 200)
    {
        $responseData = [
            "data" => $data,
            "count" => (int)$data->count(),
            "total" => (int)$data->total(),
            "last_page" => (int)$data->lastPage(),
            "per_page" => (int)$data->perPage(),
            "current_page" => (int)$data->currentPage(),
            "prev_page_url" => $data->previousPageUrl(),
            "next_page_url" => $data->nextPageUrl(),
        ];

        return response()->json([
        'status' => $status ,
        'data' => $responseData,
        'code' => $code] ,  $code);
    }
}