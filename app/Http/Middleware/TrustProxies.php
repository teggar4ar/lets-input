<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;

class TrustProxies extends Middleware
{
    /**
     * The trusted proxies for this application.
     *
     * @var array<int, string>|string|null
     */
    // Beritahu Laravel untuk mempercayai proxy yang mengirimkan permintaan.
    // Untuk Azure App Service, menggunakan '*' adalah cara yang paling mudah.
    protected $proxies = '*';

    /**
     * The headers that should be used to detect proxies.
     *
     * @var int
     */
    // Pastikan kita memberitahu Laravel untuk melihat header
    // yang menentukan apakah koneksi asli adalah http atau https.
    protected $headers = Request::HEADER_X_FORWARDED_PROTO;
}
