<?php

namespace Spatie\BackupTool\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Spatie\Backup\Tasks\Backup\BackupJobFactory;
use Spatie\Backup\Config\Config as BackupConfig;


class CreateBackupJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    protected $option;

    public function __construct($option = '')
    {
        $this->option = $option;
    }

    public function handle()
    {
        $backupJob = BackupJobFactory::createFromConfig(BackupConfig::fromArray(config('backup')));

        if ($this->option === 'only-db') {
            $backupJob->dontBackupFilesystem();
        }

        if ($this->option === 'only-files') {
            $backupJob->dontBackupDatabases();
        }

        if (! empty($this->option)) {
            $prefix = str_replace('_', '-', $this->option).'-';

            $backupJob->setFilename($prefix.date('Y-m-d-H-i-s').'.zip');
        }

        $backupJob->run();
    }
}
