<?php

namespace SmartyStudio\SmartyCms;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use SmartyStudio\SmartyCms\Console\DumpCommand;
use SmartyStudio\SmartyCms\Console\UpdateCommand;
use SmartyStudio\SmartyCms\Console\InstallCommand;
use SmartyStudio\SmartyCms\Console\RestoreCommand;

class AdminServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		if (!$this->app->routesAreCached()) {
			include __DIR__ . '/routes/web.php';
		}

		// Merge auth configurations
		$auth_config = array_merge_recursive($this->app['config']['auth'], include __DIR__ . '/config/auth.php');
		$this->app['config']->set('auth', $auth_config);

		// Merge filesystems configurations
		$filesystems_config = array_merge_recursive($this->app['config']['filesystems'], include __DIR__ . '/config/filesystems.php');
		$this->app['config']->set('filesystems', $filesystems_config);

		// Set default config to uploads
		if (config('filesystems.default') === 'local') {
			config(['filesystems.default' => 'uploads']);
		}

		$this->loadViewsFrom(__DIR__ . '/resources/views/', 'admin');
		$this->loadMigrationsFrom(__DIR__ . '/database/migrations');

		$this->publishes([
			__DIR__ . '/resources/assets/dist' => public_path('vendor/smartystudio/smartycms'),
		], 'public');
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->singleton('cms', 'SmartyStudio\SmartyCms\Helpers\Cms');

		$this->app->singleton(
			'command.smartycms.install',
			function () {
				return new InstallCommand();
			}
		);

		$this->app->singleton(
			'command.smartycms.update',
			function () {
				return new UpdateCommand();
			}
		);

		$this->app->singleton(
			'command.smartycms.dump',
			function () {
				return new DumpCommand();
			}
		);

		$this->app->singleton(
			'command.smartycms.restore',
			function () {
				return new RestoreCommand();
			}
		);

		$this->commands(['command.smartycms.install']);
		$this->commands(['command.smartycms.update']);
		$this->commands(['command.smartycms.dump']);
		$this->commands(['command.smartycms.restore']);

		$this->app->register(\Intervention\Image\ImageServiceProvider::class);
		$this->app->register(\Barryvdh\DomPDF\ServiceProvider::class);

		$loader = AliasLoader::getInstance();
		$loader->alias('Image', \Intervention\Image\Facades\Image::class);
		$loader->alias('PDF', \Barryvdh\DomPDF\Facade::class);
	}
}
