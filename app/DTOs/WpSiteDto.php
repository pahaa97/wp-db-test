<?php

namespace App\DTOs;

readonly class WpSiteDto
{
    public function __construct(
        public string $site_url,
        public string $admin_url,
        public string $admin_login,
        public string $admin_password,
        public ?string $server_host = null,
        public ?string $server_login = null,
        public ?string $server_password = null,
        public ?string $cdn_name = null,
        public ?string $cdn_login = null,
        public ?string $cdn_password = null,
    ) {}

    public static function fromRequest(\Illuminate\Http\Request $request): self
    {
        return new self(
            site_url: $request->input('site_url'),
            admin_url: $request->input('admin_url'),
            admin_login: $request->input('admin_login'),
            admin_password: $request->input('admin_password'),
            server_host: $request->input('server_host'),
            server_login: $request->input('server_login'),
            server_password: $request->input('server_password'),
            cdn_name: $request->input('cdn_name'),
            cdn_login: $request->input('cdn_login'),
            cdn_password: $request->input('cdn_password'),
        );
    }

    public function toArray(): array
    {
        return [
            'site_url'        => $this->site_url,
            'admin_url'       => $this->admin_url,
            'admin_login'     => $this->admin_login,
            'admin_password'  => $this->admin_password,
            'server_host'     => $this->server_host,
            'server_login'    => $this->server_login,
            'server_password' => $this->server_password,
            'cdn_name'        => $this->cdn_name,
            'cdn_login'       => $this->cdn_login,
            'cdn_password'    => $this->cdn_password,
        ];
    }
}
