<?php

namespace App\Jobs;

use App\Models\PullRequest;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class PullRequestStoreJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public  array $pullRequestData = [],
        public int $pageNumber = 1
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        PullRequest::updateOrCreate(
            ['github_id' => $this->pullRequestData['id']],
            [
                'github_number' => $this->pullRequestData['number'],
                'title' => $this->pullRequestData['title'],
                'state' => $this->pullRequestData['state'],
                'page_number' => $this->pageNumber,
                'commits_total' => $this->pullRequestData['commits'],
                'github_created_at' => Carbon::parse($this->pullRequestData['created_at'])->format('Y-m-d H:i:s'),
                'github_updated_at' => Carbon::parse($this->pullRequestData['updated_at'])->format('Y-m-d H:i:s'),
                'github_closed_at' => Carbon::parse($this->pullRequestData['closed_at'])->format('Y-m-d H:i:s'),
                'github_merged_at' => Carbon::parse($this->pullRequestData['merged_at'])->format('Y-m-d H:i:s'),
            ]
        );
    }
}
