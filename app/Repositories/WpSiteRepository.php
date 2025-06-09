<?php

namespace App\Repositories;

use App\DTOs\WpSiteDto;
use App\Models\WpSite;

class WpSiteRepository extends BaseRepository
{
    public function __construct()
    {
        $this->modelClass = WpSite::class;
    }

    /**
     * @param WpSiteDto $dto
     * @return WpSite
     */
    public function create(WpSiteDto $dto): WpSite
    {
        return WpSite::create($dto->toArray());
    }

    /**
     * @param int $id
     * @param WpSiteDto $dto
     * @return WpSite
     */
    public function update(int $id, WpSiteDto $dto): WpSite
    {
        $wpSite = $this->find($id);
        $wpSite->update($dto->toArray());
        return $wpSite;
    }

    /**
     * @param WpSite $site
     * @param bool $isValid
     * @return void
     */
    public function updateAdminLoginCheck(WpSite $site, bool $isValid): void
    {
        $site->update([
            'admin_login_is_valid' => $isValid,
            'last_admin_login_check_at' => now(),
        ]);
    }
}
