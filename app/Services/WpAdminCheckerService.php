<?php

namespace App\Services;

use App\Models\WpSite;
use App\Repositories\WpSiteRepository;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\DomCrawler\Crawler;

class WpAdminCheckerService
{
    protected WpSiteRepository $repository;

    /**
     * @param WpSiteRepository $repository
     */
    public function __construct(WpSiteRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param WpSite $site
     * @return WpSite
     * @throws GuzzleException
     */
    public function checkAdminLoginForSite(WpSite $site): WpSite
    {
        $isValid = WpAdminCheckerService::check($site);

        $this->repository->updateAdminLoginCheck($site, $isValid);

        return $site->fresh();
    }

    /**
     * @param WpSite $site
     * @return bool
     * @throws GuzzleException
     */
    public static function check(WpSite $site): bool
    {
        $cookieJar = new \GuzzleHttp\Cookie\CookieJar();
        $client = new \GuzzleHttp\Client(['cookies' => $cookieJar, 'http_errors' => false]);
        $loginUrl = rtrim($site->site_url, '/') . '/wp-login.php?session=' . mt_rand(100000,999999) . '&ts=' . time();

        try {
            $response = $client->get($loginUrl, [
                'cookies' => $cookieJar,
                'headers' => [
                    'Referer' => $loginUrl,
                    'Origin' => $site->site_url,
                    'Cache-Control' => 'no-cache',
                    'Pragma' => 'no-cache',
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36'
                ]
            ]);

            $html = $response->getBody()->getContents();

            $crawler = new Crawler($html);
            $wpSubmitValue = $crawler->filter('#wp-submit')->attr('value');

            $response = $client->post($loginUrl, [
                'cookies' => $cookieJar,
                'form_params' => [
                    'log' => $site->admin_login,
                    'pwd' => $site->admin_password,
                    'wp-submit' => $wpSubmitValue,
                    'redirect_to' => $site->admin_url,
                    'testcookie' => 1,
                ],
                'allow_redirects' => false,
                'headers' => [
                    'Referer' => $loginUrl,
                    'Origin' => $site->site_url,
                    'Cache-Control' => 'no-cache',
                    'Pragma' => 'no-cache',
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36'
                ]
            ]);

            return $response->getStatusCode() === 302;
        } catch (\Exception $e) {
            return false;
        }
    }
}
