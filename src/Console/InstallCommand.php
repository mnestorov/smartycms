<?php

namespace SmartyStudio\SmartyCms\Console;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use SmartyStudio\SmartyCms\Models\Admin;
use SmartyStudio\SmartyCms\Database\Seeds\DatabaseSeeder as DatabaseSeeder;
use SmartyStudio\SmartyCms\Traits\HelpersTrait;

class InstallCommand extends Command
{
	use HelpersTrait;

	protected $name = 'smartycms:install';
	protected $description = 'Install SmartyCMS Essentials';

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'smartycms:install {prefix?} {admin?} {email?} {password?}';

	public function handle()
	{
		if (!empty(config('smartycms'))) {
			$this->error('SmartyCMS already installed');

			return false;
		}

		$this->consoleSignature();

		$this->line('Configure...');

		$config = require __DIR__ . '/../config/smartycms.php';

		$prefix = '';

		if (!empty($this->argument('prefix'))) {
			$prefix = trim(preg_replace('/[^a-z-]/', '', $this->argument('prefix')), '-');
		} else {
			while (str_replace('-', '', $prefix) == '') {
				$prefix = $this->ask('Route prefix', $config['route_prefix']);
				$prefix = trim(preg_replace('/[^a-z-]/', '', $prefix), '-');
			}
		}

		$name = !empty($this->argument('admin')) ? $this->argument('admin') : $this->ask('Administrator name', 'Super Administrator');

		$email = !empty($this->argument('email')) ? $this->argument('email') : $this->ask('Administrator email', 'superadministrator@example.com');

		$password = '';

		if (!empty($this->argument('password'))) {
			$prefix = $this->argument('password');
		} else {
			while (empty($password)) {
				$password = $this->ask('Administrator password');
			}
		}

		$config_file = File::get(__DIR__ . '/../config/smartycms.php');
		$config_file = str_replace($config['route_prefix'], $prefix, $config_file);

		$this->line('Configuration Saved!');
		$this->line('');
		$this->line('***');
		$this->line('');
		$this->line('Migrating...');

		$migrate = Artisan::call('migrate', [
			'--path'  => 'vendor/smartystudio/smartycms/src/database/migrations',
			'--quiet' => true,
		]);

		$this->line('Migrating Done!');
		$this->line('');
		$this->line('***');
		$this->line('');
		$this->line('Seeding...');

		Admin::create([
			'name'     => $name,
			'email'    => $email,
			'password' => Hash::make($password),
		]);

		$seeder = new DatabaseSeeder();
		$seeder->run();

		$this->line('Seeding Done!');
		$this->line('');
		$this->line('***');
		$this->line('');
		$this->line('Publishing...');

		File::put(base_path('config/smartycms.php'), $config_file);

		$this->line('Publishing Done!');
		$this->line('');
		$this->line('***');
		$this->line('');
		$this->info('Successfully installed!');
		$this->line(' _________________________________________________________________________________________________ ');
	}
}
