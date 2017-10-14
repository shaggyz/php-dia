<?php

namespace PhpDia\Dia;

use Twig_Environment;
use Twig_Loader_Filesystem;

class TemplateManager
{
    /**
     * @var Twig_Environment
     */
    protected $twig;

    const TEMPLATES_PATH = __DIR__ . '/Templates';

    private function __construct()
    {
        $this->twig = $this->createTwigEnvironment();
    }

    /**
     * @return static
     */
    public static function create()
    {
        return new static();
    }

    /**
     * @param string $template
     * @param array $data
     * @return string
     */
    public function render(string $template, array $data = []) : string
    {
        return $this->twig->render($template, $data);
    }

    /**
     * @return Twig_Environment
     */
    protected function createTwigEnvironment() : Twig_Environment
    {
        $loader = new Twig_Loader_Filesystem(static::TEMPLATES_PATH);
        return new Twig_Environment($loader);
    }
}