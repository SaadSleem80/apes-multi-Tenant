<?php

namespace Modules\Tenants\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MainController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Tenants\App\Http\Resources\TenantResource;
use Symfony\Component\HttpFoundation\Response;

class TenantsController extends MainController
{
    /**
     * Display Details of the Tenant.
     * @OA\Get(
     *  path="/api/v1/tenants",
     *  tags={"Tenants"},
     *  summary="Get Tenant Details",
     *  @OA\Response(response="200", description="success"),
     * )
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $response = app('currentTenant');
        return $this->response('success' , new TenantResource($response), Response::HTTP_OK);
    }
}
