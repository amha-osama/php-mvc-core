<?php

namespace Osama\phpmvc;


class Application
{
    public Router $router;
    public Request $request;
    public View $view;
    public string $DIR;
    public static Application $app;
    public Controller $controller; 
    public MiddlewarePipeline $middlewarePipeline;           
    public function __construct(string $dir)
    {
        self::$app = $this;
        $this->DIR = $dir;
        $this->middlewarePipeline = new MiddlewarePipeline(); 
        $this->view = new View();
        $this->request = new Request();
        $this->router = new Router($this->request,$this->view,$this->middlewarePipeline);   
        $this->controller = new Controller($this->view);                                                      
        
    }

    public function run():void
    {
        try {

            $this->router->resolve();
        }
        catch (\Exception $e) {
            echo "An error occurred: " . $e->getMessage();
        }
       
    }

}

