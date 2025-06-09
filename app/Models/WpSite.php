<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WpSite extends Model
{
    protected $table = 'wp_sites';

    protected $fillable = [
        'site_url',
        'admin_url',
        'admin_login',
        'admin_password',
        'server_host',
        'server_login',
        'server_password',
        'cdn_name',
        'cdn_login',
        'cdn_password',
        'admin_login_is_valid',
        'last_admin_login_check_at',
    ];

    protected $casts = [
        'admin_login_is_valid'      => 'boolean',
        'last_admin_login_check_at' => 'datetime',
        'admin_login'               => 'encrypted',
        'admin_password'            => 'encrypted',
        'server_login'              => 'encrypted',
        'server_password'           => 'encrypted',
        'cdn_login'                 => 'encrypted',
        'cdn_password'              => 'encrypted',
    ];
}
