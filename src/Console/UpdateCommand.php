<?php

namespace SmartyStudio\SmartyCms\Console;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Console\Command;
use SmartyStudio\SmartyCms\Traits\HelpersTrait;

class UpdateCommand extends Command
{
	use HelpersTrait;

	protected $name = 'smartycms:update';
	protected $description = 'Update SmartyCMS Essentials';

	public function handle()
	{
		if (empty(config('smartycms'))) {
			$this->error('First install SmartyCMS with smartycms:install');

			return false;
		}

		$this->consoleSignature();

		$this->line('Migrating...');

		$migrate = Artisan::call('migrate', [
			'--path' => 'vendor/smartystudio/smartycms/src/database/migrations',
		]);

		$this->line('Migration Done!');
		$this->line('');
		$this->line('***');
		$this->line('');
		$this->line('Updating Configuration...');

		$package_config = require __DIR__ . '/../config/smartycms.php';
		$client_config = require base_path('config/smartycms.php');

		$replaceConfig = array_replace_recursive(require __DIR__ . '/../config/smartycms.php', config('smartycms'));

		foreach ($package_config as $key => $value) {
			if (!isset($client_config[$key])) {
				File::put(base_path('config/smartycms.php'), ("<?php \r\n\r\nreturn " . preg_replace(['/$([ ])/', '/[ ]([ ])/'], '    ', var_export($replaceConfig, true)) . ';'));
				$this->info('Config file ("config/smartycms.php") is merged, please see changes for new feature');
			}
		}

		$this->line('Updating Configuration Done!');
		$this->line('');
		$configureFolder = Artisan::call('storage:link', []);
		$this->line('***');
		$this->line('');
		$this->info('Successfully update!');
		$this->line(' _________________________________________________________________________________________________ ');
	}
}
