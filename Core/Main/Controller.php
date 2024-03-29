<?php

declare(strict_types=1);

namespace Tahir\Core\Main;

use Magma\Base\Exception\BaseBadMethodCallException;
use Magma\Base\Exception\BaseInvalidArgumentException;
use Magma\Base\Exception\BaseLogicException;

use Tahir\Core\Main\View;

class Controller
{


    public function __construct()
    {
        $this->twig = new View();
    }

    /**
     * Renders a view template from sub controller classes
     *
     * @param string $template
     * @param array $context
     * @return Response
     */
    public function render(string $template, array $context = [])
    {
        if ($this->twig === null)
        {
            throw new BaseLogicException('You cannot use the render method if the twig bundle is not available.');
        }
        return $this->twig->twigRender($template, $context);
    }

    /**
     * Magic method called when a non-existent or inaccessible method is
     * called on an object of this class. Used to execute before and after
     * filter methods on action methods. Action methods need to be named
     * with an "Action" suffix, e.g. indexAction, showAction etc.
     *
     * @param $name
     * @param $arguments
     * @throws BaseBadMethodCallException
     * @return void
     */
    public function __call($name, $arguments) : void
    {
        $method = $name . 'Action';
        if (method_exists($this, $method)) {
            if ($this->before() !== false) {
                call_user_func_array([$this, $method], $arguments);
                $this->after();
            }
        } else {
            throw new BaseBadMethodCallException('Method ' . $method . ' does not exist in ' . get_class($this));
        }
    }

    /**
     * Before method which is called before a controller method
     *
     * @return void
     */
    protected function before()
    {}

    /**
     * After method which is called after a controller method
     *
     * @return void
     */
    protected function after()
    {}

}