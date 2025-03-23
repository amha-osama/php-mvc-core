<?php

namespace Osama\phpmvc;

class Router
{

    private  array $routes = [];
    private Response $response;
    private  Request $request;
    private  View $view;
    private $url = "";
    private MiddlewarePipeline $middlewarePipeline;
    


    public function __construct(Request $request, View $view,MiddlewarePipeline $middlewarePipeline)
    {
        $this->request = $request;
        $this->response = new Response();
        $this->view = $view;
        $this->middlewarePipeline = $middlewarePipeline;
    }
    public function get(string $url, callable|array|string $callback)
    {
        $this->routes['get'][$url] = $callback;
        $this->url = $url;
        return $this;
    }

    public function post(string $url, callable|array|string $callback)
    {
        $this->routes['post'][$url] = $callback;
        $this->url = $url;
        return $this;
    }

    public function add($middleware):void
    {
        $this->middlewarePipeline->add($middleware);
        // $this->middlewarePipeline->handle($this->request);
        if($this->url == $this->request->getPath())
        {
            $this->middlewarePipeline->handle($this->request);

        }
    }

    public function resolve(): void
    {
        $method = $this->request->getMethod();
        $path = $this->request->getPath();

        $callback = $this->routes[$method][$path] ?? false;
         
        if (!$callback) {
            $this->response->SetStatusCode(404);
            $this->view->render('404', []); // Render a 404 view
            return; // Stop further execution
        }

        if (is_array($callback)) {

            $callback[0] = new $callback[0]($this->view); // Instantiate the controller
            call_user_func($callback, $this->request); // Pass the request object
        }
        else if (is_string($callback)) {
            $this->view->render($callback, []); // Render the view
        }
        else {
            call_user_func( $callback,$this->request);
        }

    }


}