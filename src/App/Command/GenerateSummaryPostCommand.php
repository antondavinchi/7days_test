<?php

namespace App\Command;

use Domain\Post\PostManager;
use joshtronic\LoremIpsum;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use DateTime;

class GenerateSummaryPostCommand extends Command
{
    protected static $defaultName = 'app:generate-summary-post';
    protected static $defaultDescription = 'Run app:generate-summary-post';

    private PostManager $postManager;

    private LoremIpsum $loremIpsum;

    public function __construct(
        PostManager $postManager,
        LoremIpsum $loremIpsum,
        string $name = null
    ) {
        parent::__construct($name);

        $this->postManager = $postManager;
        $this->loremIpsum = $loremIpsum;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $currentDate = new DateTime();
        $title = "Summary " . $currentDate->format('Y-m-d');
        $content = $this->loremIpsum->paragraphs();

        $this->postManager->addPost($title, $content);

        $output->writeln('The summary post has been generated.');

        return Command::SUCCESS;
    }
}
