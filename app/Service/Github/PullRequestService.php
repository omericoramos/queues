<?php


namespace App\Service\Github;

use Illuminate\Support\Facades\Http;


class PullRequestService
{
    // obtem uma lista de pull requests de um repositorio do github, passando o nome do repositorio e a pagina
    public function getListPullRequests(string $repositoryFullName, ?int $pageNumber = 1): array
    {
        $pullRequests = Http::withToken(config("services.github.personal_access_token"))
            ->get("https://api.github.com/repos/{$repositoryFullName}/pulls?state=all&page={$pageNumber}")
            ->json();

        return $pullRequests;
    }

    //obtem os dados de um pull request, passando o nome do repositorio e o numero
    public function getPullRequest(string $repositoryFullName, int $pullRequestNumber): array
    {
        $pullRequestData = Http::withToken(config("services.github.personal_access_token"))
        ->get("https://api.github.com/repos/{$repositoryFullName}/pulls/{$pullRequestNumber}")
        ->json();

        return $pullRequestData;
    }
}
