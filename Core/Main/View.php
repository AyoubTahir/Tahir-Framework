<?php

declare(strict_types=1);

namespace Tahir\Core\Main;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use Tahir\Core\Twig\TwigExtension;
use Exception;

class View
{
    public function getTemplate(string $template, array $context = [])
    {
        $twigConfig = require_once(ROOT_PATH . '/Config/twig.php');

        static $twig;

        if ($twig === null)
        {
            $loader = new FilesystemLoader('Views', ROOT_PATH . '/App');
            $twig = new Environment($loader, $twigConfig);
            $twig->addExtension(new DebugExtension());
            $twig->addExtension(new TwigExtension());
        }

        return $twig->render($template, $context);
    }

    public function twigRender(string $template, array $context = [])
    {
        echo $this->getTemplate($template, $context);
    }

}