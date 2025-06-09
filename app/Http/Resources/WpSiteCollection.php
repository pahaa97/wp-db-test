<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class WpSiteCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($site) {
                return [
                    'id' => $site->id,
                    'site_url' => $site->site_url,
                    'admin_url' => $site->admin_url,
                    'admin_login_is_valid' => $site->admin_login_is_valid,
                    'last_admin_login_check_at' => $site->last_admin_login_check_at,
                ];
            }),
        ];
    }
}
