<?php

namespace SmartyStudio\SmartyCms\Console;

use Illuminate\Support\Facades\File;
use Illuminate\Console\Command;
use SmartyStudio\SmartyCms\Traits\HelpersTrait;

class DumpCommand extends Command
{
    
    use HelpersTrait;

    protected $name = 'smartycms:dump-database';
    protected $description = 'Dump DB file to .sql';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'smartycms:dump-database';

    public function handle() {
        if (empty(config('smartycms'))) {
            $this->error('ERROR: First install SmartyCms with smartycms:install');

            return false;
        }

        $this->consoleSignature();

        $this->line('Dumpping...');
        $this->line('');
        $migration = 'cms_' . gmdate('Y_m_d_His') . '.sql';

        $path = app_path('../database/cms_dumps');

        if (!File::exists($path)) {
            File::makeDirectory($path, 493, true);
        }

        $dumpMigration = $path . '/' . $migration;

        $this->info('Output path will be: ' . $dumpMigration);

        exec('mysqldump -u ' . env('DB_USERNAME') . ' -p' . env('DB_PASSWORD') . ' ' . env('DB_DATABASE') . ' -r ' . $dumpMigration . ' 2>/dev/null', $output, $return_var);

        $this->line('');

        if ($return_var != 0) {
            File::delete($dumpMigration);

            $this->error('ERROR: Dumpping error!');
        } else {
            $this->info('Dumpping done!');
        }

        $this->line('');
    }
}
