<?php

namespace App\Console\Commands;

use App\Jobs\PullRequestsSyncJob;
use Illuminate\Console\Command;

class PullRequestSyncCommand extends Command
{
    protected $signature = 'app:pull-request-sync-command {repositoryFullName}';

    protected $description = 'Comando para executar os jobs de sincronização de pull requests do repositório';

    public function handle()
    {
        PullRequestsSyncJob::dispatch('laravel/laravel');
    }
}
