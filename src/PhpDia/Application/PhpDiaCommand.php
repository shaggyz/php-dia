<?php

namespace PhpDia\Application;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class PhpDiaCommand extends Command
{
    const VERSION = '0.2.0';
    const NAME = 'phpdia';

    protected function configure()
    {
        $this->setName(static::NAME)
            ->setHelp("Creates GNU/Dia UML diagrams from PHP source code.");

        $this->addArgument(
            'source',
            InputArgument::REQUIRED,
            "The directory containing the PHP source code."
        );

        $this->addOption(
            'exclude',
            'e',
            InputOption::VALUE_OPTIONAL,
            "Comma separated list of dir/files to exclude."
        );

        $this->addOption(
            'output',
            'o',
            InputOption::VALUE_OPTIONAL,
            "Output path for diagram file.",
            $this->getDefaultOutputFile()
        );

        $this->addOption(
            'raw',
            'r',
            InputOption::VALUE_OPTIONAL,
            "Disable file compression"
        );
    }

    /**
     * @return string
     */
    private function getDefaultOutputFile() : string
    {
        return getcwd() . DIRECTORY_SEPARATOR . 'diagram.dia';
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $output->writeln("Starting phpdia...");
            $this->startCommand($input, $output);
        } catch (\Exception $exception) {
            $output->writeln(sprintf(
                "<error>%s</error>",
                $exception->getMessage()
            ));
            exit(1);
        }

        exit(0);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    private function startCommand(InputInterface $input, OutputInterface $output)
    {
        $generator = new Generator($input->getArgument('source'));

        if ($input->hasOption('exclude')) {
            $generator->setExcluded(explode(',', $input->getOption('exclude')));
        }

        if ($input->hasOption('raw')) {
            $generator->setCompress(false);
        }

        $file = $generator->generate();
        $file->save($input->getOption('output'));
    }

}