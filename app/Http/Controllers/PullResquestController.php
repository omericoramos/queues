<?php

namespace App\Http\Controllers;

use App\Models\PullResquest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PullResquestController extends Controller
{
    public function __invoke()
    {
        $pullResquests = Http::get('https://api.github.com/repos/laravel/laravel/pulls?state=all')->json();
        foreach ($pullResquests as $pullRequest) {
            PullResquest::create([
                'github_id' => $pullRequest['id'],
                'github_number' => $pullRequest['number'],
                'title' => $pullRequest['title'],
                'state' => $pullRequest['state'],
                'github_created_at' => Carbon::parse($pullRequest['created_at'])->format('Y-m-d H:i:s'),
                'github_updated_at' => Carbon::parse($pullRequest['updated_at'])->format('Y-m-d H:i:s'),
                'github_closed_at' => Carbon::parse($pullRequest['closed_at'])->format('Y-m-d H:i:s'),
                'github_merged_at' => Carbon::parse($pullRequest['merged_at'])->format('Y-m-d H:i:s'),
            ]);
        }
        dd($pullResquests);
    }
}
