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
     * @return static
     */
    public static function bootstrap()
    {
        return new static();
    }

    /**
     * @return string
     */
    protected function processInput() : string
    {
        if ($this->arguments['version']) {
            return $this->getShowVersion();
        }

        if ($this->arguments['help']) {
            return $this->getShowHelp();
        }

        $this->startProgram(
            $this->arguments['output'],
            $this->arguments['source']
        );

        return 'End.';
    }

    private function getShowHelp() : string
    {
        return "PhPDia "
            . $this->getShowVersion()
            . PHP_EOL
            . "Creates GNU/Dia UML diagrams from PHP source code"
            . PHP_EOL . PHP_EOL
            . $this->arguments->getHelpScreen();
    }

    /**
     * @return string
     */
    protected function getShowVersion() : string
    {
        return "Version: " . static::VERSION;
    }

    /**
     * @param string $output
     * @param string $source
     * @return bool
     */
    protected function startProgram(string $output, string $source) : bool
    {
        $generator = new Generator($output, $source);

        if ($this->arguments['exclude']) {
            $generator->setExcluded(explode(',', $this->arguments['exclude']));
        }

        if ($this->arguments->isFlag('raw')) {
            $generator->setCompress(false);
        }

        $generator->generate();
        return true;
    }

    /**
     * @return Arguments
     */
    protected function parseArguments() : Arguments
    {
        $arguments = new Arguments();
        $arguments->addFlag('version', 'Display the version');
        $arguments->addFlag(['help', 'h'], 'Show this help screen');
        $arguments->addFlag(['raw', 'h'], 'Disable file compression');

        $arguments->addOption(['source', 's'], [
            'description' => 'Set the source code directory or file to parse. ',
            'default' => '.'
        ]);

        $arguments->addOption(['exclude', 'e'], [
            'description' => 'List of directories to exclude',
        ]);

        $arguments->addOption(['output', 'o'], [
            'description' => 'Output file name.',
            'default' => 'diagram'
        ]);

        $arguments->parse();

        return $arguments;
    }
}
