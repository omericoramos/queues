<?php

namespace App\Service\Github\Job;

use App\Models\Collaborator;
use App\Models\PullRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class PullRequestReviewerRequestedStoreJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public PullRequest $pullRequest,
        public array $collaborator
    ) {}

    public function handle()
    {

        $collaborator = Collaborator::firstOrCreate(
            ['login' => $this->collaborator['login']],
            ['api_id' => $this->collaborator['id']]
        );

        $collaborator->pullRequests()->attach($this->pullRequest);
    }
}
