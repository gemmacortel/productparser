<?php

namespace App\Infrastructure\Command;

use App\Infrastructure\Parser\FeedParser;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ParseProductsCommand extends Command
{
    protected static $defaultName = 'parse-products';

    /**
     * @var FeedParser
     */
    private $parser;

    public function __construct($name = null, FeedParser $parser)
    {
        parent::__construct($name);
        $this->parser = $parser;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Parse products from XML file')
            ->addArgument('feed', InputArgument::REQUIRED, 'XML url')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $feed = $input->getArgument('feed');

        try {
            $this->parser->parse($feed);
        } catch (\Exception $e) {
            $io->error($e->getMessage());

            return 1;

        }

        $io->success('Done!');

        return 0;
    }
}
