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
        public PullRequest $pullRequest,
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

            PullRequestReviewerRequestedStoreJob::dispatch(
                $this->pullRequest,
                $collaborator
            );
            
        }
    }
}
