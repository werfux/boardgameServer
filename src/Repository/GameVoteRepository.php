<?php

namespace App\Repository;

use App\Entity\GameVote;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class GameVoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GameVote::class);
    }

    public function incrementVote(string $gameId): GameVote
    {
        $gameVote = $this->find($gameId);
        
        if (!$gameVote) {
            $gameVote = new GameVote();
            $gameVote->setGameId($gameId);
        }
        
        $gameVote->incrementVoteCount();
        
        $this->getEntityManager()->persist($gameVote);
        $this->getEntityManager()->flush();
        
        return $gameVote;
    }

    public function resetVote(string $gameId): GameVote
    {
        $gameVote = $this->find($gameId);
        
        if (!$gameVote) {
            $gameVote = new GameVote();
            $gameVote->setGameId($gameId);
        }
        
        $gameVote->resetVoteCount();
        
        $this->getEntityManager()->persist($gameVote);
        $this->getEntityManager()->flush();
        
        return $gameVote;
    }

    public function resetAllVotes(): void
    {
        $gameVotes = $this->findAll();
        
        foreach ($gameVotes as $gameVote) {
            $gameVote->resetVoteCount();
            $this->getEntityManager()->persist($gameVote);
        }
        
        $this->getEntityManager()->flush();
    }

    public function getAllVotes(): array
    {
        return $this->findAll();
    }
}
