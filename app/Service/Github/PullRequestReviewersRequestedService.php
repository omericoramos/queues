<?php 

namespace App\Service\Github;

class PullRequestReviewersRequestedService{

    public function __construct(
        private ClientService $clientService
    ) {}
    public function getAll(string $repositoryFullName, int $pullRequestNumber): array{
        $pullRequests = $this->clientService
            ->getClient()
            ->get("/repos/{$repositoryFullName}/pulls/{$pullRequestNumber}/requested_reviewers")
            ->json();
        return $pullRequests;
    }
}