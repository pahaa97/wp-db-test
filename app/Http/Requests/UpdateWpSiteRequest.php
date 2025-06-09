<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWpSiteRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'site_url'       => ['sometimes', 'url', 'unique:wp_sites,site_url,' . $this->route('id')],
            'admin_url'      => ['sometimes', 'url', 'unique:wp_sites,admin_url,' . $this->route('id')],
            'admin_login'    => ['sometimes', 'string', 'max:255'],
            'admin_password' => ['sometimes', 'string', 'max:255'],
            'server_host'    => ['nullable', 'string', 'max:255'],
            'server_login'   => ['nullable', 'string', 'max:255'],
            'server_password'=> ['nullable', 'string', 'max:255'],
            'cdn_name'       => ['nullable', 'string', 'max:255'],
            'cdn_login'      => ['nullable', 'string', 'max:255'],
            'cdn_password'   => ['nullable', 'string', 'max:255'],
        ];
    }
}
