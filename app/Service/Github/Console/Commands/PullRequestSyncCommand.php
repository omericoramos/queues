<?php

namespace App\Service\Github\Console\Commands;

use App\Service\Github\Job\PullRequestsListSyncJob;
use Illuminate\Console\Command;

class PullRequestSyncCommand extends Command
{
    protected $signature = 'github:pull-request-sync-command {repositoryFullName}';

    protected $description = 'Comando para executar os jobs de sincronização da listagem de pull requests do repositório';

    public function handle()
    {
        PullRequestsListSyncJob::dispatch('laravel/laravel');
    }
}
