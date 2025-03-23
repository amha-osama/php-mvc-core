<?php

namespace Osama\phpmvc;

class View
{

    public function render($template ,$params = [])
    {

      try {
        $layout = $this->layout($template, $params);
        $mainLayout = $this->mainLayout("main");
        $mainLayout = str_replace('{content}', $layout, $mainLayout);
        echo $mainLayout;
       } catch (\Exception $e) {
        throw new \Exception("Failed to render view: {$template}. Error: " . $e->getMessage());
      }      
    }


    protected function layout($template,$params = [])
    {
      try {
        extract($params);
        ob_start();
        require_once Application::$app->DIR . "/src/view/layout/$template.php";
        return ob_get_clean();
      } catch (\Exception $e) {
        throw new \Exception("Failed to render layout: {$template}. Error: " . $e->getMessage());
      }

    }
    protected function mainLayout($template,$params = [])
    {
      try {
          extract($params);
          ob_start();
          require_once Application::$app->DIR . "/src/view/$template.php";
          return ob_get_clean();
      } catch (\Exception $e) {
          throw new \Exception("Failed to render main layout: {$template}. Error: " . $e->getMessage());
      }

    }
}