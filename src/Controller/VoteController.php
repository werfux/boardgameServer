<?php

namespace App\Controller;

use App\Repository\GameVoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api', name: 'api_')]
class VoteController extends AbstractController
{
    private GameVoteRepository $gameVoteRepository;

    public function __construct(GameVoteRepository $gameVoteRepository)
    {
        $this->gameVoteRepository = $gameVoteRepository;
    }

    #[Route('/vote/{gameId}', name: 'vote_get', methods: ['GET'])]
    public function getVote(string $gameId): JsonResponse
    {
        $gameVote = $this->gameVoteRepository->find($gameId);
        
        if (!$gameVote) {
            return $this->json([
                'gameId' => $gameId,
                'voteCount' => 0
            ]);
        }
        
        return $this->json([
            'gameId' => $gameVote->getGameId(),
            'voteCount' => $gameVote->getVoteCount()
        ]);
    }

    #[Route('/vote/{gameId}', name: 'vote_post', methods: ['POST'])]
    public function postVote(string $gameId): JsonResponse
    {
        $gameVote = $this->gameVoteRepository->incrementVote($gameId);
        
        return $this->json([
            'gameId' => $gameVote->getGameId(),
            'voteCount' => $gameVote->getVoteCount()
        ], Response::HTTP_OK);
    }

    #[Route('/vote/{gameId}', name: 'vote_delete', methods: ['DELETE'])]
    public function deleteVote(string $gameId): JsonResponse
    {
        $gameVote = $this->gameVoteRepository->resetVote($gameId);
        
        return $this->json([
            'gameId' => $gameVote->getGameId(),
            'voteCount' => $gameVote->getVoteCount()
        ]);
    }

    #[Route('/votes', name: 'votes_get', methods: ['GET'])]
    public function getVotes(): JsonResponse
    {
        $gameVotes = $this->gameVoteRepository->getAllVotes();
        
        $result = [];
        foreach ($gameVotes as $gameVote) {
            $result[] = [
                'gameId' => $gameVote->getGameId(),
                'voteCount' => $gameVote->getVoteCount()
            ];
        }
        
        return $this->json($result);
    }

    #[Route('/votes/reset', name: 'votes_reset', methods: ['POST'])]
    public function resetVotes(): JsonResponse
    {
        $this->gameVoteRepository->resetAllVotes();
        
        return $this->json([
            'message' => 'Alle Votes wurden zurückgesetzt'
        ]);
    }
}
