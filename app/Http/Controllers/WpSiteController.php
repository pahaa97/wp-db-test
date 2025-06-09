<?php

namespace App\Http\Controllers;

use App\DTOs\WpSiteDto;
use App\Http\Requests\StoreWpSiteRequest;
use App\Http\Requests\UpdateWpSiteRequest;
use App\Http\Resources\WpSiteCollection;
use App\Http\Resources\WpSiteResource;
use App\Services\WpSiteService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WpSiteController extends Controller
{
    protected WpSiteService $service;

    /**
     * @param WpSiteService $service
     */
    public function __construct(WpSiteService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @return WpSiteCollection
     */
    public function index(Request $request): WpSiteCollection
    {
        $wpSites = $this->service->getAllPaginated($request->get('per_page', 10));
        return new WpSiteCollection($wpSites);
    }

    /**
     * @param int $id
     * @return WpSiteResource
     */
    public function show(int $id): WpSiteResource
    {
        $wpSite = $this->service->getById($id);
        return new WpSiteResource($wpSite);
    }

    /**
     * @param StoreWpSiteRequest $request
     * @return JsonResponse
     * @throws GuzzleException
     */
    public function store(StoreWpSiteRequest $request): JsonResponse
    {
        $dto = WpSiteDto::fromRequest($request);
        $wpSite = $this->service->create($dto);

        return response()->json(new WpSiteResource($wpSite), 201);
    }

    /**
     * @param UpdateWpSiteRequest $request
     * @param int $id
     * @return WpSiteResource
     */
    public function update(UpdateWpSiteRequest $request, int $id): WpSiteResource
    {
        $dto = WpSiteDto::fromRequest($request);
        $wpSite = $this->service->update($id, $dto);

        return new WpSiteResource($wpSite);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->service->delete($id);

        return response()->json(null, 204);
    }
}
