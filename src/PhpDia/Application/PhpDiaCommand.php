<?php

namespace PhpDia\Application;

use PhpDia\Application\Event\DebugEvent;
use PhpDia\Application\Event\FileParsedEvent;
use PhpDia\Application\Event\MessageEvent;
use PhpDia\Application\Event\TotalFilesAcquiredEvent;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use League\Event\Emitter;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class PhpDiaCommand extends Command
{
    /** @var ProgressBar */
    private $progressBar;

    const VERSION = '0.2.0';
    const NAME = 'phpdia';

    protected function configure()
    {
        $this->setName(static::NAME)
            ->setHelp("Creates GNU/Dia UML diagrams from PHP source code.");

        // Args
        $this->addArgument(
            'source',
            InputArgument::REQUIRED,
            "The directory containing the PHP source code."
        );

        // Options
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

        // Flags
        $this->addOption(
            'confirm',
            'c',
            InputOption::VALUE_NONE,
            "Confirm the file list before parse."
        );

        $this->addOption(
            'raw',
            'r',
            InputOption::VALUE_NONE,
            "Disable file compression"
        );

        $this->addOption(
            'debug',
            'd',
            InputOption::VALUE_NONE,
            "Enable debug output."
        );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $emitter = $this->configureEvents($input, $output);
            $this->startCommand($input, $output, $emitter);
            $this->finishProgress($output);
            $output->writeln("Finished, file saved.");
        } catch (\Exception $exception) {
            $output->writeln(sprintf(
                "<error>Error: %s</error>",
                $exception->getMessage()
            ));
            exit(1);
        }

        exit(0);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return Emitter
     */
    private function configureEvents(InputInterface $input, OutputInterface $output) : Emitter
    {
        $emitter = new Emitter;

        $emitter->addListener('MessageEvent',
            function (MessageEvent $event) use ($output) {
                $output->writeln(sprintf(
                    "<info>%s</info>",
                    $event->getMessage()
                ));
            }
        );

        $emitter->addListener('TotalFilesAcquiredEvent',
            function (TotalFilesAcquiredEvent $event) use ($input, $output) {
                $output->writeln(sprintf(
                    "Parsing %s files found in %s...%s",
                    $event->getTotal(),
                    $event->getPath(),
                    PHP_EOL
                ));
                if (!$input->getOption('debug')) {
                    $this->startProgress($event, $output);
                }
            }
        );

        $emitter->addListener('FileParsedEvent',
            function (FileParsedEvent $event) use ($input, $output) {
                $message = sprintf("Parsed: %s", $event->getFileName());
                if ($this->progressBar) {
                    $this->progressBar->setMessage($message);
                    $this->progressBar->advance();
                } else {
                    $output->writeln($message);
                }
            }
        );

        $emitter->addListener('DebugEvent',
            function (DebugEvent $event) use ($input, $output) {
                if ($input->getOption('debug')) {
                    $output->writeln("DEBUG: " . $event->getMessage());
                }
            }
        );

        return $emitter;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param Emitter $emitter
     */
    private function startCommand(InputInterface $input, OutputInterface $output, Emitter $emitter)
    {
        $generator = new Generator($input->getArgument('source'), $emitter);

        if ($input->getOption('confirm') &&
            !$this->confirmFileList($input, $output, $generator->getFileList())) {
            $output->writeln("Aborted by user.");
            exit(130);
        }

        if ($input->getOption('exclude')) {
            $generator->setExcluded(explode(',', $input->getOption('exclude')));
        }

        if ($input->getOption('raw')) {
            $generator->setCompress(false);
        }

        $file = $generator->generate();
        $file->save($input->getOption('output'));
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param array $fileList
     * @return bool
     */
    private function confirmFileList(InputInterface $input, OutputInterface $output, array $fileList) : bool
    {
        $table = new Table($output);
        $table->setHeaders(["File path"])
            ->setRows(array_map(function (string $file) {
                return [$file];
            }, $fileList));
        $table->render();

        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion('Continue with this file list? ', false);

        return $helper->ask($input, $output, $question);
    }

    /**
     * @return string
     */
    private function getDefaultOutputFile() : string
    {
        return getcwd() . DIRECTORY_SEPARATOR . 'diagram.dia';
    }

    /**
     * @param TotalFilesAcquiredEvent $event
     * @param OutputInterface $output
     */
    private function startProgress(TotalFilesAcquiredEvent $event, OutputInterface $output)
    {
        $progressBar = new ProgressBar($output, $event->getTotal());
        $progressBar->setBarWidth(70);
        $progressBar->setFormatDefinition('custom', " %current%/%max% -- [%bar%]\n %percent%% %message%\n");
        $progressBar->setFormat('custom');
        $progressBar->start();
        $this->progressBar = $progressBar;
    }

    /**
     * @param OutputInterface $output
     */
    private function finishProgress(OutputInterface $output)
    {
        if ($this->progressBar) {
            $this->progressBar->setMessage("All files parsed.");
            $this->progressBar->finish();
            $output->writeln("");
        }
    }
}