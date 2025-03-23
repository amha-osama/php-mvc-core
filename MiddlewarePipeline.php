<?php
namespace Osama\phpmvc;

class MiddlewarePipeline
{

    private array $middlewares = [];

    public function add(Middleware $middleware):void
    {
        $this->middlewares[] = $middleware;
    }

    public function handle(Request $request):Response
    {
        
        $next = function (Request $request):Response {

            $response = new Response();
            $response->SetStatusCode(200);
            return $response;
        };

        foreach (array_reverse($this->middlewares) as $middleware) {

            $next = function (Request $request) use ($middleware,$next):Response {
                return $middleware->handle($request,$next);
            };
        }

        return $next($request);

    }
}