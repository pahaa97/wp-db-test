<?php

namespace App\Http\Controllers;

use App\Http\Resources\WpSiteResource;
use App\Repositories\WpSiteRepository;
use App\Services\WpAdminCheckerService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;

class WpSiteCheckController extends Controller
{
    protected WpSiteRepository $repository;
    protected WpAdminCheckerService $service;

    public function __construct(WpSiteRepository $repository, WpAdminCheckerService $service)
    {
        $this->service = $service;
        $this->repository = $repository;
    }

    /**
     * @param int $id
     * @return WpSiteResource
     * @throws GuzzleException
     */
    public function checkOne(int $id): WpSiteResource
    {
        $site = $this->repository->find($id);
        $checkedSite = $this->service->checkAdminLoginForSite($site);
        return new WpSiteResource($checkedSite);
    }

    /**
     * @return JsonResponse
     */
    public function checkAll(): JsonResponse
    {
        // Will be in queue
    }
}
