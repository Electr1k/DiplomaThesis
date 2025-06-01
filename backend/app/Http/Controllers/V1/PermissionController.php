<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionResource;
use App\Repositories\PermissionRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;


/**
 * Контрллер для разрешений
 */
class PermissionController extends Controller
{
    /**
     * Получение всех разрешений.
     */
    public function index(PermissionRepository $repository): AnonymousResourceCollection
    {
        return PermissionResource::collection($repository->getAll());
    }

}
