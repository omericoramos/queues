<?php

namespace App\Service\Github\Job;

use App\Service\Github\ClientService;
use App\Service\Github\PullRequestService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class PullRequestsListSyncJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public string $repositoryFullName = "",
        public ?int $page = 1,
    ) {
        //
    }
    public function handle(PullRequestService $pullRequestService): void
    {
        $pullRequests = $pullRequestService
            ->getListPullRequests($this->repositoryFullName, $this->page);

        if (empty($pullRequests)) {
            return;
        }
        
        foreach ($pullRequests as $pullRequest) {
            
            PullRequestSyncJob::dispatch(
                $this->repositoryFullName,
                $this->page,
                $pullRequest['number']
            );
        }

        $nextPage = $this->page + 1;

        echo "Estamos na listagem: {$this->page}\n";
        PullRequestsListSyncJob::dispatch($this->repositoryFullName, $nextPage);
    }
}
