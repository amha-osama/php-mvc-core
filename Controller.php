<?php 

namespace Osama\phpmvc;
require_once Application::$app->DIR."/bootstrap.php";


class Controller
{
    private View $view;

    private Response $response;

    public function __construct(View $view)
    {
        $this->view = $view;
        $this->response = new Response();
    }
    public function render(string $view, array $data = []): void
    {
        try {
            $this->view->render($view, $data);
        } catch (\Exception $e) {
            throw new \Exception("Failed to render view: {$view}. Error: " . $e->getMessage());
        }
    }
    public function redirect(string $url): void
    {
        try {
            $this->response->redirect($url);
        } catch (\Exception $e) {
            throw new \Exception("Failed to redirect to: {$url}. Error: " . $e->getMessage());
        }
    }
}