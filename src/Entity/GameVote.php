<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: 'App\Repository\GameVoteRepository')]
#[ORM\Table(name: 'game_votes')]
class GameVote
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 255)]
    private string $gameId;

    #[ORM\Column(type: 'integer')]
    private int $voteCount = 0;

    public function getGameId(): string
    {
        return $this->gameId;
    }

    public function setGameId(string $gameId): self
    {
        $this->gameId = $gameId;
        
        return $this;
    }

    public function getVoteCount(): int
    {
        return $this->voteCount;
    }

    public function setVoteCount(int $voteCount): self
    {
        $this->voteCount = $voteCount;
        
        return $this;
    }

    public function incrementVoteCount(): self
    {
        $this->voteCount++;
        
        return $this;
    }

    public function resetVoteCount(): self
    {
        $this->voteCount = 0;
        
        return $this;
    }
}
