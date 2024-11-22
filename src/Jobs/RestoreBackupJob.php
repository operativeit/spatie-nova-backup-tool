<?php

namespace Spatie\BackupTool\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Artisan;

class RestoreBackupJob implements ShouldQueue
{
    use Queueable;

    public $disk;
    public $path;

    /**
     * Create a new job instance.
     */
    public function __construct($disk = 'local', $path = 'latest')
    {
        $this->disk = $disk;
        $this->path = $path;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

	Artisan::call('backup:restore', [
	    '--disk' => $this->disk,
            '--backup' =>  $this->path,
            '--no-interaction' => 1,
        ]);

    }
}
