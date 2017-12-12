<?php

namespace App\Http\Middleware;

use Closure;
use Laravel\Passport\Client;

class Cors
{
    public function __construct(Client $clients)
    {
        $this->clients = $clients;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //Here we put our client domains
        //$trusted_domains = ["http://localhost:4200", "https://wishlist-client.herokuapp.com"];
        /*TODO put this code in the model*/
        $trusted_domains = $this->clients->select('redirect')
            ->pluck('redirect')->toArray();
        if(isset($request->server()['HTTP_ORIGIN'])) {
            $origin = $request->server()['HTTP_ORIGIN'];
            if(in_array($origin, $trusted_domains)) {
                header('Access-Control-Allow-Origin: ' . $origin);
                header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
                header('Access-Control-Allow-Headers: Origin, Content-Type, Authorization');
            }
        }
        return $next($request);
    }
}
