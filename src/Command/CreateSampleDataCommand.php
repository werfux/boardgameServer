<?php

namespace App\Command;

use App\Entity\GameVote;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:create-sample-data',
    description: 'Erstellt Beispieldatensätze für Game-Votes',
)]
class CreateSampleDataCommand extends Command
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $sampleData = [
            ['gameId' => '1', 'votes' => 3],
            ['gameId' => '2', 'votes' => 1],
            ['gameId' => '3', 'votes' => 4],
        ];

        foreach ($sampleData as $data) {
            $gameVote = new GameVote();
            $gameVote->setGameId($data['gameId']);
            $gameVote->setVoteCount($data['votes']);

            $this->entityManager->persist($gameVote);
        }

        $this->entityManager->flush();

        $io->success('Beispieldatensätze wurden erfolgreich erstellt!');

        return Command::SUCCESS;
    }
}