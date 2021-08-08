<?php

namespace Tahir\Core\Request;

use Tahir\Core\Sanitizer\Sanitizer;

class Request
{
    public function requestMethod()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function getUrl()
    {
        $path = $_SERVER['QUERY_STRING'];
        return $path;
    }

    public function isGet()
    {
        return $this->requestMethod() === 'get';
    }

    public function isPost()
    {
        return $this->requestMethod() === 'post';
    }

    public function cleanRequest()
    {
        $data = [];

        if ($this->isGet())
        {
            foreach ($_GET as $key => $value)
            {
                $data[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }

            $sanitizer = new Sanitizer();
            $data = $sanitizer->clean($_GET);
        }
        if ($this->isPost())
        {
            foreach ($_POST as $key => $value)
            {
                $data[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }

            $sanitizer = new Sanitizer();
            $data = $sanitizer->clean($_POST);
        }
        return $_POST;
    }
}