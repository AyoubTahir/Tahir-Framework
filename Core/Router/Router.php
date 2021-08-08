<?php

declare(strict_types=1);

namespace Tahir\Core\Router;

use Tahir\Core\Router\Exceptions\PageNotFoundException;
use Tahir\Core\Request\Request;

class Router
{

    public array $routeParams  = [];
    protected array $urlParams = [];


    private function urlMatchStoredRoutes( array $routes, string $url ,string $requestMethod) : bool
    {
        if( count($routes)  > 0 )
        {
            foreach( $routes as $params )
            {
                $urlParts  = explode('/',trim($url,'/'));

                $routePart = explode('/',trim($params['route'],'/'));

                if ( count($routePart) == count($urlParts)  )
                { 

                    if(strpos($params['route'], '{') !== false && $requestMethod == 'GET')
                    {
                        
                        $inc = 0;

                        for ( $i = 0 ; $i<count($routePart); $i++ )
                        {
                            if(strpos($routePart[$i], '{') !== false){

                                $cleanParam = str_replace(str_split('{}'), '', $routePart[$i] );
                                $this->urlParams[$cleanParam] = $urlParts[$i];
                                $inc++;
                            }
                        }

                        $matchs = array_intersect($routePart,$urlParts);

                        if( count($matchs) == $inc)
                        {
                            $this->routeParams = $params;

                            return true;
                        }

                        return false;
                    }
                    
                }
                if( $params['route'] == $url && strtoupper($params['method']) == $requestMethod)
                {  
                    $this->routeParams = $params;

                    return true;
                }
            }
        }

        return false;
    }


    public function dispatch(array $routes, string $url ,string $requestMethod) 
    { 
        
        if (!$this->urlMatchStoredRoutes($routes,$url,$requestMethod))
        {
            http_response_code(404);
            throw new PageNotFoundException('404 ERROR no page found');
        }

        if(isset($this->routeParams['controller']) && $this->routeParams['controller'] != '')
        {
            $controllerString = $this->getNamespace() . $this->routeParams['controller'];
        }
        else
        {
            throw new ControllerNotFoundException('Controller should not be empty in your routes file');
        }


        if (!class_exists($controllerString))
        {
            throw new ControllerNotFoundException('Controller '.$this->routeParams['controller'].' class does not exist');
        }

        $controllerObject = new $controllerString();
        $action = $this->routeParams['action'];

        if (!\is_callable([$controllerObject, $action]))
        {
            throw new BadMethodCallException('Invalid method');
        }

        $this->RequestProcess();

        if( count($this->urlParams) )
        {
            return call_user_func_array([$controllerObject,$action],$this->urlParams);
        }
        
        return call_user_func([$controllerObject,$action]);
        
    }

    private function RequestProcess()
    {
        $request = new Request();
        $cleanData = $request->cleanRequest();
        if(count($cleanData) > 0)
        {
            $this->urlParams['request'] = $cleanData;
        }
        
    }


    private function getNamespace() : string
    {
        $namespace = 'Tahir\App\Controllers\\';
        
        return $namespace;
    }
    
}