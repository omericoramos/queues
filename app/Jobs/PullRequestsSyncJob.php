<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\Jobs\SyncJob;
use Illuminate\Support\Facades\Http;

class PullRequestsSyncJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public string $repositoryFullName = "",
        public ?int $page = 1
    ) {
        //
    }
    public function handle(): void
    {
        $pullrequests = Http::withToken(config("services.github.personal_access_token"))
            ->get("https://api.github.com/repos/{$this->repositoryFullName}/pulls?state=all&page={$this->page}")
            ->json();

        if (empty($pullrequests)) {
            return;
        }

        foreach ($pullrequests as $pullRequest) {
           PullRequestStoreJob::dispatch($pullRequest, $this->page);
        }

        $nextPage = $this->page + 1;

        PullRequestsSyncJob::dispatch($this->repositoryFullName,$nextPage );
    }
}
