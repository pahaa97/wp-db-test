<?php

namespace App\Services;

use App\DTOs\WpSiteDto;
use App\Models\WpSite;
use App\Repositories\WpSiteRepository;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Pagination\LengthAwarePaginator;

class WpSiteService
{
    protected WpSiteRepository $repository;
    protected WpAdminCheckerService $checker;

    /**
     * @param WpSiteRepository $repository
     * @param WpAdminCheckerService $checker
     */
    public function __construct(
        WpSiteRepository $repository,
        WpAdminCheckerService $checker
    ) {
        $this->repository = $repository;
        $this->checker = $checker;
    }

    /**
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->getAllPaginated($perPage);
    }

    /**
     * @param int $id
     * @return WpSite
     */
    public function getById(int $id): WpSite
    {
        return $this->repository->find($id);
    }

    /**
     * @param WpSiteDto $dto
     * @return WpSite
     * @throws GuzzleException
     */
    public function create(WpSiteDto $dto): WpSite
    {
        $wpSite = $this->repository->create($dto);
        return $this->checker->checkAdminLoginForSite($wpSite);
    }

    /**
     * @param int $id
     * @param WpSiteDto $dto
     * @return WpSite
     */
    public function update(int $id, WpSiteDto $dto): WpSite
    {
        return $this->repository->update($id, $dto);
    }

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }
}
