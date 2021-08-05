<?php
namespace App\Http\Middleware;

use App\Services\Environment;
use Closure;

class CorsMiddleware
{
    private $environment;

    public function __construct()
    {
        $this->environment = new Environment;
    }

    public function handle($request, Closure $next)
    {
        $headers = [
            'Access-Control-Allow-Origin'      => $this->environment->getCorsOrigin(),
            'Access-Control-Allow-Methods'     => 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Allow-Headers'     => 'Content-Type, Authorization, X-Requested-With'
        ];
        if ($request->isMethod('OPTIONS')) {
            return response()->json('{"method":"OPTIONS"}', 200, $headers);
        }
        $response = $next($request);
        foreach($headers as $key => $value) {
            $response->header($key, $value);
        }
        return $response;
    }
}