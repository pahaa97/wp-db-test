<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WpSiteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                        => $this->id,
            'site_url'                  => $this->site_url,
            'admin_url'                 => $this->admin_url,
            'admin_login'               => $this->admin_login,
            'admin_password'            => $this->admin_password,
            'server_host'               => $this->server_host,
            'server_password'           => $this->server_password,
            'server_login'              => $this->server_login,
            'cdn_name'                  => $this->cdn_name,
            'cdn_login'                 => $this->cdn_login,
            'cdn_password'              => $this->cdn_password,
            'admin_login_is_valid'      => $this->admin_login_is_valid,
            'last_admin_login_check_at' => $this->last_admin_login_check_at,
            'created_at'                => $this->created_at,
            'updated_at'                => $this->updated_at,
        ];
    }
}
