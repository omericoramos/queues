<?php

namespace App\Service\Github\Job;

use App\Models\PullRequest;
use App\Models\PullResquest;
use App\Service\Github\PullRequestService;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;

class PullRequestSyncJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected string $repositoryFullName,
        protected int $page,
        protected int $pullRequestNumber
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(PullRequestService $pullRequestService): void
    {
        $pullRequestData = $pullRequestService
            ->getPullRequest($this->repositoryFullName, $this->pullRequestNumber);

        if (empty($pullRequestData)) {
            return;
        }

        PullRequest::updateOrCreate(
            ['github_id' => $pullRequestData['id']],
            [
                'github_number' => $pullRequestData['number'],
                'title' => $pullRequestData['title'],
                'state' => $pullRequestData['state'],
                'page_number' => $this->page,
                'commits_total' => $pullRequestData['commits'],
                'github_created_at' => Carbon::parse($pullRequestData['created_at'])->format('Y-m-d H:i:s'),
                'github_updated_at' => Carbon::parse($pullRequestData['updated_at'])->format('Y-m-d H:i:s'),
                'github_closed_at' => Carbon::parse($pullRequestData['closed_at'])->format('Y-m-d H:i:s'),
                'github_merged_at' => Carbon::parse($pullRequestData['merged_at'])->format('Y-m-d H:i:s'),
            ]
        );

        PullRequestReviewersRequestedSyncJob::dispatch(
            $this->repositoryFullName,
            $this->pullRequestNumber
        );
    }
}
