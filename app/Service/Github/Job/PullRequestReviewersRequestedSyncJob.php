<?php

namespace App\Service\Github\Job;

use App\Models\Collaborator;
use App\Models\PullRequest;
use App\Service\Github\PullRequestReviewersRequestedService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class PullRequestReviewersRequestedSyncJob implements ShouldQueue
{

    use Queueable;

    public function __construct(
        public string $repositoryFullName,
        public int $pullRequestNumber
    ) {}

    public function handle(PullRequestReviewersRequestedService $pullRequestReviewersRequestedService): void
    {
        $response = $pullRequestReviewersRequestedService->getAll(
            $this->repositoryFullName,
            $this->pullRequestNumber
        );

        foreach ($response['users'] as $collaborator) {
            $collaborator = Collaborator::updateOrCreate(
                ['login' => $collaborator['login']],
                ['api_id' => $collaborator['id']]
            );

            $pr = PullRequest::where('github_number', $this->pullRequestNumber)->first();

            $collaborator->pullRequests()->attach($pr);
        }
    }
}
