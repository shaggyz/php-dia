<?php

namespace PhpDia\Application;

use cli\Arguments;

class PhpDia
{
    /** @var Arguments */
    protected $arguments;

    const VERSION = '0.2.0';

    private function __construct()
    {
        $this->arguments = $this->parseArguments();

        try {
            \cli\line($this->processInput());
        } catch (\Exception $exception) {
            \cli\line(sprintf(
                "Application error: %s",
                $exception->getMessage()
            ));
            exit(1);
        }

        exit(0);
    }

    /**
     * @return string
     */
    protected function processInput() : string
    {
        if ($this->arguments['version']) {
            return $this->getShowVersion();
        }

        return $this->arguments->getHelpScreen();
    }

    /**
     * @return string
     */
    protected function getShowVersion() : string
    {
        return "Version: " . static::VERSION;
    }

    /**
     * @return static
     */
    public static function bootstrap()
    {
        return new static();
    }

    /**
     * @return Arguments
     */
    protected function parseArguments() : Arguments
    {
        $arguments = new Arguments();

        $arguments->addFlag(['verbose', 'v'], 'Turn on verbose output');
        $arguments->addFlag('version', 'Display the version');
        $arguments->addFlag(['help', 'h'], 'Show this help screen');

        $arguments->parse();

        if ($this->arguments['help']) {
            echo $arguments->getHelpScreen();
            exit(0);
        }

        return $arguments;
    }
}
