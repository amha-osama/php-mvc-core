<?php

namespace Osama\phpmvc;


class Request
{
    protected Validated $validated;

    public function __construct()
    {
        $this->validated = new Validated();
    }


    public function getMethod():string
    {
        $method = strtolower($_SERVER["REQUEST_METHOD"]);

        return $method;
    }

    public function getPath():string
    {
        $path = $_SERVER["PATH_INFO"] ?? '/';
        
        return $path;
    }

    public function isPost():bool
    {
        $method = strtolower($_SERVER["REQUEST_METHOD"]);

        return $method == "post";
    }

    public function getBody():array
    {
        $body = [];

        if ($this->isPost()) {
            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        return $body;
    }

    public function validate(array $rule = [])
    {
        return $this->validated->validate($this->getBody(),$rule);

    }
    public function isValid():bool
    {
        return $this->validated->isValid();
    }
   

}