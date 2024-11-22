<?php


namespace App\Service\Github;

class PullRequestService
{
    public function __construct(
        private ClientService $clientService
    ) {}
    
    // obtem uma lista de pull requests de um repositorio do github, passando o nome do repositorio e a pagina
    public function getListPullRequests(string $repositoryFullName, ?int $pageNumber = 1): array
    {
        $pullRequests = $this->clientService
            ->getClient()
            ->get("/repos/{$repositoryFullName}/pulls?state=all&page={$pageNumber}")
            ->json();
        return $pullRequests;
    }

    //obtem os dados de um pull request, passando o nome do repositorio e o numero
    public function getPullRequest(string $repositoryFullName, int $pullRequestNumber): array
    {
        $pullRequestData = $this->clientService
            ->getClient()
            ->get("/repos/{$repositoryFullName}/pulls/{$pullRequestNumber}")->json();
        return $pullRequestData;
    }
}
